<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\UserController;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_store(): void
    {
        $user = new User();
        $user->name = 'Fulano da Silva';
        $user->email = 'fulano_da_silva@email.com';
        $user->password = '123456789';
        $controller = $this->app->make(UserController::class);
        $request = \Mockery::mock(\App\Http\Requests\UserRequest::class);
        $request->shouldReceive('has')->with('message')->andReturn(false);
        $request->shouldReceive('validated')->andReturn([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ]);
        $response = $controller->store($request);
        $this->assertEquals(200, $response->status());

    }
}
