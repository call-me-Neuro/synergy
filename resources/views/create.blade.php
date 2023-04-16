@extends('layouts.main')

@section('head')
    <link href="{{ asset('css/create.css') }}" rel="stylesheet">


@endsection

@section('body')

    <div class="registration_form">
        
        <form class="my_form" action="{{url('/admin/create/create')}}" method="post">
            @csrf
            <div class="reg_label">{{ trans('messages.createq') }}</div>
            <input type="number" id="counter" name="counter" value=1 hidden>
            <div class="my_label">
                <input type="text" class="my_input" name="form_name" placeholder="{{ trans('messages.qname') }}" value="{{ old('form_name') }}">
            </div>
            <div class="just_input">
                <input type="text" class="my_input" name="field1" placeholder="{{ trans('messages.question') }}">
            </div>
            <div id="down_field">
                <input type="submit" id="submit_id" value="{{ trans('messages.create') }}">
                <button id="my_button" type="button">+</button>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="{{ asset('js/create.js') }}" rel="script"></script>
@endsection
