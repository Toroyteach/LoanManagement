<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\User;

class LoanGuarantorsNotification extends Notification
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //$memberName = $this->user['name'];

        return (new MailMessage)->line('Dear.'.$this->user['name'])
            ->line($this->user['description'])
            ->line('Please Note if you dont respond in 24hrs it will be assumed you have accepted')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'member_id' => $this->user['id'],
            'message_desc' => $this->user['description'],
            'message_name' => $this->user['name'],
            'loan_request_id' => $this->user['loanid'],
            'notification_type' => 'GuarantorRequest',
        ];
    }
}
