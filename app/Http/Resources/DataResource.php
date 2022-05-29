<?php

namespace App\Http\Resources;

class DataResource extends ApiResource
{
    public function __construct($resource = null)
    {
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            'data' => $this->resource,
        ];
    }
}
