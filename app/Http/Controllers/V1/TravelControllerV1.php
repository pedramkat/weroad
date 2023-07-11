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
     *
     * @OA\Get(
     *      path="/api/v1/travels",
     *      tags={"api v1"},
     *      @OA\Response(
     *          response=200,
     *          description="Returns all the public travels",
     *       @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *
     *             )
     *         )
     *      ),
     * )
     *
     */
    public function index()
    {
        $lists = Travel::all();

        $list = $lists->toArray();

        // Return
        return response($list, 200, ['Content-type' => 'application/json']);
    }

}
