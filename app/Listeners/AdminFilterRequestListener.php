<?php

namespace App\Listeners;

use App\Events\AdminFilterRequestEvent;
use App\Mail\AdminFilterRequestMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class AdminFilterRequestListener
{
    protected $event;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(AdminFilterRequestEvent $event)
    {
        $this->event = $event;
    }

    /**
     * Handle the event.
     *
     * @param  AdminFilterRequestEvent  $event
     * @return void
     */
    public function handle($event)
    {
        $mail = new AdminFilterRequestMail($event->email);
        Mail::to($event->user)->send($mail);
    }
}
