<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostStatusUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $post;
    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($post, $status)
    {
        $this->post = $post;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.post_status_update')
                    ->subject('Your Post Status Update')
                    ->with([
                        'postTitle' => $this->post->title,
                        'status' => $this->status,
                    ]);
    }
}
