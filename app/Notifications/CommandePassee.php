<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommandePassee extends Notification
{
    use Queueable;
    protected $montant;
    public $user_id;
    public $admin_id;
    public $service_id;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($montant,  $user_id, $admin_id, $service_id)
    {
        $this->montant = $montant;

        $this->user_id = $user_id;
        $this->admin_id = $admin_id;
        $this->service_id = $service_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Une nouvelle commande a ete passee par ' . $notifiable->name,

            'user_id' => $this->user_id,
            'service_id' => $this->service_id,
            'admin_id' => $this->admin_id,
            'url' => '/admin/commandes',
            'type' => '',

        ];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
}
