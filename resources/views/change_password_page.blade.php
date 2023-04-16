@extends('layouts.main')

@section('head')
    <link href="{{ asset('css/change_password.css') }}" rel="stylesheet">
@endsection

@section('body')
    <div class="registration_form">
        <form class="my_form" action="{{url('/change/p/create')}}" method="post">
            @csrf
            <div class="reg_label">
            {{ ucfirst(trans('messages.change_password')) }}
            </div>
            <div class="my_label">
                <input type="text" name="password" placeholder="{{ trans('messages.password') }}" />
            </div>
            <div class="my_label">
                <input type="text" name="password2" placeholder="{{ trans('messages.new_password') }}" />
            </div>
            <div class="down_field">
                <input type="submit" value="{{ trans('messages.edit_button') }}">
            </div>
        </form>
    </div>
@endsection
