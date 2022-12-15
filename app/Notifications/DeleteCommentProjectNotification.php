<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeleteCommentProjectNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($project_id,$user)
    {
        $this->project_id=$project_id;
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
        $project_id= $this->project_id;
        return (new MailMessage)
                ->line('Su comentario ha sido eliminado por un administrador.')
                ->action('Vealo aqui', url('proyectos/'.$project_id))
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
            'project_id'=>$this->project_id,
            'type' =>'deleteCommentProject'
        ];
    }
}
