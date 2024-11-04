<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\Expanses;
use App\Models\User;
use App\Http\Controllers\ExpensesController;
use Illuminate\Http\JsonResponse;

class ExpensesTest extends TestCase
{
    
    public function test_store_and_delete(): void
    {
        User::where('email', 'fulana_souza@email.com')->delete();
        User::factory()->create();
        $findUser = User::where('email', 'fulana_souza@email.com')->first();
        $this->actingAs($findUser);

        $expenses = new Expanses();
        $expenses->amount = 100;
        $expenses->description = 'Teste';
        $expenses->date = '2021-10-10';
        $expenses->user_id = $findUser->id;
        
        $request = Mockery::mock(\App\Http\Requests\ExpensesRequest::class);
        $request->shouldReceive('validated')->andReturn([
            'amount' => $expenses->amount,
            'description' => $expenses->description,
            'date' => $expenses->date,
        ]);
    
        $controller = $this->app->make(ExpensesController::class);
        $response = $controller->store($request);
    
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->status());

        $deleteRequest = Mockery::mock(\Illuminate\Http\Request::class);
        $deleteRequest->shouldReceive('user')->andReturn($findUser);
        $deleteRequest->shouldReceive('id')->andReturn($response->original['expanses']['id']);
        $deleteRequest->shouldReceive('all')->andReturn([
            'user' => $findUser,
            'id' => $response->original['expanses']['id'],
        ]);

        $response = $controller->destroy($deleteRequest->id);
        $this->assertEquals(200, $response->status());
    }
}
