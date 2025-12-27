<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KatalogReward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class KatalogRewardController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $katalog = KatalogReward::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Data katalog reward berhasil diambil',
            'data' => $katalog
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_reward' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'poin_required' => 'required|integer|min:1',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('rewards', 'public');
        }

        $katalog = KatalogReward::create([
            'nama_reward' => $request->nama_reward,
            'deskripsi' => $request->deskripsi,
            'poin_required' => $request->poin_required,
            'stok' => $request->stok,
            'gambar' => $gambarPath,
            'status' => 'active',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Reward berhasil ditambahkan',
            'data' => $katalog
        ], 201);
    }

    public function show(string $id)
    {
        $katalog = KatalogReward::find($id);

        if (!$katalog) {
            return response()->json([
                'status' => false,
                'message' => 'Reward tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail reward berhasil diambil',
            'data' => $katalog
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $katalog = KatalogReward::find($id);

        if (!$katalog) {
            return response()->json([
                'status' => false,
                'message' => 'Reward tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_reward' => 'sometimes|string|max:100',
            'deskripsi' => 'sometimes|string',
            'poin_required' => 'sometimes|integer|min:1',
            'stok' => 'sometimes|integer|min:0',
            'status' => 'sometimes|in:active,inactive',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        if ($request->hasFile('gambar')) {
            if ($katalog->gambar) {
                Storage::disk('public')->delete($katalog->gambar);
            }
            $katalog->gambar = $request->file('gambar')->store('rewards', 'public');
        }

        $katalog->update($request->except('gambar'));

        return response()->json([
            'status' => true,
            'message' => 'Reward berhasil diperbarui',
            'data' => $katalog
        ], 200);
    }

    public function destroy(string $id)
    {
        $katalog = KatalogReward::find($id);

        if (!$katalog) {
            return response()->json([
                'status' => false,
                'message' => 'Reward tidak ditemukan',
            ], 404);
        }

        if ($katalog->gambar) {
            Storage::disk('public')->delete($katalog->gambar);
        }

        $katalog->delete();

        return response()->json([
            'status' => true,
            'message' => 'Reward berhasil dihapus',
        ], 200);
    }
}
