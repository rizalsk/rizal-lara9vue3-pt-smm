<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\DetailPermintaanResource;
use App\Models\DetailPermintaan;
use Illuminate\Http\Request;

class DetailPermintaanController extends Controller
{
    public function index()
    {
        if ($details = DetailPermintaan::with([
            'permintaan' => fn($q) => $q->with('staff'),
            'barang' => fn($q) => $q->with('lokasi'),
        ])->orderBy('created_at', 'DESC')->get()) {
            return DetailPermintaanResource::collection($details)->additional([
                "message" => "List detail permintaan barang",
                "success" => true
            ]);
        }

        return response()->json([
            'message' => 'data detail permintaan barang tidak ditemukan',
            "success" => false,
        ], 400);
    }
}
