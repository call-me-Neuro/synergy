@extends('layouts.main')

@section('head')
    <link href="{{ asset('css/admin_qs.css') }}" rel="stylesheet">
@endsection

@section('body')
{{ $questions['name'] }}
@for ($i=0; $i<count($qs); $i++)
<div class="block">
    <div class="user_id"> User ID: {{ $qs[$i]->user_id }}</div>
    @for ($j=0; $j<count($questions)-1; $j++)
        <div class="question"> {{ $questions[$j] }}: {{ $qs[$i]->{$questions[$j]} }}</div>
    @endfor
</div>
@endfor

@endsection
