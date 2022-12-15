<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentReportNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name,$comment,$user)
    {
        $this->comment=$comment;
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
        $comment=$this->comment->id;
        $name=$this->name ;
        return (new MailMessage)
                ->line('El usuario ' . $name . ' ha recibido demasiados reportes en su comentario.')
                ->action('Vealo aqui', url('editar-comentario/'.$comment))
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
            'comment_id'=>$this->comment->id,
            'type' =>'reportCommentProposal'
        ];
    }
}
