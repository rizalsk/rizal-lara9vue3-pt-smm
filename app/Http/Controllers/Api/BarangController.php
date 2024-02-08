<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\BarangResource;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        if ($barangs = Barang::with(['lokasi'])->orderBy('nama', 'ASC')->get()) {
            return BarangResource::collection($barangs)->additional([
                "message" => "List data barang",
                "success" => true
            ]);
        }

        return response()->json([
            'message' => 'data barang tidak ditemukan',
            "success" => false,
        ], 400);
    }
}
