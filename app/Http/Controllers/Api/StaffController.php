<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Staff};
use App\Http\Resources\StaffResource;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        if($staff = Staff::with(['departemen'])->orderBy('nama', 'ASC')->get()){
            return StaffResource::collection($staff)->additional([
                "message" => "data staff sukses didapatkan",
                "success" => true
            ]);
        }

        return response()->json([
                'message' => 'data staff tidak ditemukan',
                "success" => false,
            ], 400);
    }
}
