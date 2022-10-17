<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetJobVacanciesRequest;
use App\Http\Requests\StoreJobVacancyRequest;
use App\Http\Requests\UpdateJobVacancyRequest;
use App\Http\Resources\JobVacancyResource;
use App\Models\JobVacancy;
use App\Repositories\JobVacancyRepositoryInterface;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    private $jobRepository;

    public function __construct(JobVacancyRepositoryInterface $repository)
    {
        $this->jobRepository = $repository;
    }
    public function index(GetJobVacanciesRequest $request)
    {
        return JobVacancyResource::collection($this->jobRepository->getAll($request->validated()));
    }

    public function show(JobVacancy $jobVacancy)
    {
        return new JobVacancyResource($jobVacancy);
    }

    public function store(StoreJobVacancyRequest $request)
    {
        return  $request->user()->createVacancy($request->validated());
    }

    public function update(UpdateJobVacancyRequest $request, JobVacancy $jobVacancy)
    {
        if (array_key_exists('tags', $request->validated())) {
            $jobVacancy->addTags($request->validated()['tags']);
        }
        $jobVacancy->update($request->validated());
        return new JobVacancyResource($jobVacancy);
    }

    public function destroy(JobVacancy $jobVacancy)
    {
        $jobVacancy->delete();
        return response()->noContent();
    }

    public function addLike(JobVacancy $jobVacancy, Request $request)
    {
        $jobVacancy->addLike($request->user()->id);
        return response()->noContent();
    }

    public function removeLike(JobVacancy $jobVacancy, Request $request)
    {
        $jobVacancy->removeLike($request->user()->id);
        return response()->noContent();
    }

    public function likedVacancies()
    {
        return JobVacancyResource::collection(JobVacancy::likedVacancies()->get());
    }

    public function likedUsersVacancies(Request $request)
    {
        $jobVacancy = new JobVacancy();
        return JobVacancyResource::collection($jobVacancy->usersVacancies($request->user()->userLiked()->get()));
    }

}
