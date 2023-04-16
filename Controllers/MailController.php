<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function test () {
        $data = array('name'=>"test name",
            'password'=>"your password"
        );
        Mail::send('emails.mail', $data, function($message) {
            $message->to('neurong@mail.ru', 'Artisan Webs')
                ->subject('Пароль');
            $message->from('entrantsland@bk.ru', "Entrant's Land");
        });
        dd('done');
    }
}
