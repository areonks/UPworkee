<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVacancyResponseRequest;
use App\Http\Requests\UpdateVacancyResponseRequest;
use App\Http\Resources\VacancyResponseResource;
use App\Models\VacancyResponse;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class VacancyResponseController extends Controller

{
    public function index(JobVacancy $jobVacancy)
    {
        return VacancyResponseResource::collection($jobVacancy->vacancyResponses()->paginate(10));
    }

    public function store(StoreVacancyResponseRequest $request, JobVacancy $jobVacancy)
    {
        $validatedRequest = $request->validated();
        $vacancyResponse = $request->user()->vacancyResponses()->make($validatedRequest);
        $vacancyResponse = $jobVacancy->vacancyResponses()->save($vacancyResponse);
        return new VacancyResponseResource($vacancyResponse);
    }

    public function update(UpdateVacancyResponseRequest $request, VacancyResponse $vacancyResponse)
    {
        $vacancyResponse->update($request->validated());
        return new VacancyResponseResource($vacancyResponse);
    }

    public function destroy(VacancyResponse $vacancyResponse)
    {
        $vacancyResponse->delete();
        return response()->noContent();
    }

    public function addLike(VacancyResponse $vacancyResponse, Request $request)
    {
        $vacancyResponse->addLike($request->user()->id);
        return response()->noContent();
    }

    public function removeLike(VacancyResponse $vacancyResponse, Request $request)
    {
        $vacancyResponse->removeLike($request->user()->id);
        return response()->noContent();
    }

}

