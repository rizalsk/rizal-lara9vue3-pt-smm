<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    public static $wrap = 'data';
    
    public function toArray($request)
    {
        return [
            "nik" => $this->nik,
            "nama" => $this->nama,
            "departemen" => new DepartemenResource($this->whenLoaded("departemen")),
        ];
    }
}
