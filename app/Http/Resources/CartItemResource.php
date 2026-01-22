<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'quantity' => $this->quantity,
            'price' => $this->price,
            'product_size' => [
                'id' => $this->productSize->id,
                'name' => $this->productSize->size,
                'price' => $this->productSize->price,
                'product' => [
                    'id' => $this->productSize->product->id,
                    'name' => $this->productSize->product->name,
                    'cover' => $this->productSize->product->cover,
                    'cover_url' => $this->productSize->product->cover_url,
                ],
            ],
            'subtotal' => $this->quantity * $this->productSize->price,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
