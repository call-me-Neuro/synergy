@extends('layouts.main')

@section('head')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endsection

@section('body')
<!-- <input type="checkbox" checked disabled name="remember" id="remember"> -->
<div class="block_for_ankets">
    <div class="ankets">
                {{ trans('messages.questionnaires') }}
                <a class="change" id="create" href="/admin/create/">{{ trans('messages.create') }}</a>
            </div>
    <div class="ankets_block">
        @foreach($ankets as $anket)
            <div class="my_anket">
            <div class="left">
                    <a class="my_anket_link" href="admin/q/{{ $anket->id }}" class="ankets_text">{{ $anket->name }}</a>
                    <input type="checkbox" @if($anket->active) checked @endif disabled>
                </div>
                <div class="right">
                    <a class="change" href="/admin/edit/{{ $anket->id }}">{{ trans('messages.edit_button') }}</a>
                    <a class="delete" href="/admin/delete/{{ $anket->id }}">{{ trans('messages.delete') }}</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
