<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class UserPurchasesResource extends TransactionResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  parent::toArray($request) + [
            'unit' => new UnitResource($this->resource->unit),
        ];
    }
}
