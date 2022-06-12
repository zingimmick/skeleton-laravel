<?php

namespace App\Http\Resources;

use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionResource extends DataResource
{
    /**
     * @var \Throwable
     */
    public $resource;

    /**
     * @param \Illuminate\Http\Request $request
     * @return array{code: int, message: string}
     */
    public function with($request)
    {
        return match (true) {
            $this->resource instanceof HttpExceptionInterface => ['code' => $this->resource->getStatusCode(), 'message' => $this->resource->getMessage()],
            config('app.debug') => ['code' => $this->resource->getCode() ?: 1000, 'message' => $this->resource->getMessage()],
            default => ['code' => 1000, 'message' => 'Server Error']
        };
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->when(config('app.debug'), function () {
                return [
                    'exception' => get_class($this->resource),
                    'file' => $this->resource->getFile(),
                    'line' => $this->resource->getLine(),
                    'trace' => collect($this->resource->getTrace())->map(fn ($trace) => Arr::except($trace, ['args']))->all(),
                ];
            }, null),
        ];
    }
}
