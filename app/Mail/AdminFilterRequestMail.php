<?php

namespace App\Mail;

use App\Models\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminFilterRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email = [])
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (array_key_exists('file', $this->email)) {
            return $this->from(env('MAIL_USERNAME'))
                ->markdown('emails.admin_filter.request')
                ->attach(public_path(config('constance.excel.path') . $this->email['file']->getFile()->getFilename()))
                ->with([
                    'email' => $this->email,
                ]);
        }
        
        return $this->from(env('MAIL_USERNAME'))
                ->markdown('emails.admin_filter.request')
                ->with([
                    'email' => $this->email,
                ]);
    }
}
