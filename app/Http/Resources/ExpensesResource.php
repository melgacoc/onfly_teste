<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Expanses;

class ExpensesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function createExpense($data)
    {
        $expense = new Expanses();
        $expense->user_id = $data['user_id'];
        $expense->amount = $data['amount'];
        $expense->description = $data['description'];
        $expense->date = $data['date'];
        $expense->save();
        return $expense;
    }


    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'amount' => $this->amount,
            'description' => $this->description,
            'date' => $this->date->format('d-m-Y'),
        ];
    }

    public function with($request): array
    {
        return [
            'status' => 'success',
            'message' => 'Expenses created successfully',
        ];
    }

    public function withResponse($request, $response): void
    {
        $response->setStatusCode(201);
    }
    
}
