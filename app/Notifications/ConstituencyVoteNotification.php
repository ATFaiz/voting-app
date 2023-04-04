<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConstituencyVoteNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    
     public function toMail($notifiable)
    {
        $votePageUrl = url(route('vote.createConstituency'));
        $expiration = now()->addDays(1);
    
        return (new MailMessage)
            ->subject('Vote in Your Constituency Now!')
            ->line('You have been invited to vote in your constituency.')
            ->line('Please click the button below to go to the vote page:')
            ->action('Vote Now', $votePageUrl)
            ->line('This link will expire on ' . $expiration->format('Y-m-d H:i:s') . '.')
            ->salutation('Thank you for voting!');
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
            //
        ];
    }
}
