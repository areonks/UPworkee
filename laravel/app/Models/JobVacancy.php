<?php

namespace App\Models;

use App\Traits\HasLikes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed user_id
 * @property mixed id
 */
class JobVacancy extends Model
{
    use HasFactory, HasLikes;

    protected $fillable = [
        'title',
        'description',
    ];

    protected $withCount = ['likedUsers', 'vacancyResponses'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vacancyResponses()
    {
        return $this->hasMany(VacancyResponse::class, 'vacancy_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_pivots');
    }

    public function scopeLikedVacancies($query)
    {
        return $query->whereHas('likedUsers', function (Builder $query) {
            $query->whereHas('jobVacancies', function (Builder $query) {
                $query->where('user_id', '=', auth()->id());
            });
        });
    }

    public function usersVacancies($users)
    {
        $collection = collect([]);
        $users->each(function ($user) use (&$collection) {
            $collection = $collection->concat($user->jobVacancies()->get());
        });
        return $collection;
    }

    public function addTags($tags)
    {
        $tagsCollection = [];
        foreach (array_unique($tags) as $tag) {
            array_push($tagsCollection, Tag::firstOrCreate(['name' => $tag])->id);
        }
        $this->tags()->sync($tagsCollection);
    }

    public function scopeWithQueryParams($query, $params)
    {
        if (array_key_exists('tag_name', $params)) {
            return $query->orWhereHas('tags', function (Builder $query) use ($params) {
                $query->where('name', '=', $params['tag_name']);
            });
        } else {
            return $query;
        }
    }

}
