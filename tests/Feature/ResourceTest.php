<?php

namespace Tests\Feature;

use App\Http\Resources\ApiResource;
use App\Http\Resources\ApiResourceCollection;
use App\Http\Resources\DataResource;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    public function testResource(): void
    {
        self::assertEquals('{"data":[],"code":0,"message":"ok"}', (new ApiResource(null))->toResponse(request())->content());
        self::assertEquals('{"data":[],"code":0,"message":"ok"}', ApiResource::collection([])->toResponse(request())->content());
        self::assertEquals('{"data":[],"code":0,"message":"ok"}', (new ApiResourceCollection([]))->toResponse(request())->content());
        self::assertEquals('{"data":null,"code":0,"message":"ok"}', (new DataResource(null))->toResponse(request())->content());
        self::assertEquals('{"data":null,"code":0,"message":"ok"}', (new DataResource())->toResponse(request())->content());
        self::assertEquals('{"data":[],"code":0,"message":"ok"}', (new DataResource([]))->toResponse(request())->content());
    }

    public function testExceptionResponse(): void
    {
        config(['app.debug' => false]);
        $this->get('/api/user')->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
        self::assertEquals('{"data":null,"code":1000,"message":"Server Error"}', $this->getJson('/api/user')->assertSuccessful()->content());
    }
}
