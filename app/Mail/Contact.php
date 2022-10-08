<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = $this->data['message'];

        return $this->from($this->data['email'], $this->data['name'])
        ->subject($this->data['subject'])
        ->replyTo($this->data['email'], $this->data['name'])
        ->view('emails.contact')->with([
            'the_message' => $this->data['message'],
        ]);
    }
}