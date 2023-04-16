<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rules\NameRule;
use App\Rules\PassportRuleTwo;
use App\Rules\PassportRuleOne;

class ProfileController extends Controller
{
    public function profile () {
        $ankets = DB::select('SELECT * FROM ankets WHERE active = ?', [1]);

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
        $sql_line = DB::select('select * from ankets where id=?', [$id])[0];
        $name = $sql_line->name;
        $text = DB::select('select * from '.$name);
        $array = json_decode(json_encode($text[0]), true);
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
        $text = DB::table($name)->get();
        $array = array_keys(json_decode(json_encode($text[0]), true));
        $form = ['user_id' => auth()->user()->getAuthIdentifier()];
        $sql_string = '(';
        $sql_values = '(';
        for ($i=0; $i<count($array); $i++) {
            if ($i == 0) {
                continue;
            }
            if ($i == 1) {
                $sql_string = $sql_string.$array[$i].', ';
                $sql_values = $sql_values.'?, ';
                continue;
            }
            $word = $this->get_field($array[$i], 0);
            $form[$array[$i]] = $request->$word;
            $sql_string = $sql_string.$array[$i];
            $sql_values = $sql_values.'?';
            if ($i != count($array)-1) {
                $sql_string = $sql_string.', ';
                $sql_values = $sql_values.', ';
            }
            else {
                $sql_string = $sql_string.')';
                $sql_values = $sql_values.')';
            }
        }
       # dd($form);
        $form_keys = array_keys($form);
        array_shift($form_keys);
        #dd($form_keys);
        foreach ($form_keys as $key) {
            $key = $this->get_field($key, 1);
            $request->validate([$key => 'required'],
            [
                sprintf('%s.required', $key) => sprintf('%s field is required', $key)
            ]);
        }
        $sql_line = 'INSERT INTO '.$name.' '.$sql_string.' values '.$sql_values;
        DB::insert($sql_line, array_values($form));
        #dd($sql_line, $form);
        dd($form);
    }

    private function get_field($field, $back) {
        if (!$back) {
            return strtr($field, array(' ' => '_'));
        }
        else {
            return strtr($field, array('_' => ' '));
        }
    }
}
