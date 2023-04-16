<?php

namespace App\Http\Controllers;


use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;

class MySiteController extends Controller
{

    public function set_locale($locale) {
        session(['locale' => $locale]);
        App::setLocale($locale);
        $user = auth()->user();
        $user->update(['language' => $locale]);
        return redirect()->back();
    }

    public function confirm_email ($id) {
        $sql = DB::table('confirms')->where('code', $id)->get()[0];

        $time1 = Carbon::parse($sql->created_at)->addMinutes(10);
        $time2 = Carbon::now()->addHours(3);
        $time1->addMinutes($sql->time);

        if ($time2->lessThan($time1)) {
            auth()->user()->update(["new_value"=>$sql->new_value]);
            $deleted = DB::delete('delete from confirms where code = ?', [$id]);
        }
        return redirect('/profile');
    }

    public function change_email_create (Request $request) {
        #dd($request->email2);
        $request->validate(['email2' => 'required|email'],
        [
            'email2.required' => 'Enter your new email',
            'email2.email' => 'Enter valid emal'
        ]);
        $code = $this->create_password();
        $time = 10;
        $insert_array = [$code, $time, $request->email2];
        DB::table('confirms')->insert($insert_array);
        dd($code);
    }
    public function change_email_page () {
        return view('change_email_page', ['user_info' => auth()->user()]);
    }








    public function confirm_password ($id) {
        $sql = DB::select('SELECT * from confirms WHERE code = ?', [$id])[0];
        #dd($sql->new_value, Crypt::decry);
        $time1 = Carbon::parse($sql->created_at)->addMinutes(10);
        $time2 = Carbon::now()->addHours(3);
        $time1->addMinutes($sql->time);
        if ($time2->lessThan($time1)) {
            $password = Crypt::decryptString($sql->new_value);
            $password = Hash::make($password);
            auth()->user()->update(["password"=>$password]);
            $deleted = DB::delete('delete from confirms where code = ?', [$id]);
        }
        return redirect('/profile');
    }

    public function change_password_create (Request $request) {
        $request->validate(['password2' => 'required|string|min:8|max:64']);
        $hashedPassword = auth()->user()->password;
        if (!Hash::check($request->password, $hashedPassword)) {
            return redirect()->back()->withErrors(['wrong password']);
        }
        


        $code = $this->create_password();
        $time = 10;
        $password = Crypt::encryptString($request->password2);
        #dd($password, $password2);
        $sql_values = [$code, $time, $password];
        DB::insert('INSERT INTO confirms (code, time, new_value) values (?, ?, ?)', $sql_values);
        dd($code);
    }
    public function change_password_page () {
        return view('change_password_page', ['user_info' => auth()->user()]);
    }

    public function home () {
        return view('home', ['user_info' => auth()->user()]);
    }

    private function create_password () {
        $string1 = 'abcdefghijklmnopqrstuvwxyz';
        $string2 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string3 = '0123456789';
        $length = 40;
        $string = '';
        $strings = [$string1, $string2, $string3];
        for ($i=0; $i<$length; $i++) {
            $s = substr($strings[rand(0, 2)], rand(0, 24), 1);
            $string = $string . $s;
        }
        return $string;
    }
}
