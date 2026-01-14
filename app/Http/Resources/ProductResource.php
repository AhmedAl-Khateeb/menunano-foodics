<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'description' => $this->description,
            'price' => $this->price,
            'cover' =>  $this->cover 
            ? url('storage/app/public/' . $this->cover)
            : null,
            'category' => [
                'name' => $this->category->name,
                'id' => $this->category->id
            ],
            'sizes' => $this->sizes->map(function ($size) {
                return [
                    'id' => $size->id,
                    'size' => $size->size,
                    'price' => $size->price,
                ];
            }),
        ];
    }
}
