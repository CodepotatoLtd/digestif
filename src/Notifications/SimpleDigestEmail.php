<?php

namespace CodepotatoLtd\Digestive\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class SimpleDigestEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public $notification_count;

    /**
     * SimpleDigestEmail constructor.
     * @param  int  $notification_count
     */
    public function __construct(int $notification_count)
    {
        $this->notification_count = $notification_count;
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
        return (new MailMessage)
            ->greeting('Hello!')
            ->line('We just thought you might like to know that you have ' . $this->notification_count . ' unread ' . Str::plural('notification', $this->notification_count)  . ' in your account')
            ->action('View notifications', url('/'))
            ->line('Thank you for using our application!');
    }
}