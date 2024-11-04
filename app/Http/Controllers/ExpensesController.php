<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expanses;
use App\Http\Services\ExpensesService;
use App\Notifications\ExpensesCreated;
use App\Http\Resources\ExpensesResource;
use App\Http\Requests\ExpensesRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ExpensesController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $user = Auth::user();
        $resource = new ExpensesResource($user->id);
        $expenses = $resource->getByUserId($user->id);
        //$expenses = Expanses::where('user_id', $user->id)->get();

        if ($expenses->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No expenses found',
            ], 404);
        }
        
        return response()->json([
            'expenses' => $expenses,
            'status' => 'success',
        ], 200);
    }

    public function store(ExpensesRequest $request)
    {
        $validatedData = $request->validated(); 

        $user = Auth::user();

        $expanses = new Expanses();
        $service = new ExpensesService();
        $expanses->amount = $validatedData['amount'];
        $expanses->description = $validatedData['description'];
        $expanses->date = $validatedData['date'];
        $expanses->user_id = $user->id;
        $response = $service->createExpense($expanses, $user);

        if ($response['id']) {
            return response()->json([
                'expanses' => $response,
                'status' => 'success',
                'message' => 'Expenses created successfully',
            ], 201);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Error creating expenses',
        ], 500);
    }

    public function destroy($id)
    {
        //$expense = Expanses::find($id);
        $resource = new ExpensesResource($id);
        $expense = $resource->getById($id);

        $this->authorize('delete', $expense);
        $service = new ExpensesService();
        $response = $service->deleteExpense($id);
        if ($response) {
            return response()->json([
                'status' => 'success',
                'message' => 'Expense deleted successfully',
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Expense not found',
        ], 404);
    }
}