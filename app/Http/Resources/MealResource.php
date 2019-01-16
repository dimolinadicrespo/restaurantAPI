<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'id'              => $this->resource->id,
            'name'            => $this->resource->name,
            'description'     => $this->resource->description,
            'ingredients'     => IngredientResource::collection($this->resource->ingredients),
            'allergens'       => AllergenResource::collection($this->resource->allergens),
        ];
    }
}
