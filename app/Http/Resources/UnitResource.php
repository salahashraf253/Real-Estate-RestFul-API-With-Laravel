<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
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
            'name'=> $this->resource->name,
            'price'=> $this->resource->price,
            'description'=> $this->resource->description,
            'type'=> $this->resource->type,
            'location'=> $this->resource->location,
            'size'=> $this->resource->size,
            'number_of_rooms'=> $this->resource->rooms,
            'number_of_bathrooms'=> $this->resource->bathrooms,
            'city'=> $this->resource->city,
            'image'=> $this->resource->image,
            'is_sold'=> $this->resource->is_sold,
        ];
    }
}
