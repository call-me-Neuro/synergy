<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    @yield('head')
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <a href="#">
                    <img src="{{ asset('images/logo.png') }}" alt="Bootstrap" width="200" height="50">
                </a>
            </div>

            @if(!auth()->check())
                @if(app()->getLocale() == 'ru')
                <div class="right_block_guest">
                    <a class="lang-btn" href="{{ route('setlocale', 'en') }}">{{ strtoupper(app()->getLocale()) }}</a>
                    <a href="{{ route('login') }}">
                    {{ trans('messages.in') }}
                    </a>
                    <a href="{{ route('registration') }}" class="border_guest">
                    {{ trans('messages.up') }}
                    </a>
                </div>
            @else
                <div class="right_block_guest2">
                    <a class="lang-btn" href="{{ route('setlocale', 'ru') }}">{{ strtoupper(app()->getLocale()) }}</a>
                    <a href="{{ route('login') }}">
                    {{ trans('messages.in') }}
                    </a>
                    <a href="{{ route('registration') }}" class="border_guest2">
                    {{ trans('messages.up') }}
                    </a>
                </div>
            @endif
            @else
            @if(app()->getLocale() == 'ru')
            <div class="right_block">
                <a class="lang-btn" href="{{ route('setlocale', 'en') }}">{{ strtoupper(app()->getLocale()) }}</a>
                <a href="{{ route('profile') }}" class="border">
            @else
            <div class="right_block2">
                <a class="lang-btn" href="{{ route('setlocale', 'ru') }}">{{ strtoupper(app()->getLocale()) }}</a>
                <a href="{{ route('profile') }}" class="border2">
            @endif
                    {{ trans('messages.lk') }}
                </a>
            </div>
            @endif
        </div> <!-- header closed -->
            <div class="main">
            @if ($errors->any())
                <div class="errors_div">
                    <ul calss="errors_ul">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @yield('body')
            </div>
    </div>
</body>
</html>
