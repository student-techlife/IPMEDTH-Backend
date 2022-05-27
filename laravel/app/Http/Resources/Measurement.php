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
            'hand_type' => $this->hand_type,
            'hand_view' => $this->hand_view,
            'hand_score' => $this->hand_score,
            'finger_thumb' => $this->finger_thumb,
            'finger_index' => $this->finger_index,
            'finger_middle' => $this->finger_middle,
            'finger_ring' => $this->finger_ring,
            'finger_pink' => $this->finger_pink,
            'wrist' => $this->wrist,
            'image' => $this->image,
            'created_at' => $this->created_at->format('d-m-Y H:m:s'),
            'updated_at' => $this->updated_at->format('d-m-Y H:m:s'),
        ];
    }
}
