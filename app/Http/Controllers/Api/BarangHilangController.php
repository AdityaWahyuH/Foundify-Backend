<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangHilang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class BarangHilangController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $barang = BarangHilang::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Data barang hilang berhasil diambil',
            'data' => $barang
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'tanggal_hilang' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = JWTAuth::parseToken()->authenticate();

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('barang_hilang', 'public');
        }

        $barang = BarangHilang::create([
            'user_id' => $user->user_id,
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'tanggal_hilang' => $request->tanggal_hilang,
            'lokasi' => $request->lokasi,
            'status' => 'hilang',
            'foto' => $fotoPath,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Laporan barang hilang berhasil dibuat',
            'data' => $barang
        ], 201);
    }

    public function show(string $id)
    {
        $barang = BarangHilang::with('user', 'reward')->find($id);

        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail barang hilang berhasil diambil',
            'data' => $barang
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $barang = BarangHilang::find($id);

        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan',
            ], 404);
        }

        $user = JWTAuth::parseToken()->authenticate();

        if ($barang->user_id !== $user->user_id) {
            return response()->json([
                'status' => false,
                'message' => 'Anda tidak memiliki akses untuk mengubah data ini',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nama_barang' => 'sometimes|string|max:100',
            'deskripsi' => 'sometimes|string',
            'tanggal_hilang' => 'sometimes|date',
            'lokasi' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:hilang,ditemukan,selesai',
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
            $barang->foto = $request->file('foto')->store('barang_hilang', 'public');
        }

        $barang->update($request->except('foto'));

        return response()->json([
            'status' => true,
            'message' => 'Barang hilang berhasil diperbarui',
            'data' => $barang
        ], 200);
    }

    public function destroy(string $id)
    {
        $barang = BarangHilang::find($id);

        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan',
            ], 404);
        }

        $user = JWTAuth::parseToken()->authenticate();

        if ($barang->user_id !== $user->user_id) {
            return response()->json([
                'status' => false,
                'message' => 'Anda tidak memiliki akses untuk menghapus data ini',
            ], 403);
        }

        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return response()->json([
            'status' => true,
            'message' => 'Barang hilang berhasil dihapus',
        ], 200);
    }

    // Get barang hilang milik user yang login
    public function myItems()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $barang = BarangHilang::where('user_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data barang hilang saya berhasil diambil',
            'data' => $barang
        ], 200);
    }
}
