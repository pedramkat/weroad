<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Travel;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

define('_BOUNDIG_BOX_LIMIT', 0.1);

class TravelControllerV1 extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/travels",
     *     summary="Get all travels",
     *     description="Retrieve a list of all travels",
     *     operationId="getAllTravels",
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
     */

    public function index()
    {
        $lists = Travel::all()->toArray();

        // Return
        return response($lists, 200, ['Content-type' => 'application/json']);
    }

}
