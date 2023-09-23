<?php

namespace App\Http\Services;

use App\Http\Requests\SearchUnitRequest;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Builder;

class UnitService
{
    public static function buildFilterQuery(SearchUnitRequest $request): Builder
    {
        $request->validated();

        $query = Unit::query();
        $searchingAttributes = [
            'price',
            'bedrooms',
            'size',
            'rooms',
            'bathrooms',
            'is_sold',
        ];
        foreach ($searchingAttributes as $attribute) {
            if ($request->query($attribute)) {
                $query->where($attribute, $request->query($attribute));
            }
        }

        $likedAttributes = [
            'name',
            'city',
            'location',
            'type',
            'description',
        ];

        foreach ($likedAttributes as $attribute) {
            if ($request->query($attribute)) {
                $query->where($attribute, 'like', '%'.$request->query($attribute));
            }
        }

        return $query;
    }
}
