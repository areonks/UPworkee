<?php

namespace App\Models;

use App\Http\Resources\JobVacancyResource;
use App\Http\Resources\VacancyResponseResource;
use App\Traits\HasLikes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    use HasFactory, Notifiable, HasApiTokens, HasLikes;

    protected $fillable = [
        'username',
        'email',
        'password',
        'coins',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['likes'];

    public function getLikesAttribute()
    {
        return $this->likedUsers()->count();
    }

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class);
    }

    public function vacancyResponses()
    {
        return $this->hasMany(VacancyResponse::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function scopeUserLiked($query)
    {
        return $query->whereHas('likedUsers', function (Builder $query) {
            $query->where('user_id', '=', auth()->id());
        });
    }

    public function createVacancy($validatedRequest)
    {
        $createdVacancies = $this->jobVacancies()
            ->whereDate('created_at', '>', Carbon::now()->subDay()->toDateTimeString())
            ->count();

        if ($createdVacancies >= 2) {
            return response('You can not create more then 2 vacancies per 24hours', 403);
        }

        if ($this->coins >= 2) {
            $this->update(['coins' => $this->coins - 2]);
            $jobVacancy = $this->jobVacancies()->create($validatedRequest);
            if (array_key_exists('tags', $validatedRequest)) {
                $jobVacancy->addTags($validatedRequest['tags']);
            }
            return new JobVacancyResource($jobVacancy);
        } else {
            return response('Not enough coins', 402);
        }
    }

    public function makeResponse($validatedRequest, $jobVacancy)
    {
        $createdResponses = $jobVacancy->vacancyResponses()
            ->where('user_id', '=', auth()->id())
            ->count();

        if ($createdResponses >= 2) {
            return response('You can not send more then 2 responses for a vacancy', 403);
        }

        if ($this->coins >= 1) {
            $this->update(['coins' => $this->coins - 1]);
            $vacancyResponse = $this->vacancyResponses()->make($validatedRequest);
            $vacancyResponse = $jobVacancy->vacancyResponses()->save($vacancyResponse);
            return new VacancyResponseResource($vacancyResponse);
        } else {
            return response('Not enough coins', 402);
        }
    }
}
