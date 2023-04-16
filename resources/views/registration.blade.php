@extends('layouts.main')

@section('head')
    <link href="{{ asset('css/registration.css') }}" rel="stylesheet">
@endsection

@section('body')
<div class="registration_form">
    <form action="{{url('/register')}}" method="post" class="my_form">
        @csrf
        <div class="reg_label">
            {{ trans('messages.sign_up') }}
        </div>
        <div class="my_label">
            <input type="text" name="username" placeholder="{{ trans('messages.name') }}" value="{{ old('username') }}" />
        </div>
        <div class="my_label">
            <input type="text" name="email" placeholder="Email" value="{{ old('email') }}" />
        </div>

        <div class="my_label2">
            <label>{{ trans('messages.passport') }}</label>
            <div class="passport_input">
                <input class="pass1" type="number" name="passport1" placeholder="0000" value="{{ old('passport1') }}" />
                <input class="pass2" type="number" name="passport2" placeholder="000000" value="{{ old('passport2') }}" />      
            </div>          
        </div>
        <div class="down_field">
            <input type="submit" value="{{ trans('messages.up') }}">
            <div class="text2">
                    <a href="{{ route('login') }}">{{ trans('messages.in') }}</a>
            </div>
        </div>
    </form>
</div>

@endsection
