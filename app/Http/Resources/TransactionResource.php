<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->resource->id,
            'user_id'=> $this->resource->user_id,
            'unit_id'=> $this->resource->unit_id,
            'created_at'=> $this->resource->created_at,
            'price'=> $this->resource->price,
        ];
    }
}
