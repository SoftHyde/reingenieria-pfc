<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentArticleReportNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name,$article,$numero,$user)
    {
        $this->article=$article;
        $this->numero = $numero;
        $this->name = $name;
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
        $article=$this->article->id;
        $numero=$this->numero;
        $name=$this->name ;
        return (new MailMessage)
                ->line('El usuario ' . $name . ' ha recibido demasiados reportes en su comentario.')
                ->action('Vealo aqui', url('editar-comentario-articulo/'.$article.'/'.$numero))
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
            'numero'=>$this->numero,
            'article_id'=>$this->article->id,
            'type' =>'reportCommentArticle'
        ];
    }
}
