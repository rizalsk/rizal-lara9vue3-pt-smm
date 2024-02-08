<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\DepartemenResource;
use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index(){
        if ($departemens = Departemen::orderBy('nama', 'ASC')->get()) {
            return DepartemenResource::collection($departemens)->additional([
                "message" => "List data departemen",
                "success" => true
            ]);
        }

        return response()->json([
            'message' => 'data departemen tidak ditemukan',
            "success" => false,
        ], 400);
    }
}
