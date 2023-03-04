<?php

namespace App\Http\Resources;

use App\Models\ProductCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryIndexResource extends JsonResource
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
//            'products' => ProductCategory::find($this->id)->products,
            'products' => $this->products,
//            'products' => ProductCategoryIndexResource::collection($this->products),
//            'products' => ProductIndexResource::collection($this->products),
        ];
    }
}
