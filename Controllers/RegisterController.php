<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Rules\NameRule;
use App\Rules\PassportRuleTwo;
use App\Rules\PassportRuleOne;

class RegisterController extends Controller
{
    public function index () {
        return view('registration', ['user_info'=> auth()->user()]);
    }

    
    public function register (Request $request) {
        $request->validate(['email' => 'required|email|unique:users,email',
            'username' => ['required', new NameRule],
            'passport1' => ['required', new PassportRuleOne],
            'passport2' => ['required', new PassportRuleTwo]
        ], 
        [
            'email.required' => 'Please, enter an email address',
            'email.email' => 'Please, enter a valid email addres',
            'email.unique' => 'This email address is already used',
            'username.required' => 'Please, enter your name',
            'pass1.required' => 'Please, enter your passport series',
            'pass2.required' => 'Please, enter your passport number'
        ]);

        $password = $this->create_password();
        $form = [
            'name' => $request->username,
            'email' => $request->email,
            'password' => $password[1],
            'passport1' => $request->passport1,
            'passport2' => $request->passport2,
        ];
        User::create($form);
        $data = array('name'=>$request->username,
            'password'=>$password[0]
        );
        Mail::send('emails.mail', $data, function($message) use ($request) {
            $message->to($request->email, 'Artisan Webs')
                ->subject('Пароль');
            $message->from('entrantsland@bk.ru', "Entrant's Land");
        });
        dd('done');
    }

    private function create_password () {
        $string1 = 'abcdefghijklmnopqrstuvwxyz';
        $string2 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string3 = '0123456789';
        $length = rand(15, 20);
        $string = '';
        $strings = [$string1, $string2, $string3];
        for ($i=0; $i<$length; $i++) {
            $s = substr($strings[rand(0, 2)], rand(0, 24), 1);
            $string = $string . $s;
        }
        $password = [$string, Hash::make($string)];
        return $password;
    }
}
