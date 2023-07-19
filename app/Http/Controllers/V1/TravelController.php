<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTravelRequest;
use App\Http\Requests\UpdateTravelRequest;
use App\Http\Resources\TravelResource;
use App\Models\Travel;

class TravelController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/travels",
     *     summary="Get all travels",
     *     description="Retrieve a list of all travels",
     *     tags={"Api v1 - Travels"},
     *     security={{ "sanctum": {} }},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Unauthorized"
     *             )
     *         )
     *     )
     * )
     *
     *
     * Give a paginated list of public travels.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $travels = Travel::where('isPublic', true)->paginate(config('weroad.perPage'));

        return TravelResource::collection($travels);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/travel",
     *     summary="Create a new travel",
     *     description="Store a newly created travel in the database",
     *     tags={"Api v1 - Travels"},
     *     security={{ "sanctum": {} }},
     *
    *     @OA\RequestBody(
    *         required=true,
    *         description="Travel details",
    *         @OA\MediaType(
    *             mediaType="application/x-www-form-urlencoded",
    *             @OA\Schema(
    *                 @OA\Property(property="isPublic", type="int", example="1"),
    *                 @OA\Property(property="name", type="string", example="new travel"),
    *                 @OA\Property(property="slug", type="string", example="new-travel"),
    *                 @OA\Property(property="description", type="string", example="content of the first travel"),
    *                 @OA\Property(property="numberOfDays", type="integer", example="10"),
    *                 @OA\Property(property="nature", type="integer", example="20"),
    *                 @OA\Property(property="relax", type="integer", example="30"),
    *                 @OA\Property(property="history", type="integer", example="40"),
    *                 @OA\Property(property="culture", type="integer", example="50"),
    *                 @OA\Property(property="party", type="integer", example="60"),
    *             )
    *         )
    *     ),
    *
    *     @OA\Response(
    *         response=200,
    *         description="Travel created successfully",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 type="object",
    *                 @OA\Property(property="message", type="string", example="Travel created successfully"),
    *             )
    *         )
    *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     )
     * )
     *
     * Store a newly created resource in storage.
     *
     * @return TravelResource
     */
    public function store(StoreTravelRequest $request): TravelResource
    {
        $travel = Travel::create($request->validated());

        return new TravelResource($travel);
    }

    /**
     *  * @OA\Put(
     *     path="/api/v1/travels/{travel:slug}",
     *     summary="Update a travel",
     *     description="Update an existing travel in the database base on the give slug",
     *     tags={"Api v1 - Travels"},
     *     security={{ "sanctum": {} }},
     *
     *     @OA\Parameter(
     *         name="travel:slug",
     *         in="path",
     *         description="slug of the travel to update",
     *         required=true,
     *         example="united-arab-emirates",
     *
     *         @OA\Schema(
     *             type="string",
     *             format="varchar",
     *         )
     *     ),
     *
    *     @OA\RequestBody(
    *         required=true,
    *         description="Travel details",
    *         @OA\MediaType(
    *             mediaType="application/x-www-form-urlencoded",
    *             @OA\Schema(
    *                 required={"isPublic", "name", "numberOfDays", "description"},
    *                 @OA\Property(property="isPublic", type="integer", format="int32", example="1"),
    *                 @OA\Property(property="name", type="string", example="new united arab emirates"),
    *                 @OA\Property(property="numberOfDays", type="integer", format="int32", example="5"),
    *                 @OA\Property(property="description", type="string", example="new content"),
    *             )
    *         )
    *     ),
    *
    *     @OA\Response(
    *         response=200,
    *         description="Travel updated successfully",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 type="object",
    *                 @OA\Property(property="message", type="string", example="Travel updated successfully"),
    *             )
    *         )
    *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     )
     * )
     *
     * Updates a an existing travel in storage.
     */
    public function update(Travel $travel, UpdateTravelRequest $request): TravelResource
    {
        $travel->update($request->validated());

        return new TravelResource($travel);
    }
}
