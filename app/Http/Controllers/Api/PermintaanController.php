<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Permintaan};
use App\Http\Resources\{PermintaanResource};

use App\Models\Barang;
use App\Models\DetailPermintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DB;

class PermintaanController extends Controller
{
    //
    public function index(Request $request) {
        if ($permintaan = Permintaan::with([
            'staff' => fn($q) => $q->with('departemen'),
        ])
            ->orderBy('created_at', 'DESC')->get()
        ) {
            return PermintaanResource::collection($permintaan)->additional([
                "message" => "List data permintaan",
                "success" => true
            ]);
        }

        return response()->json([
            'message' => 'data permintaan tidak ditemukan',
            "success" => false,
        ], 400);
    }

    public function show(Request $request, $id){
        if($permintaan = Permintaan::where('id', $id)->with([
                'staff' => fn($q) => $q->with('departemen'),
                'details' => fn($q) => $q->with(['barang' => fn($qq) => $qq->with('lokasi') ]),
            ])->first()){
            return (new PermintaanResource($permintaan))->additional([
                'message' => 'Data permintaan',
                "success" => true,
            ]);
        }
        return response()->json([
            'message' => 'data permintaan tidak ditemukan',
            "success" => false,
        ], 400);
    }
    public function store(Request $request){
        
        $validator = Validator::make($request->all(), [
            'staff_nik' => 'required',
            'tanggal_permintaan' => 'required|date',
            'nama' => 'required',
            'departemen' => 'required',
            "barangs" => "required|array|min:2",
            "barangs.*" => "required|distinct|min:2",
            "barangs.*.barang_id" => "required|numeric",
            "barangs.*.lokasi" => "required",
            "barangs.*.stock" => "required|numeric|min:1|gte:barangs.*.kuantiti",
            "barangs.*.kuantiti" => "required|numeric|min:1",
            "barangs.*.status" => "required|in:terpenuhi,tidak terpenuhi",
            "barangs.*.keterangan" => "nullable",
        ]);

        $error = null;

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        
        $data = [
            'staff_nik' => (string) $request->staff_nik,
            'tanggal_permintaan' => $request->tanggal_permintaan.':00',
        ];
        $details = $request->barangs;

        DB::beginTransaction();

        try {
            
            if($permintaan = Permintaan::create($data)){
                foreach ($details as $i => $detail) {
                    if($barang = Barang::where('id', $detail['barang_id'])->first()){
                        DetailPermintaan::create([
                            'permintaan_id' => $permintaan->id,
                            'barang_id' => $detail['barang_id'],
                            'kuantiti' => $detail['kuantiti'],
                            'keterangan' => $detail['keterangan'],
                            'status' => $detail['status'],
                        ]);

                        $barang->stock = $barang->stock - $detail['kuantiti'];
                        $barang->save();
                    }
                    
                }
            }
            DB::commit();
            if (
                $permintaan = Permintaan::where('id', $permintaan->id)->with([
                    'staff' => fn($q) => $q->with('departemen'),
                    'details' => fn($q) => $q->with(['barang' => fn($qq) => $qq->with('lokasi')]),
                ])->first()
            ) {
                return (new PermintaanResource($permintaan))->additional([
                    'message' => 'Data permintaan',
                    "success" => true,
                ]);
            }

        } catch (\Throwable $th) {
            $error = $th->getMessage();
            DB::rollback();
        }

        return response()->json([
            'data' => [],
            'message' => $error ?? 'data permintaan tidak ditemukan',
            "success" => false,
        ], 400);

        
    }

    public function destroy($id)
    {
        if($permintaan = Permintaan::where('id', $id)->first()){
            $permintaan->delete();
            DetailPermintaan::where('permintaan_id', $id)->delete();
            return response()->json([
                'message' => 'data permintaan telah terhapus',
                'success' => true,
                'data' => $permintaan
            ], 200);
        }
        
        return response()->json([
            'message' => 'data permintaan tidak ditemukan',
            'success' => false,
        ], 400);
    }
}
