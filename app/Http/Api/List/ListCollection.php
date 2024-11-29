<?php

namespace App\Http\Api\List;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\Request;

class ListCollection extends ResourceCollection
{
    public $collects = ListResource::class;

    public function toArray(Request $request): array
    {
        return ListResource::collection($this->collection)->toArray($request);
    }
}
