<?php

namespace App\Http\Resources;

class DataResource extends ApiResource
{
    public function __construct($resource = null)
    {
        parent::__construct($resource);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array{data: mixed}
     */
    public function toArray($request)
    {
        return [
            'data' => $this->resource,
        ];
    }
}
