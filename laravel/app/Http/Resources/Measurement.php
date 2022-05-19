<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Measurement extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'session_id' => $this->session_id,
            'finger_1' => $this->finger_1,
            'finger_2' => $this->finger_2,
            'finger_3' => $this->finger_3,
            'finger_4' => $this->finger_4,
            'finger_5' => $this->finger_5,
            'created_at' => $this->created_at->format('d-m-Y H:m:s'),
            'updated_at' => $this->updated_at->format('d-m-Y H:m:s'),
        ];
    }
}
