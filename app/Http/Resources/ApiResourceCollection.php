<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiResourceCollection extends ResourceCollection
{
    /** @var array{code: int, message: string} */
    public $with = ApiResource::DEFAULT_WITH;
}
