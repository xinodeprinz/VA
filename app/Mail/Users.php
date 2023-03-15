<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Users extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $data;
    protected $user;

    public function __construct(object $user, array $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('EMAIL'), config('app.name'))
            ->subject($this->data['subject'])
            ->replyTo(env('EMAIL'), config('app.name'))
            ->view('emails.users')->with([
            'user' => $this->user,
            'data' => $this->data,
        ]);
    }
}
