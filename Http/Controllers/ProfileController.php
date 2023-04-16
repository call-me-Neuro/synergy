<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Rules\NameRule;
use App\Rules\PassportRuleTwo;
use App\Rules\PassportRuleOne;

class ProfileController extends Controller
{
    public function profile () {
        $ankets = DB::table('ankets')->where('active', 1)->get()->all();

        for ($i=0; $i<count($ankets);$i++) {
            $ankets[$i]->name = $this->get_field($ankets[$i]->name, 1);
        }

        return view('profile', ['user_info' => auth()->user(),
            'ankets' => $ankets,]);
    }


    public function profile_edit() {
        return view('profile_edit', ['user_info' => auth()->user()]);
    }

    public function profile_edit_edit (Request $request) {
        $request->validate(['username' => ['required', new NameRule],
            'passport1' => ['required', new PassportRuleOne],
            'passport2' => ['required', new PassportRuleTwo]
        ],
        [
            'username.required' => 'Please, enter your name',
            'pass1.required' => 'Please, enter your passport series',
            'pass2.required' => 'Please, enter your passport number'
        ]);

        $user = auth()->user();
        $form = [
            'name' => $request->username,
            'passport1' => $request->passport1,
            'passport2' => $request->passport2,
        ];
        $user->update($form);
        dd('success');
    }

    public function get ($id) {
        $sql_line = DB::table('ankets')->where('id', $id)->get()[0];
        $name = $sql_line->name;
        $text = DB::table($name)->get()->all();
        $array = $this->std_to_array($text[0]);
        $questions = [];
        $questions['name'] = $this->get_field($name, 1);
        for ($i=0; $i<count($array); $i++) {
            if ($i == 0 or $i == 1) {
                continue;
            }
            $questions[$i-2] = $this->get_field(array_keys($array)[$i], 1);
        }
        return view('questionnaire', ['user_info' => auth()->user(),
            'anket_info' => $questions]);
    }

    public function get_post (Request $request) {
        $name = $this->get_field($request->name, 0);
        $text = DB::table($name)->get()[0];
        $array = $this->std_to_array($text);
        $form = array_keys($array);
        array_shift($form);array_shift($form);
        
        $insert_array = [];
        for ($i=0; $i<count($form); $i++) {
            $str = $form[$i];
            $insert_array[$this->get_field($form[$i], 0)] = $request->$str;
        }
        $insert_array['user_id'] = Auth::id();

        DB::table($name)->insert($insert_array);
        return redirect('/profile'); 
    }

    private function get_field($field, $back) {
        if (!$back) {
            return strtr($field, array(' ' => '_'));
        }
        else {
            return strtr($field, array('_' => ' '));
        }
    }

    private function std_to_array($std) {
        return json_decode(json_encode($std), true);
    }
}
