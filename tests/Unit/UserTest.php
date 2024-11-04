<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Http\JsonResponse;

class UserTest extends TestCase
{

    public function test_store(): void
    {
        User::where('email', 'fulano_da_silva@email.com')->delete();
        $user = new User();
        $user->name = 'Fulano da Silva';
        $user->email = 'fulano_da_silva@email.com';
        $user->password = '123456789';

        $request = Mockery::mock(\App\Http\Requests\UserRequest::class);
        $request->shouldReceive('has')->with('message')->andReturn(false);
        $request->shouldReceive('name')->andReturn($user->name);
        $request->shouldReceive('email')->andReturn($user->email);
        $request->shouldReceive('password')->andReturn($user->password);
        $request->shouldReceive('all')->andReturn([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ]);
        $request->shouldReceive('validated')->andReturn([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $controller = $this->app->make(UserController::class);
        $response = $controller->store($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->status());
    }

    public function test_login_with_correct_credentials(): void
    {
        $userData = [
            'email' => 'fulano_da_silva@email.com',
            'password' => '123456789',
        ];

        $request = Mockery::mock(\App\Http\Requests\UserRequest::class);
        $request->shouldReceive('only')->with('email', 'password')->andReturn($userData);
        $request->shouldReceive('validate')->andReturn($userData);

        $controller = $this->app->make(UserController::class);
        $response = $controller->login($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    public function test_login_with_incorrect_credentials(): void
    {
        $userData = [
            'email' => 'beltrano_pereira@email.com',
            'password' => 'abcdefghi',
        ];

        $request = Mockery::mock(\App\Http\Requests\UserRequest::class);
        $request->shouldReceive('only')->with('email', 'password')->andReturn($userData);
        $request->shouldReceive('validate')->andReturn($userData);

        $controller = $this->app->make(UserController::class);
        $response = $controller->login($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(401, $response->status());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
