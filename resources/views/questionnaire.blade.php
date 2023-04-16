@extends('layouts.main')

@section('head')
    <link href="{{ asset('css/questionnaire.css') }}" rel="stylesheet">
@endsection

@section('body')
    <div class="registration_form">
        <form class="my_form" action="{{url('/profile/get/post')}}" method="post">
            @csrf
            <div class="reg_label">
                {{ $anket_info['name'] }}
            </div>
            <input type="hidden" name="name" value="{{ $anket_info['name'] }}" />
            @foreach($anket_info as $question)
                @if($question == $anket_info['name'])
                    @continue;
                @endif
                <div class="my_label">
                    <input type="text" name="{{ $question }}" placeholder="{{ $question }}" />
                </div>
            @endforeach
            <div class="down_field">
                <input type="submit" value="Отправить">
            </div>
        </form>
    </div>
@endsection
