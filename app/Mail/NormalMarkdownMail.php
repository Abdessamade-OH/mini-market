<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NormalMarkdownMail extends Mailable
{
    use Queueable, SerializesModels;
    public $object, $content,$reciever,$senderName, $senderEmail, $path;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($object, $content, $reciever, User $sender, $path)
    {
        $this->object = $object;
        $this->content = $content;
        $this->reciever = $reciever;
        $this->senderName = $sender->name;
        $this->senderEmail = $sender->email;
        $this->path = $path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(isset($this->path))
        {
            return $this->from($this->senderEmail)
            ->subject($this->object)
            ->markdown('emails.normalMarkdownMail', [
                'content' => $this->content,
                'sender' => $this->senderName,
                'reciever' => $this->reciever,
            ])->attachFromStorage($this->path);
        }
        else
        {
            return $this->from($this->senderEmail)
            ->subject($this->object)
            ->markdown('emails.normalMarkdownMail', [
                'content' => $this->content,
                'sender' => $this->senderName,
                'reciever' => $this->reciever,
            ]);
        }
    }
}
