<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_login()
    {
        if (User::query()->where('username', 'admin')->doesntExist()) {
            $user = new User();
            $user->username = 'admin';
            $user->password = Hash::make('123456');
            $user->save();
        }
        $response = $this->postJson('/api/auth/login', [
            'username' => 'admin',
            'password' => '123456',
        ]);
        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->where('code', 0)
                ->whereType('data.token', 'string')
                ->where('data.token_type', 'Bearer')
                ->whereType('data.expires_in', 'integer')
                ->etc();
        }

        );
        $response = $this->postJson('/api/auth/login', [
            'username' => 'admin',
            'password' => '1234561',
        ]);
        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->where('code', 1000)->whereType('data', 'array')->etc();
        }
        );
    }

    public function actingAs(UserContract $user, $guard = null)
    {
        $test = parent::actingAs($user, $guard);
        $test->withToken(\auth()->guard($guard)->login($user));

        return $test;
    }

    public function testLogout()
    {
        $response = $this->actingAs(User::query()->where('username', 'admin')->first(), 'api')
            ->postJson('/api/auth/logout');
        $response->assertStatus(200);
        $response->dump();
    }

    public function testMe()
    {
        $response = $this->actingAs(User::query()->where('username', 'admin')->first(), 'api')
            ->getJson('/api/auth/me');
        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->where('code', 0)
                ->whereType('data.id', 'integer')
                ->whereType('data.nickname', 'string|null')
                ->whereType('data.avatar', 'string|null')
                ->etc();
        });
    }
}
