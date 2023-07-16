<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTravelRequest;
use App\Http\Requests\UpdateTravelRequest;
use App\Http\Resources\TravelResource;
use App\Models\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/travels",
     *     summary="Get all travels",
     *     description="Retrieve a list of all travels",
     *     tags={"Api v1 - Travels"},
     *     security={{ "sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Travel")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Unauthorized"
     *             )
     *         )
     *     )
     * )
     *
     * @OA\Schema(
     *     schema="Travel",
     *     title="Travel",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="Travel ID"
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         description="Travel name"
     *     ),
     *     @OA\Property(
     *         property="destination",
     *         type="string",
     *         description="Travel destination"
     *     ),
     * )
     * 
     * Give a paginated list of public travels.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Using eloquent
        $travels = Travel::where('isPublic', true)->paginate(config('weroad.perPage'));
        return TravelResource::collection($travels);
    }

    /**
     *  * @OA\Post(
    *     path="/api/v1/travels",
    *     summary="Create a new travel",
    *     description="Store a newly created travel in the database",
    *     tags={"Api v1 - Travels"},
    *     security={{ "sanctum": {} }},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Travel created successfully",
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Validation error",
    *     )
    * )
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTravelRequest $request)
    {
        $travel = Travel::create($request->validated());

        return new TravelResource($travel);
    }

    /**
     * 
     *  * @OA\Put(
    *     path="/api/v1/travels/{travel:slug}",
    *     summary="Update a travel",
    *     description="Update an existing travel in the database base on the give slug",
    *     tags={"Api v1 - Travels"},
    *     security={{ "sanctum": {} }},
    *     @OA\Parameter(
    *         name="travel",
    *         in="path",
    *         description="ID of the travel to update",
    *         required=true,
    *         @OA\Schema(
    *             type="integer",
    *             format="int64"
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
    *         description="Travel updated successfully",
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Validation error",
    *     )
    * )
     * 
     * Updates a an existing travel in storage.
     *
     * @param \App\Models\Travel $travel
     * @param  \Illuminate\Http\Requests\UpdateTravelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Travel $travel, UpdateTravelRequest $request)
    {
        $travel->update($request->validated());
        
        return new TravelResource($travel);
    }
}
