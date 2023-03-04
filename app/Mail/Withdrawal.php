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

    protected $user;
    protected $code;
    protected $amount;

    public function __construct(object $user, string $code, int $amount)
    {
        $this->user = $user;
        $this->code = $code;
        $this->amount = $amount;
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
            ->view('emails.withdrawal')->with([
            'user' => $this->user,
            'code' => $this->code,
            'amount' => $this->amount,
        ]);
    }
}