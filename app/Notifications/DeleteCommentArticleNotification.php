<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeleteCommentArticleNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($article,$numero,$user)
    {
        $this->article=$article;
        $this->numero = $numero;
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
        $article=$this->article->id;
        $numero=$this->numero;
        return (new MailMessage)
                ->line('Su comentario ha sido eliminado por un administrador.')
                ->action('Vealo aqui', url('article/'.$article.'/'.$numero))
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
            'numero'=>$this->numero,
            'article_id'=>$this->article->id,
            'type' =>'deleteCommentArticle'
        ];
    }
}
