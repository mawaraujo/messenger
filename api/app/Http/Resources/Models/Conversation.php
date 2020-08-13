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
            'contact' => new UserResource($this->whenLoaded('contact')),
            'listen_notifications' => $this->listen_notifications,
            'last_message' => $this->last_message,
            'last_time' => $this->last_time,
            'has_blocked' => $this->has_blocked,
            'created_at' => $this->created_at
        ];
    }
}
