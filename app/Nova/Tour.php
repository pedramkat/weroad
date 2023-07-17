<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Tour extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Tour>
     */
    public static $model = \App\Models\Tour::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array<int,string>
     */
    public static $search = [
        'name', 'travel.name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int,mixed>
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Date::make('Starting Date', 'startingDate')
                ->displayUsing(function ($value) {
                    return $value->format('Y-m-d');
                })
                ->sortable()
                ->rules('required', 'date'),

            Date::make('Ending Date', 'endingDate')
                ->displayUsing(function ($value) {
                    return $value->format('Y-m-d');
                })
                ->rules('required', 'date'),

            // Number::make('Price', 'price')
            //     ->displayUsing(function ($value) {
            //         return $this->price; // Access the accessor method
            //     }),
            Currency::make('Price', 'price')
                ->currency('EUR'),

            BelongsTo::make('Travel', 'travel', 'App\Nova\Travel')
                ->searchable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array<int,mixed>
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int,mixed>
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array<int,mixed>
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array<int,mixed>
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
