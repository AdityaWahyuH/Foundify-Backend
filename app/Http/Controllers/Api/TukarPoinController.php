<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TukarPoin;
use App\Models\KatalogReward;
use App\Models\Poin;
use App\Models\RiwayatPoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class TukarPoinController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $tukar = TukarPoin::with('user', 'katalogReward')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Data penukaran berhasil diambil',
            'data' => $tukar
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'katalog_id' => 'required|exists:katalog_reward,katalog_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = JWTAuth::parseToken()->authenticate();

        // Cek reward
        $reward = KatalogReward::find($request->katalog_id);
        if ($reward->status !== 'active') {
            return response()->json([
                'status' => false,
                'message' => 'Reward tidak tersedia',
            ], 400);
        }

        if ($reward->stok < 1) {
            return response()->json([
                'status' => false,
                'message' => 'Stok reward habis',
            ], 400);
        }

        // Cek poin user
        $poin = Poin::where('user_id', $user->user_id)->first();
        if (!$poin || $poin->total_poin < $reward->poin_required) {
            return response()->json([
                'status' => false,
                'message' => 'Poin tidak mencukupi',
            ], 400);
        }

        // Kurangi poin
        $poin->total_poin -= $reward->poin_required;
        $poin->save();

        // Kurangi stok
        $reward->stok -= 1;
        $reward->save();

        // Buat transaksi
        $tukar = TukarPoin::create([
            'user_id' => $user->user_id,
            'katalog_id' => $request->katalog_id,
            'jumlah_poin' => $reward->poin_required,
            'status' => 'pending',
        ]);

        // Catat riwayat poin
        RiwayatPoin::create([
            'poin_id' => $poin->poin_id,
            'jumlah_poin' => -$reward->poin_required,
            'keterangan' => 'Tukar poin - ' . $reward->nama_reward,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Penukaran poin berhasil',
            'data' => $tukar
        ], 201);
    }

    public function show(string $id)
    {
        $tukar = TukarPoin::with('user', 'katalogReward')->find($id);

        if (!$tukar) {
            return response()->json([
                'status' => false,
                'message' => 'Data penukaran tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail penukaran berhasil diambil',
            'data' => $tukar
        ], 200);
    }

    // Verifikasi penukaran oleh admin
    public function verify(Request $request, string $id)
    {
        $tukar = TukarPoin::find($id);

        if (!$tukar) {
            return response()->json([
                'status' => false,
                'message' => 'Data penukaran tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:completed,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        // Jika cancelled, kembalikan poin dan stok
        if ($request->status === 'cancelled') {
            $poin = Poin::where('user_id', $tukar->user_id)->first();
            $poin->total_poin += $tukar->jumlah_poin;
            $poin->save();

            $reward = KatalogReward::find($tukar->katalog_id);
            $reward->stok += 1;
            $reward->save();

            RiwayatPoin::create([
                'poin_id' => $poin->poin_id,
                'jumlah_poin' => $tukar->jumlah_poin,
                'keterangan' => 'Penukaran dibatalkan - ' . $reward->nama_reward,
            ]);
        }

        $tukar->status = $request->status;
        $tukar->save();

        return response()->json([
            'status' => true,
            'message' => 'Status penukaran berhasil diperbarui',
            'data' => $tukar
        ], 200);
    }

    // Get riwayat penukaran user
    public function riwayat()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $tukar = TukarPoin::with('katalogReward')
            ->where('user_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Riwayat penukaran berhasil diambil',
            'data' => $tukar
        ], 200);
    }
}
