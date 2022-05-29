<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    public const DEFAULT_WITH = [
        'code' => 0,
        'message' => 'ok',
    ];

    public $with = self::DEFAULT_WITH;

    public static function collection($resource)
    {
        return tap(parent::collection($resource), function (AnonymousResourceCollection $collection) {
            $collection->with = self::DEFAULT_WITH;
        });
    }
}
