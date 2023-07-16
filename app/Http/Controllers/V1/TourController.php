<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTourRequest;
use App\Http\Requests\StoreTourRequest;
use App\Http\Resources\TourResource;
use App\Models\Travel;

class TourController extends Controller
{
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
     * Store a newly created resource in storage.
     * 
     * @return object
     */
    public function store(Travel $travel, StoreTourRequest $request): object
    {
        $tour = $travel->tours()->create($request->validated());
        
        return new TourResource($tour);
    }
}
