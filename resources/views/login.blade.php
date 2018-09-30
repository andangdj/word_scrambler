@extends('home')

@section('content')
    <form id="formLogin" action="#" method="post">
        @csrf
        <div class="row gtr-uniform">
            <div class="col-6 col-12-xsmall">
                <h1 class="major" style="font-size: 23px">LOGIN</h1>
                <input type="text" name="post[username]" id="username" placeholder="Username"><br>
                <input type="password" name="post[password]" id="password" placeholder="Password"><br>
                <button id="btn" class="primary" style="float: left;margin-right: 20px">Sign in</button>
                <h4 id="msg" style="font-weight: 600;margin-top: 0.8em"></h4>
            </div>
        </div>
    </form>
@endsection

@section('script')
<script type="text/javascript">
    $("#mn_login").addClass('active');
    $( "#btn" ).click(function(e) {
        e.preventDefault();
        if ($('#username').val() == "") {
            $('#msg').css('color','#d29300'); 
            $('#msg').html('Fill your username');
        }else if($('#password').val() == ""){
            $('#msg').css('color','#d29300'); 
            $('#msg').html('Fill your password');
        }else{
            $.ajax({
                url: '/login',
                type: 'post',
                data: $('#formLogin').serialize(), // Remember that you need to have your csrf token included
                dataType: 'json',
                success: function( data ){
                    var arrData = JSON.parse(JSON.stringify(data));
                    if(arrData.status == "sukses"){
                        $('#msg').css('color','#00e000  ');
                        $('#msg').html(arrData.msg);
                        setTimeout(function(){ window.location = '/'; }, 3000);
                    }else{
                        $('#msg').css('color','#d29300'); 
                        $('#msg').html(arrData.msg);
                    }
                    
                }
            });
        }
        
    });
</script>
@endsection