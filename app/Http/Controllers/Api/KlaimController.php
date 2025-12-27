<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Klaim;
use App\Models\BarangDitemukan;
use App\Models\Poin;
use App\Models\RiwayatPoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class KlaimController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $klaim = Klaim::with('user', 'barangDitemukan')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Data klaim berhasil diambil',
            'data' => $klaim
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_ditemukan_id' => 'required|exists:barang_ditemukan,barang_ditemukan_id',
            'bukti_kepemilikan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = JWTAuth::parseToken()->authenticate();

        // Cek apakah barang masih tersedia
        $barang = BarangDitemukan::find($request->barang_ditemukan_id);
        if ($barang->status !== 'tersedia') {
            return response()->json([
                'status' => false,
                'message' => 'Barang sudah tidak tersedia untuk diklaim',
            ], 400);
        }

        // Cek apakah user sudah pernah klaim barang ini
        $existingKlaim = Klaim::where('user_id', $user->user_id)
            ->where('barang_ditemukan_id', $request->barang_ditemukan_id)
            ->first();

        if ($existingKlaim) {
            return response()->json([
                'status' => false,
                'message' => 'Anda sudah mengajukan klaim untuk barang ini',
            ], 400);
        }

        $klaim = Klaim::create([
            'user_id' => $user->user_id,
            'barang_ditemukan_id' => $request->barang_ditemukan_id,
            'bukti_kepemilikan' => $request->bukti_kepemilikan,
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Klaim berhasil diajukan',
            'data' => $klaim
        ], 201);
    }

    public function show(string $id)
    {
        $klaim = Klaim::with('user', 'barangDitemukan')->find($id);

        if (!$klaim) {
            return response()->json([
                'status' => false,
                'message' => 'Klaim tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail klaim berhasil diambil',
            'data' => $klaim
        ], 200);
    }

    // Verifikasi klaim oleh admin
    public function verify(Request $request, string $id)
    {
        $klaim = Klaim::find($id);

        if (!$klaim) {
            return response()->json([
                'status' => false,
                'message' => 'Klaim tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,rejected',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        $klaim->status = $request->status;
        $klaim->verified_at = now();
        $klaim->save();

        // Jika approved, update status barang dan beri poin
        if ($request->status === 'approved') {
            // Update status barang
            $barang = BarangDitemukan::find($klaim->barang_ditemukan_id);
            $barang->status = 'diklaim';
            $barang->save();

            // Beri poin ke user (contoh: 10 poin per klaim approved)
            $poin = Poin::where('user_id', $klaim->user_id)->first();
            if ($poin) {
                $poin->total_poin += 10;
                $poin->save();

                // Catat riwayat poin
                RiwayatPoin::create([
                    'poin_id' => $poin->poin_id,
                    'jumlah_poin' => 10,
                    'keterangan' => 'Klaim barang disetujui - ' . $barang->nama_barang,
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Klaim berhasil diverifikasi',
            'data' => $klaim
        ], 200);
    }

    // Get klaim milik user yang login
    public function myKlaims()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $klaim = Klaim::with('barangDitemukan')
            ->where('user_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data klaim saya berhasil diambil',
            'data' => $klaim
        ], 200);
    }
}
