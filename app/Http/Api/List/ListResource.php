<?php

namespace App\Http\Api\List;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{

    public function toArray(Request $request)
    {
        return [
            "id"=> $this->resource->id,
            "name"=> $this->resource->name,
            "brewery_type"=> $this->resource->brewery_type,
            "city"=> $this->resource->city,
            "state_province"=> $this->resource->state_province,
            "postal_code"=> $this->resource->postal_code,
            "country"=> $this->resource->country,
            "phone"=> $this->resource->phone,
            "website_url"=> $this->resource->website_url,
            "state"=> $this->resource->state,
            "street"=> $this->resource->street
        ];


    }
}
