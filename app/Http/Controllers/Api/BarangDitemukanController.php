<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangDitemukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class BarangDitemukanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $barang = BarangDitemukan::with('user')  // GANTI admin jadi user
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Data barang ditemukan berhasil diambil',
            'data' => $barang
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'tanggal_ditemukan' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'lokasi_barang_ditemukan' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = JWTAuth::parseToken()->authenticate();  // GANTI admin jadi user

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('barang_ditemukan', 'public');
        }

        $barang = BarangDitemukan::create([
            'user_id' => $user->user_id,  // GANTI admin_id jadi user_id
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'tanggal_ditemukan' => $request->tanggal_ditemukan,
            'lokasi' => $request->lokasi,
            'lokasi_barang_ditemukan' => $request->lokasi_barang_ditemukan,
            'status' => 'tersedia',
            'foto' => $fotoPath,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Laporan barang ditemukan berhasil dibuat',
            'data' => $barang
        ], 201);
    }

    public function show(string $id)
    {
        $barang = BarangDitemukan::with('user', 'klaim')->find($id);  // GANTI admin jadi user

        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail barang ditemukan berhasil diambil',
            'data' => $barang
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $barang = BarangDitemukan::find($id);

        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_barang' => 'sometimes|string|max:100',
            'deskripsi' => 'sometimes|string',
            'tanggal_ditemukan' => 'sometimes|date',
            'lokasi' => 'sometimes|string|max:255',
            'lokasi_barang_ditemukan' => 'sometimes|string|max:255',
            'jadwal_penjemputan' => 'sometimes|date',
            'lokasi_penjemputan' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:tersedia,diklaim,selesai',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        if ($request->hasFile('foto')) {
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }
            $barang->foto = $request->file('foto')->store('barang_ditemukan', 'public');
        }

        $barang->update($request->except('foto'));

        return response()->json([
            'status' => true,
            'message' => 'Barang ditemukan berhasil diperbarui',
            'data' => $barang
        ], 200);
    }

    public function destroy(string $id)
    {
        $barang = BarangDitemukan::find($id);

        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan',
            ], 404);
        }

        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return response()->json([
            'status' => true,
            'message' => 'Barang ditemukan berhasil dihapus',
        ], 200);
    }
}
