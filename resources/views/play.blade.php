@extends('home')

@section('content')
<style type="text/css">
    ::-webkit-input-placeholder {
       text-transform: initial;
    }

    :-moz-placeholder { 
       text-transform: initial;
    }

    ::-moz-placeholder {  
       text-transform: initial;
    }

    :-ms-input-placeholder { 
       text-transform: initial;
    }
</style>
    <form id="formPlay" action="#" method="post">
        @csrf
        <input type="hidden" name="post[key]" id="key">
        <div class="row gtr-uniform" style="margin-top: -15%">
            @if (Session::get('play_id'))
            <div class="col-12 col-12-xsmall">
                <h1 class="major" style="font-size: 23px;margin-bottom: 5%"><span id="count"></span> to 10 <span style="float: right;">Score : <span id="score"></span> </span></h1>
            </div>
            @endif
            <div class="col-12 col-12-xsmall" align="center">
                @if (Session::get('play_id'))
                <table style="width: auto" id="word" cellspacing="5px">
                    <tbody></tbody>
                </table>
                <br><br>
                <table style="width: auto;border-collapse: inherit;" cellspacing="5px" align="center">
                    <tr>
                        <td align="center">
                            <input type="text" name="post[answer]" id="answer" placeholder="Type the correct word" style="text-align: center;text-transform: uppercase">
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <button id="btnSubmit" class="primary">Submit</button><br><br>
                            <h1 style="font-size: 23px;" id="msg">&nbsp;</h1>
                        </td>
                    </tr>
                </table>
                @else
                    <h1 style="font-size: 23px;margin-bottom: 1%">Your task in this game is to guess the correct word from the scrambled word that appears</h1>
                    <button id="btn_play" class="button">Let's Play</button>
                @endif
            </div>
        </div>
    </form>
@endsection

@section('script')
<script type="text/javascript">
    var numQuest = 0;
    getWord();
    $("#mn_play").addClass('active');
    $( "#btnSubmit" ).click(function(e) {
        e.preventDefault();
        $('#msg').html('&nbsp;');
        if ($('#answer').val() == "") {
            $('#msg').css('color','#d29300'); 
            $('#msg').html('Fill your answer');
        }else{
            $.ajax({
                url: '/play',
                type: 'post',
                data: $('#formPlay').serialize(), // Remember that you need to have your csrf token included
                dataType: 'json',
                success: function( data ){
                    var arrData = JSON.parse(JSON.stringify(data));
                    if(arrData.status == "sukses"){
                        $('#msg').css('color','#00e000'); 
                        $('#msg').html(arrData.msg);
                    }else{
                        $('#msg').css('color','#d29300'); 
                        $('#msg').html(arrData.msg);
                    }
                    setTimeout(function(){ getWord(); }, 2000);
                    
                }
            });
        }
        
    });

    $( "#btn_play" ).click(function(e) {
        e.preventDefault();
       $.ajax({
            url: '/letsplay',
            type: 'get',
            success: function( data ){
                var arrData = JSON.parse(JSON.stringify(data));
                if(arrData.status == "sukses"){
                    setTimeout(function(){ window.location = '/play'; }, 1000);
                }else{
                    alert('Failed to create games ID, please try again later')
                }
                
            }
        });
    });

    function getWord(){
        $.ajax({
            url: '/getWord',
            type: 'get',
            success: function( data ){
                var arrData = JSON.parse(JSON.stringify(data));
                if(arrData.count > 10){
                    setTimeout(function(){ window.location = "/result/{{Session::get('play_id')}}"; }, 1000);
                }else{ 
                    $("#word").find('tbody').empty();
                    $("#word").find('tbody').append(arrData.data);
                    $("#key").val(arrData.key);
                    $("#count").html(arrData.count);
                    $("#score").html(arrData.score);
                    $('#msg').html('&nbsp;');
                    $('#answer').val('');
                    $('#answer').focus();
                }
                

            }
        });
    }
</script>
@endsection