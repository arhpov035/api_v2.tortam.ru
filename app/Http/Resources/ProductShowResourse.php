<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductShowResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'published' => $this->published,
            'image' => $this->image,
            'intro_text' => $this->intro_text,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'user' => new UserResource($this->user),
            'category' => new ProductCategoryIndexResource($this->category),
            'article' => $this->article,
            'price_up' => $this->price_up,
            'price_after' => $this->price_after,
            'type_products' => $this->type_products,
            'coverage' => $this->coverage,
            'weight_photo' => $this->weight_photo,
            'number_tiers' => $this->number_tiers,
            'congratulatory_signature' => $this->congratulatory_signature,
        ];
    }
}
