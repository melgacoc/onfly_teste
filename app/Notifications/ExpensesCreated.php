<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpensesCreated extends Notification
{
    use Queueable;

    protected $expanses;

    public function __construct($expanses)
    {
        $this->expanses = $expanses;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Expense Created')
                    ->line('Description: ' . $this->expanses->description)
                    ->line('Amount: ' . $this->expanses->amount);
    }

    public function toArray($notifiable)
    {
        return [
            'amount' => $this->expanses->amount,
            'description' => $this->expanses->description,
        ];
    }
}
