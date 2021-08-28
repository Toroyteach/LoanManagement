<?php

namespace App\Notifications;

use App\LoanApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubmittedAnalysisNotification extends Notification
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
                    ->line('The analysis of application has been submitted')
                    ->line('Decision: ' . $this->loanApplication->status->name)
                    ->line('Comment: ' . $this->loanApplication->comments()->latest()->first()->comment_text)
                    ->action('See Application', route('admin.loan-applications.show', $this->loanApplication))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'loan_id' => $this->loanApplication->loan_entry_number,
            'message_desc' => 'Please review the folowing status change',
            'message_desc_1' => $this->loanApplication->status->name,
            'message_comment' => $this->loanApplication->comments()->latest()->first()->comment_text,
            'notification_type' => 'StatusAnalysis',
        ];
    }
}
