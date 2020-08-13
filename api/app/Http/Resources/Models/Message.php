<?php

namespace App\Http\Resources\Models;

use Illuminate\Http\Resources\Json\JsonResource;
use DB;

class Message extends JsonResource
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
            'from_id' => $this->from_id,
            'from_me' => DB::raw($this->from_id . ' ' . 'as me'),
            'to_id' => $this->to_id,
            'content' => $this->content,
            'created_at' => $this->created_at
        ];
    }
}
