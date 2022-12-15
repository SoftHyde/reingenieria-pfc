<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Project;
class SupportCommentProjectNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name,Project $project,$user)
    {
        $this->project=$project;
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
        $project=$this->project->id;
        return (new MailMessage)
                    ->line('Su comentario ha recibido un apoyo.')
                    ->action('Vealo aqui', url('proyectos/'.$project))
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
            'project'=>$this->project->name,
            'project_id'=>$this->project->id,
            'type' =>'supportCommentProject'
        ];
    }
}
