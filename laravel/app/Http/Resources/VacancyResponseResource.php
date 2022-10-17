<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VacancyResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'content' => $this->content,
            'likes' => $this->liked_users_count,
            'isLiked' => $this->is_liked,
            'created_at'=> $this->created_at,
        ];
    }
}
