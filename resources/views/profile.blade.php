@extends('layouts.main')

@section('head')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('body')

    <div class="page">
        <div class="lk">
            {{ trans('messages.lk') }}
        </div>
        <div class="personal_information">
            <div class="info_block">
                <div class="my_label my_name">
                        {{ $user_info->name }}
                </div>
                <div class="my_label my_passport">
                    {{ $user_info->passport1 }}
                    {{ $user_info->passport2 }}
                </div>
                <div class="my_label">
                    {{ $user_info->email }}
                </div>
            </div>
        </div>
        <a class="change" href="{{ url('/profile/edit') }}">{{ trans('messages.edit_button') }}</a>
        <div class="block_for_ankets">
            <div class="ankets">
                {{ trans('messages.questionnaires') }}
            </div>
            <div class="ankets_block">
                @foreach($ankets as $anket)
                    @if($anket->active)
                        <div class="my_anket">
                            <a class="my_anket_link" href="profile/get/{{ $anket->id }}" class="ankets_text">{{ $anket->name }}</a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <a class="logout" href="{{ url('/logout') }}">{{ trans('messages.logout') }}</a>
    </div>
    <script src="{{ asset("js/profile.js") }}"></script>
@endsection
