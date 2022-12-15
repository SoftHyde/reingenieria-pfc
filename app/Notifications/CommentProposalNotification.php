<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Proposal;

class CommentProposalNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name,Proposal $proposal,$user)
    {
        $this->proposal=$proposal;
        $this->name = $name;
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
        if($this->user->email_notification){
            return ['database','mail'];
        }
        else{
        return ['database'];
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $proposal=$this->proposal->id;
        return (new MailMessage)
                ->line('Su propuesta recibio un comentario.')
                ->action('Vealo aqui', url('propuesta/'.$proposal))
                ->line('Gracias!');
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
            'name' => $this->name,
            'proposal'=>$this->proposal->title,
            'proposal_id'=>$this->proposal->id,
            'type' =>'commentProposal'
        ];
    }
}
