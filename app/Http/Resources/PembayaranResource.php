<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PembayaranResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id_pembayaran' =>$this->id_pembayaran,
            'id_siswa' =>$this->id_siswa,
            'id_user' =>$this->id_user,
            'tanggal_pembayaran' =>$this->tanggal_pembayaran
        ];
    }
}
