<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expanses;
use Illuminate\Support\Facades\Mail;
use App\Notifications\ExpensesCreated;

class ExpansesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'description' => 'required',
            'date' => 'required',
        ]);
        $user = Auth::user();

        $expanses = new Expanses();
        $expanses->amount = $request->amount;
        $expanses->description = $request->description;
        $expanses->date = $request->date;
        $expanses->user_id = $user->id;
        $expanses->save();
        //$user->notify(new ExpensesCreated($expanses));

        Mail::send([], [], function ($message) use ($user, $expanses) {
            $message->to('claudio19a@hotmail.com');
            $message->subject('New Expense Created');
            $message->html('Description: ' . $expanses->description . '<br>Amount: ' . $expanses->amount);
        });

        return response()->json([
            'expanses' => [
                'amount' => $expanses->amount,
                'description' => $expanses->description,
                'date' => $expanses->date,
            ],
            'status' => 'success',
            'message' => 'Expanses created successfully',
        ], 201);
    }
}