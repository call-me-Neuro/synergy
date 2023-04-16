<?php

namespace App\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PhpOption\None;

class AdminController extends Controller
{
    public function index () {
        $ankets = DB::table('ankets')->get()->all();

        for ($i=0; $i<count($ankets);$i++) {
            $ankets[$i]->name = $this->get_field($ankets[$i]->name, 1);
        }

        return view('admin', ['user_info' => auth()->user(),
        'ankets' => $ankets]);
    }

    public function create_get () {
        return view('create', ['user_info' => auth()->user()]);
    }

    public function delete_questionnaire($id) {
        $sql_line = DB::table('ankets')->where('id', $id)->get()[0];
        $name = $sql_line->name;
        $deleted = DB::delete('delete from ankets where id=?', [$id]);
        DB::statement('drop table '.$name);
        dd('succes');
    }

    public function get_qs ($id) {
        $sql_line = DB::table('ankets')->where('id', $id)->get()[0];
        $name = $sql_line->name;
        $questionnaires = DB::table($name)->get()->all();
        $array = json_decode(json_encode($questionnaires[0]), true);
        $questions = [];
        $questions['name'] = $this->get_field($name, 1);
        for ($i=0; $i<count($array); $i++) {
            if ($i == 0 or $i == 1) {
                continue;
            }
            $questions[$i-2] = $this->get_field(array_keys($array)[$i], 0);
        }
        #dd($questions, $questionnaires[1]);

        return view('admin_qs', ['qs' => $questionnaires, 'questions' => $questions]);
    }

    public function edit_page ($id) {
        $sql_line = DB::table('ankets')->where('id', $id)->get()[0];
        $name = $sql_line->name;
        $active = $sql_line->active;
        $text = DB::table($name)->get()->all();
        $array = $this->arr_to_array($text[0]);
        $questions = [];
        $questions['name'] = $this->get_field($name, 1);
        for ($i=0; $i<count($array); $i++) {
            if ($i == 0 or $i == 1) {
                continue;
            }
            $questions[$i-2] = $this->get_field(array_keys($array)[$i], 1);
        }
        return view('admin_edit', ['user_info' => auth()->user(),
            'anket_info' => $questions,
            'active' => $active,
            'id' => $id]);
    } 

    public function edit_page_post (Request $request, $id) {
        $request->validate(['name' => 'required']);
        $name = DB::table('ankets')->where('id', $id)->get()[0]->name;
        $sql = DB::table($name)->where('id', 1)->get()[0];
        $sql = $this->std_to_array($sql);
        $sql = array_keys($sql);
        $new_values = [];
        $new_name = $this->get_field($request->name, 0);
        for ($i=0; $i<count($sql); $i++) {
            if ($i == 0 || $i == 1) {
                continue;
            }
            $request->validate([$sql[$i] => 'required']);
            $str = $sql[$i];
            if ($this->get_field($request->$str, 0) != $sql[$i]) {
                $new_values[$sql[$i]] = $this->get_field($request->$str, 0);
            }
        }
        for ($i=0; $i<count($new_values); $i++) {
            Schema::table($name, function(Blueprint $table) use ($new_values, $i) {
                $table->renameColumn(array_keys($new_values)[$i], $new_values[array_keys($new_values)[$i]]);
            });
        }

        if ($name != $new_name) {
            Schema::rename($name, $this->get_field($request->name,0));
            DB::table('ankets')->where('name',$name)->update($form);
        }

        if ($request->active == 'on') {
            $status = 1;
        }
        else {
            $status = 0;
        }
        DB::table('ankets')->where('name',$name)->update(['active' => $status]);
        
        return redirect('/admin');
    }

    public function create_post (Request $request) { # post zapros
        $request->validate(['form_name' => 'required']);
        $counter = $request->counter;
        $form = [];
        $form_name = $this->get_field($request->form_name, 0);
        if (Schema::hasTable($form_name)) {
            dd('Данная таблица уже существует');
        }
        for ($i=1; $i<$counter+1; $i++) {
            $temp1 = 'field'.$i;
            $form[$temp1] = $request->$temp1;
        }
        $form = array_values($form);
        $insert_array = [];
        for ($i=0; $i<count($form); $i++) {
            $insert_array[$this->get_field($form[$i], 0)] = '0';
        }
        $insert_array['user_id'] = 2;
        
        Schema::create($form_name, function (Blueprint $table) use ($form) {
            $table->id();
            $table->integer('user_id');
            for ($i=0; $i<count($form); $i++) {
                $word = $this->get_field($form[$i], 0);
                $table->string($word);

            }
        });

        DB::table('ankets')->insert([
            'name' => $form_name,
            'active' => 1
        ]);
        DB::table($form_name)->insert($insert_array); #this line is neccesary to get keys of table using this row
        dd('ok');
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
