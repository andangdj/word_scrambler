@extends('home')

@section('content')
    <form method="post" action="{{url('/login')}}">
        @csrf
        <div class="row gtr-uniform">
            <div class="col-6 col-12-xsmall">
                <h1 class="major" style="font-size: 23px">LOGIN</h1>
                <input type="text" name="post[username]" id="username" placeholder="Username"><br>
                <input type="password" name="post[password]" id="password" placeholder="Password"><br>
                <input type="submit" value="Login" class="primary" style="right: 0px">
            </div>
        </div>
    </form>
@endsection