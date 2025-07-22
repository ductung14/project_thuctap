<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'status' => $this->status,
            'max_participants' => $this->max_participants,
            'category_id' => $this->category_id,
            'organizer' => $this->organizer ? $this->organizer->name : null,
            'created_at' => $this->created_at,
        ];
    }
}