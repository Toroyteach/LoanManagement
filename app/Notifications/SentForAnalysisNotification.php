<?php

namespace App\Notifications;

use App\LoanApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SentForAnalysisNotification extends Notification
{
    use Queueable;

    /**
     * @var LoanApplication
     */
    private $loanApplication;

    public function __construct(LoanApplication $loanApplication)
    {
        $this->loanApplication = $loanApplication;
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
        return (new MailMessage)
                    ->line('A request for loan application analysis has been sent to you.')
                    ->action('See Application', route('admin.loan-applications.show', $this->loanApplication))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'loan_id' => $this->loanApplication->loan_entry_number,
            'message_desc' => 'You have a loan application request to analyse',
            'notification_type' => 'LoanAnalysis',
        ];
    }
}
