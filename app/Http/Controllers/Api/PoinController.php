<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Poin;
use App\Models\RiwayatPoin;
use Tymon\JWTAuth\Facades\JWTAuth;

class PoinController extends Controller
{
    // Get total poin user
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $poin = Poin::where('user_id', $user->user_id)->first();

        if (!$poin) {
            return response()->json([
                'status' => true,
                'message' => 'Data poin berhasil diambil',
                'data' => [
                    'total_poin' => 0
                ]
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data poin berhasil diambil',
            'data' => $poin
        ], 200);
    }

    // Get riwayat poin user
    public function riwayat()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $poin = Poin::where('user_id', $user->user_id)->first();

        if (!$poin) {
            return response()->json([
                'status' => true,
                'message' => 'Data riwayat poin berhasil diambil',
                'data' => []
            ], 200);
        }

        $riwayat = RiwayatPoin::where('poin_id', $poin->poin_id)
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data riwayat poin berhasil diambil',
            'data' => $riwayat
        ], 200);
    }
}
