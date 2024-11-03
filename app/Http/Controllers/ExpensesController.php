<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expanses;
use Illuminate\Support\Facades\Mail;
use App\Http\Services\ExpensesService;
use App\Notifications\ExpensesCreated;

class ExpensesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $expenses = Expanses::where('user_id', $user->id)->get();

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

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'description' => 'required',
            'date' => 'required',
        ]);
        $user = Auth::user();

        $expanses = new Expanses();
        $service = new ExpensesService();
        $expanses->amount = $request->amount;
        $expanses->description = $request->description;
        $expanses->date = $request->date;
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

    # fazer passagem para a service
    public function delete($id)
    {
        $user = Auth::user();
        $expense = Expanses::where('user_id', $user->id)->where('id', $id)->first();
        if ($expense) {
            $expense->delete();
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