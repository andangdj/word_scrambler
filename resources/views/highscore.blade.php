@extends('home')

@section('content')
<div class="col-12 col-12-xsmall" style="margin-bottom: 5%">
    <h1 class="major" style="font-size: 23px;">High Score</h1>
</div>
<div class="row gtr-uniform">
    <div class="col-12 col-12-xsmall" align="center">
        
        
        <div class="table-wrapper">
            <table style="width: 70%;" align="center">
                <thead>
                    <th>No.</th>
                    <th>Game ID</th>
                    <th>Score</th>
                </thead>
                <tbody>
                    @for ($i=0; $i<count($data); $i++)
                        <tr>
                            <td>{{$i+1}}</td>
                            <td><a href="{{url('/result/'.Crypt::encryptString($data[$i]->ID_HISTORY))}}">{{strtoupper($data[$i]->ID_HISTORY)}}</a></td>
                            <td>{{strtoupper($data[$i]->SCORE)}}</td>
                        </tr>
                    @endfor
                </tbody>
                
            </table>
        </div>
        <button id="btnPlay" class="button">Play Again</button>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $("#mn_score").addClass('active');

    $( "#btnPlay" ).click(function(e) {
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
</script>
@endsection