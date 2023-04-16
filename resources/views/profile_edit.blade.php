@extends('layouts.main')

@section('head')
    <link href="{{ asset('css/profile_edit.css') }}" rel="stylesheet">
@endsection

@section('body')
    <div class="registration_form">
        <form action="{{url('/profile/edit/edit')}}" method="post" class="my_form">
            @csrf
            <div class="reg_label">
            {{ trans('messages.edit_profile') }}
            </div>
            <div class="my_label">
                <input type="text" name="username" value="{{ $user_info->name }}" placeholder="{{ trans('messages.name') }}" />
            </div>
            <div class="my_label">
                <input type="text" name="email" value="{{ $user_info->email }}" disabled />
            </div>

            <div class="my_label2">
                <label>{{ trans('messages.passport') }}</label>
                <div class="passport_input">
                    <input class="pass1" type="number" name="passport1" value="{{ $user_info->passport1 }}" />
                    <input class="pass2" type="number" name="passport2" value="{{ $user_info->passport2 }}" />
                </div>
            </div>
            <div class="down_field">
                <input type="submit" value="{{ trans('messages.edit_button') }}">
                <div class="mail_div">
                    <a href="{{ route('confirm.m') }}" class="change_mail">{{ trans('messages.change_email') }}</a>
                    <a href="{{ route('confirm.p') }}" class="change_mail">{{ trans('messages.change_password') }}</a>
                </div>
            </div>
        </form>
    </div>

@endsection
