<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cover' => $this->cover
                ? asset('storage/' . $this->cover)
                : null,
            'products' => $this->whenLoaded('products', ProductResource::collection($this->products)) ?? null
        ];
    }
}
