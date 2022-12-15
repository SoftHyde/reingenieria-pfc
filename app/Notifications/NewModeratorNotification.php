<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Project;

class NewModeratorNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Project $project,$user)
    {
        $this->project=$project;
        $this->user=$user;
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
        $project_id= $this->project->id;
        $name=$this->project->name;
        return (new MailMessage)
                ->line('Ha sido elegido como moderador del proyecto '.$name.' .')
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
            'project'=>$this->project->name,
            'project_id'=>$this->project->id,
            'type' =>'newModeratorProject'
        ];
    }
}
