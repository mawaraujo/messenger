<?php

namespace App\Http\Resources\Models;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'image' => 'users/profile_image' . '/' . $this->image,
            'chat_background' => 'users/chat_background' . '/' . $this->chat_background,
            'chat_status' => $this->chat_status
        ];
    }
}
