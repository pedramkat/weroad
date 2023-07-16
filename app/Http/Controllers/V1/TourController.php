<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTourRequest;
use App\Http\Requests\StoreTourRequest;
use App\Http\Resources\TourResource;
use App\Models\Travel;

class TourController extends Controller
{
    /**
     * 
     *  * @OA\Get(
    *     path="/api/v1/travels/{travel:slug}/tours",
    *     summary="Retrieve tours for a specific travel",
    *     description="Get a list of tours for a specific travel based on the provided filters",
    *     tags={"Api v1 - Tours"},
    *     @OA\Parameter(
    *         name="travel",
    *         in="path",
    *         description="Slug of the travel to retrieve tours for",
    *         required=true,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="priceFrom",
    *         in="query",
    *         description="Minimum price for filtering tours",
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="priceTo",
    *         in="query",
    *         description="Maximum price for filtering tours",
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="dateFrom",
    *         in="query",
    *         description="Minimum starting date for filtering tours",
    *         @OA\Schema(
    *             type="string",
    *             format="date"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="dateTo",
    *         in="query",
    *         description="Maximum ending date for filtering tours",
    *         @OA\Schema(
    *             type="string",
    *             format="date"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="sortBy",
    *         in="query",
    *         description="Field to sort the tours by",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="sortOrder",
    *         in="query",
    *         description="Sorting order ('asc' or 'desc')",
    *         @OA\Schema(
    *             type="string",
    *             enum={"asc", "desc"}
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="List of tours for the specified travel",
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Validation error",
    *     )
    * )
    * 
     * Give a paginated list of the Tours of the specified Travel.
     * 
     * @param \App\Models\Travel $travel
     * @param  \Illuminate\Http\Requests\IndexTourRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Travel $travel, IndexTourRequest $request)
    {
        $tours = $travel->tours()
            ->when($request->priceFrom, function ($query) use ($request) {
                $query->where('price', '>=', $request->priceFrom * 100);
            })
            ->when($request->priceTo, function ($query) use ($request) {
                $query->where('price', '<=', $request->priceTo * 100);
            })
            ->when($request->dateFrom, function ($query) use ($request) {
                $query->where('startingDate', '>=', $request->dateFrom);
            })
            ->when($request->dateTo, function ($query) use ($request) {
                $query->where('endingDate', '<=', $request->dateTo);
            })
            ->when($request->sortBy && $request->sortOrder, function ($query) use ($request) {
                $query->orderBy($request->sortBy, $request->sortOrder);
            })
            ->orderBy('startingDate')
            ->paginate(config('weroad.perPage'));

        return TourResource::collection($tours);
    }

    /**
     * 
     *  * @OA\Post(
    *     path="/api/v1/travels/{travel:slug}/tour",
    *     summary="Create a new tour for a travel",
    *     description="Store a newly created tour for a specific travel in the database",
    *     tags={"Api v1 - Tours"},
    *     security={{ "sanctum": {} }},
    *     @OA\Parameter(
    *         name="travel",
    *         in="path",
    *         description="Slug of the travel to associate the tour with",
    *         required=true,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Tour created successfully",
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Validation error",
    *     )
    * )
     * 
     * Store a newly created resource in storage.
     * 
     * @param \App\Models\Travel $travel
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Travel $travel, StoreTourRequest $request): object
    {
        $tour = $travel->tours()->create($request->validated());
        
        return new TourResource($tour);
    }
}
