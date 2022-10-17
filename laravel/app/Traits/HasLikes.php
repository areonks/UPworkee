<?php


namespace App\Traits;

use App\Models\User;

trait HasLikes
{
    public function likedUsers()
    {
        return $this->morphToMany(User::class, 'likeable', 'likes', null, 'user_id');
    }

    public function addLike($userId)
    {
        $this->likedUsers()->syncWithoutDetaching($userId);
    }

    public function removeLike($userId)
    {
        $this->likedUsers()->detach($userId);
    }

    public function getIsLikedAttribute()
    {
        return (boolean)$this->likedUsers()->where('user_id', '=', auth()->id())->first();
    }
}
