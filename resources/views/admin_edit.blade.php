@extends('layouts.main')

@section('head')
    <link href="{{ asset('css/admin_edit.css') }}" rel="stylesheet">
@endsection

@section('body')
    <div class="registration_form">
        <form class="my_form" action="/admin/edit/{{ $id }}/post" method="post">
            @csrf
                <div class="my_label">
                    <input type="text" name="name" value="{{ $anket_info['name'] }}" />
                </div>
            @for($i=0; $i<count($anket_info)-1; $i++)
                <div class="my_label">
                    <input type="text" name="{{ $anket_info[$i] }}" value="{{ $anket_info[$i] }}" />
                    @if($i == count($anket_info)-2) 
                    <input type="checkbox" name="active" id="active" @if($active) checked @endif>{{ trans('messages.active') }}
                    @endif
                </div>
            @endfor
            <div class="down_field">
                <input type="submit" value="{{ trans('messages.save') }}">
            </div>
        </form>
    </div>
@endsection