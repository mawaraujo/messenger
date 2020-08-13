<?php

namespace App\Http\Resources\Models;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Models\User as UserResource;

class Conversation extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'contact_id' => $this->contact_id,
            'created_at' => $this->created_at,
            'contact' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
