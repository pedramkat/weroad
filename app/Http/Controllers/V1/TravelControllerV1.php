<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use App\Models\Travel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
        // Using eloquent
        $travels = Travel::where('isPublic', true)->paginate(5);
        return TravelResource::collection($travels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Auth::user();
        try {
            $request->validate([
                'ticket_type' => [
                    'required',
                    Rule::in(['reservation', 'info', 'abandonment', 'report']),
                ],
            ]);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

        // Create Ticket
        $ticket = new Ticket();
        $ticket->ticket_type = $request->ticket_type;
        $ticket->company_id = $request->id;
        $ticket->user_id = Auth::user()->id;
        if ($request->exists('trash_type_id')) {
            $ticket->trash_type_id = $request->trash_type_id;
        }
        if ($request->exists('note')) {
            $ticket->note = $request->note;
        }
        if ($request->exists('phone')) {
            $ticket->phone = $request->phone;
        }
        if ($request->exists('image')) {
            $ticket->image = $request->image;
        }
        if ($request->exists('location')) {
            $ticket->geometry = (DB::select(DB::raw("SELECT ST_GeomFromText('POINT({$request->location[1]} {$request->location[0]})') as g;")))[0]->g;

            // Curl request to get the feature information from external source
            $lat = $request->location[0];
            $lon = $request->location[1];
            $url = "https://nominatim.openstreetmap.org/reverse?lat=$lat&lon=$lon&format=json";
            $response = $this->curlRequest($url);

            if ($response) {
                if (array_key_exists('display_name', $response)) {
                    $ticket->location_address = $response['display_name'];
                }
                if (array_key_exists('error', $response)) {
                    $ticket->location_address = $response['error'];
                }
            }
        }
        $res = $ticket->save();

        // Send a notification email to company for the newly created ticket
        if ($res) {
            $company = Company::find($request->id);
            if ($company->ticket_email) {
                foreach (explode(',', $company->ticket_email) as $recipient) {
                    Mail::to($recipient)->send(new TicketCreated($ticket, $company));
                }
            }
        }

        // Response
        return $this->sendResponse($ticket, 'Ticket created.');
    }
}
