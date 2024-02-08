<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\LokasiResource;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index(Request $request)
    {
        if ($lokasis = Lokasi::orderBy('nama', 'ASC')->get()) {
            return LokasiResource::collection($lokasis)->additional([
                "message" => "List data lokasi",
                "success" => true
            ]);
        }

        return response()->json([
            'message' => 'data lokasi tidak ditemukan',
            "success" => false,
        ], 400);
    }
}
