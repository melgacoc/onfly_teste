<?php

namespace App\Http\Services;

use App\Http\Resources\ExpensesResource;
use Illuminate\Support\Facades\Mail;

class ExpensesService
{
    public function createExpense($data, $user)
    {
        $expense = new ExpensesResource($data);
        $response = $expense->create($data);

        if ($response) {
            $expanses = $response;
            Mail::send([], [], function ($message) use ($user, $expanses) {
                $message->to($user->email);
                $message->subject('New Expense Created');
                $message->html('Description: ' . $expanses['description'] . '<br>Amount: R$ ' . $expanses['amount']);
            });
            return $response;
        }
    }

    public function deleteExpense($id)
    {
        $expense = new ExpensesResource($id);
        $response = $expense->delete($id);

        if ($response) {
            return $response;
        }
    }
}