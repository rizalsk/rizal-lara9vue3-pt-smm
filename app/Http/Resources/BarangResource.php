<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BarangResource extends JsonResource
{
    public static $wrap = 'data';
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "code" => $this->code,
            "nama" => $this->nama,
            "lokasi_id" => $this->lokasi_id,
            "lokasi" => new LokasiResource($this->whenLoaded("lokasi")),
            "stock" => $this->stock,
            "satuan" => $this->satuan,
        ];
    }
}
