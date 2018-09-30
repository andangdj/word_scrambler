@extends('home')

@section('content')
<div class="col-12 col-12-xsmall" style="top:-30%;margin-bottom: 2%">
    <h1 class="major" style="font-size: 23px;">Result</h1>
</div>
<div class="row gtr-uniform">
    
    <div class="col-12 col-12-xsmall" align="center">
        
        
        <div class="table-wrapper">
            <table style="width: auto;" align="center">
                <thead>
                    <th>No.</th>
                    <th>Your Answer</th>
                    <th>Word Correct</th>
                    <th>Score</th>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @for ($i=0; $i<count($data); $i++)
                        @php
                            if($data[$i]->CORRECT == '1'){
                                $score = '10';
                                $total = $total + 10;   
                                $color = '#00e000';
                            }else{
                                $score = '-10';
                                $total = $total - 10;
                                $color = '#d29300';
                            }
                        @endphp
                        <tr>
                            <td>{{$i+1}}</td>
                            <td>{{strtoupper($data[$i]->ANSWER)}}</td>
                            <td>{{strtoupper($data[$i]->WORD)}}</td>
                            <td style="color: {{$color}}">{{$score}}</td>
                        </tr>
                    @endfor
                        <tr>
                            <td colspan="3" align="center"><b>TOTAL</b></td>
                            <td><b>{{$total}}</b></td>
                        </tr>
                </tbody>
                
            </table>
        </div>
        <button id="btnPlay" class="primary">Play Again</button>&nbsp;&nbsp;<button id="btnScore" class="button">High Score</button>
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

    $( "#btnScore" ).click(function(e) {
        e.preventDefault();
        setTimeout(function(){ window.location = '/highscore'; }, 1000);
    });
</script>
@endsection