<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Withdrawal extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $data;

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
        return $this->from(env('EMAIL'), config('app.name'))
            ->subject(config('app.name') . ' Withdrawal')
            ->replyTo(env('EMAIL'), config('app.name'))
            ->view('emails.withdrawal')->with([
            'data' => $this->data,
        ]);
    }
}