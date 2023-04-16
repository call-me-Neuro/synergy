@extends('layouts.main')

@section('head')
    <link href="{{ asset('css/change_email.css') }}" rel="stylesheet">
@endsection

@section('body')
    <div class="registration_form">
        <form class="my_form" action="{{url('/change/m/create')}}" method="post">
            @csrf
            <div class="reg_label">
                {{ ucfirst(trans('messages.change_email')) }}
            </div>
            <div class="my_label">
                <input type="text" name="email1" value="{{ $user_info->email }}" disabled />
            </div>
            <div class="my_label">
                <input type="text" name="email2" placeholder="{{ trans('messages.new_email') }}" value="{{ old('email') }}" />
            </div>
            <div class="down_field">
                <input type="submit" value="{{ trans('messages.edit_button') }}">
            </div>
        </form>
    </div>
@endsection
