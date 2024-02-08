<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermintaanResource extends JsonResource
{
    public static $wrap = 'data';

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "staff_nik" => $this->staff_nik,
            "tanggal_permintaan" => $this->tanggal_permintaan,
            "status" => $this->status,
            "details" => DetailPermintaanResource::collection($this->whenLoaded("details")),
            "staff" => new StaffResource($this->whenLoaded("staff")),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
