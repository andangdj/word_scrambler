<!DOCTYPE HTML>
<html>
    <head>
        <title>{{ config('app.name') }}</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @include('template.header')
    </head>
    <body class="is-preload">

        <!-- Sidebar -->
            <section id="sidebar" style="overflow-y: inherit;overflow-x: inherit;">
                <div class="col-12 col-12-xsmall">
                    <h1 style="font-size: 23px;margin-bottom: -2%">Word Scramble</h1>
                </div>
                <div class="inner">
                    <nav>
                        @if (Session::get('LOGGED'))
                        <ul>
                            <li><a href="{{url('/play')}}" id="mn_play" class="scrolly ">Play</a></li>
                            <li><a href="{{url('/highscore')}}" id="mn_score" class="scrolly ">Score</a></li>
                            <li><a href="{{url('/logout')}}">logout</a></li>
                        </ul>
                        @else
                        <ul>
                            <li><a href="{{url('/login')}}" id="mn_login" class="scrolly ">Login</a></li>
                            <li><a href="{{url('/register')}}" id="mn_register" class="scrolly ">Register</a></li>
                        </ul>
                        @endif
                    </nav>
                </div>
            </section>

        <!-- Wrapper -->
            <div id="wrapper">
                    
                <!-- Intro -->
                    <section id="intro" class="wrapper style1 fullscreen fade-up">
                        <div class="inner">
                            @yield('content')
                        </div>
                    </section>
            </div>

    </body>
    @include('template.footer') 
    @yield('script')
</html>