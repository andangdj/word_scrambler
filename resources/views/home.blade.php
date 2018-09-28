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
            <section id="sidebar">
                <div class="inner">
                    <nav>
                        @if (Session::get('LOGGED'))
                        <ul>
                            <li><a href="#intro">Play</a></li>
                            <li><a href="#one">Score</a></li>
                        </ul>
                        @else
                        <ul>
                            <li><a href="{{url('/login')}}">Login</a></li>
                            <li><a href="{{url('/register')}}">Register</a></li>
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