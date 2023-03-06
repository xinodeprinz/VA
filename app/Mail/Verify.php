<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Verify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;
    protected $code;

    public function __construct(object $user, string $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('EMAIL'), config('app.name'))
            ->subject(__('main.Verify Email Address'))
            ->view('emails.verify')->with([
            'user' => $this->user,
            'code' => $this->code,
        ]);
    }
}
