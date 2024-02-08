<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailPermintaanResource extends JsonResource
{
    public static $wrap = 'data';
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'permintaan' =>  new PermintaanResource($this->whenLoaded("permintaan")),
            'barang' =>  new BarangResource($this->whenLoaded("barang")),
            'kuantiti' => $this->kuantiti,
            'keterangan' => $this->keterangan,
            'status' => $this->status,
        ];
    }
}
