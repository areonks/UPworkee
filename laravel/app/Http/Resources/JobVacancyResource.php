<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed user
 */
class JobVacancyResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'likes' => $this->liked_users_count,
            'isLiked' => $this->is_liked,
            'created_at' => $this->created_at,
            'tags' => TagResource::collection($this->tags),
            'responses' => $this->vacancy_responses_count
        ];
    }
}
