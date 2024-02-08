<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartemenResource extends JsonResource
{
    public static $wrap = 'data';
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama
        ];
    }
}
