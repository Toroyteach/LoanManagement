<?php

namespace App\Notifications;

use App\LoanApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Auth;

class NewApplicationNotification extends Notification
{
    use Queueable;

    /**
     * @var LoanApplication
     */
    private $loanApplication;

    public function __construct(LoanApplication $loanApplication)
    {
        $this->loanApplication = $loanApplication;
        //dd($loanApplication);
        //dd($loanApplication->created_by->email === Auth::user()->email);
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

        // if($this->loanApplication->created_by->email === Auth::user()->email){

        //     return (new MailMessage)
        //     ->line('Dear .'.$this->loanApplication->created_by->name.'. Your New loan application has been submitted')
        //     ->action('See Application', route('admin.loan-applications.show', $this->loanApplication))
        //     ->line('Thank you for using our application!');

        // } else {

            return (new MailMessage)
            ->line('New loan application has been created')
            ->action('See Application', route('admin.loan-applications.show', $this->loanApplication))
            ->line('Thank you for using our application!');

        //}

    }

    public function toArray($notifiable)
    {
        return [
            'loan_id' => $this->loanApplication->id,
            'message_name' => $this->loanApplication->created_by->firstname,
            'message_desc' => 'A new loan Application was created',
            'notification_type' => 'NewLoanApplication',
        ];
    }
}
