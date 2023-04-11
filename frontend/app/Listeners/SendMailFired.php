<?php

namespace App\Listeners;

use App\Events\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class SendMailFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendMail  $event
     * @return void
     */
    public function handle(SendMail $event)
    {
        //
        $data = $event->data;
        // dd($data['user']['name']);
        // dd($consult,$consult['pet_id'], $event,$consult['created_at']);
        $user_name = $data['user']['name'];
        $user_email = $data['user']['email'];
        $pet_name = $data['pet']['pet_name'];
        $appointment_date = $data['appointment']['appointment_date'];
        //dd($commt);

        Mail::send('email.appointment', ['name' => $user_name, 'email' => $user_email, 'pet_name' => $pet_name, 'appointment_date' => $appointment_date], function ($message) use ($data) {
            $message->from('support@petpal.com', 'Admin');
            $message->to(
                $data['user']['email'],
                $data['user']['name'],
            );
            $message->subject('Appointment confirmed');
            // $message->attach(public_path('images/logo.png'));
        });
    }
}
