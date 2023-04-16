@extends('layouts.main')

@section('head')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('body')

<div class="registration_form">
    <form class="my_form" action="{{url('/logister')}}" method="post">
        @csrf
        <div class="reg_label">
        {{ trans('messages.sign_in') }}
        </div>
        <div class="my_label">
            <input type="text" name="email" placeholder="Email" value="{{ old('email') }}" />
        </div>
        <div class="my_label">
            <input type="password" name="password" placeholder="{{ trans('messages.password') }}" />
            <input type="checkbox" name="remember" id="remember">{{ trans('messages.remember') }}
        </div>
        
        <div class="down_field">
            <input type="submit" value="{{ trans('messages.in') }}">
            <div class="text2">
                <a href="{{ route('registration') }}">{{ trans('messages.up') }}</a>
            </div>
        </div>
    </form>
</div>
@endsection
