@extends('home')

@section('content')
    <form id="formRegister" action="#" method="post">
        @csrf
        <div class="row gtr-uniform">
            <div class="col-8 col-12-xsmall">
                <h1 class="major" style="font-size: 23px">Registration</h1>
                <input type="email" name="post[email]" id="email" placeholder="Email"><br>
                <input type="text" name="post[name]" id="name" placeholder="Name"><br>
                <input type="text" name="post[username]" id="username" placeholder="Username"><br>
                <input type="password" name="post[password]" id="password" placeholder="Password"><br>
                <button id="btn" class="primary" style="float: left;margin-right: 20px">Register</button><h5 id="msg" style="font-weight: 300"></h5>
            </div>
        </div>
    </form>
@endsection

@section('script')
<script type="text/javascript">
    $( "#btn" ).click(function(e) {
        e.preventDefault();
        $.ajax({
            url: '/register',
            type: 'post',
            data: $('#formRegister').serialize(), // Remember that you need to have your csrf token included
            dataType: 'json',
            success: function( data ){
                var arrData = JSON.parse(JSON.stringify(data));
                //alert(arrData.msg);
                if(arrData.status == "sukses"){
                    $('#msg').css('color','#1bff00');
                    $('#msg').html(arrData.msg);
                    setTimeout(function(){ window.location = '/login'; }, 3000);
                }else{
                    $('#msg').css('color','#fd5656'); 
                    $('#msg').html(arrData.msg);
                }
                
            }
        });
    });
</script>
@endsection