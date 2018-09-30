<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
class Scrambler extends Controller
{
	
    public function play(Request $request){
	    if($request->session()->get('LOGGED')){
	    	if ($request->isMethod('post')) {
			    $data = $request->input('post');
			    $insert['ID_HISTORY'] 	= Crypt::decryptString(Session::get('play_id')); 
			    $insert['ID_WORD'] 		= Crypt::decryptString($data['key']);
			    $insert['ID_USER']		= Session::get('id_user');
			    $insert['ANSWER']		= $data['answer'];
			    $getCorrectWord = DB::table('m_word')
				    				->select('WORD')
				    				->where('ID',$insert['ID_WORD'])
				    				->first();
				if(strtoupper($insert['ANSWER']) == strtoupper($getCorrectWord->WORD)){
					$insert['CORRECT'] = '1';
					$status = 'sukses';
					$msg = 'Good Job, your answer is correct';
				}else{
					$insert['CORRECT'] = '0';
					$status = 'gagal';
					$msg = 'Sorry, your answer is incorrect';
				}
				$query = DB::table('t_history')->insert($insert);
			    
			    $response = array(
					          'status' => $status,
					          'msg' => $msg,
					      );
			    
			    return response()->json($response); 
				
			}elseif($request->isMethod('get')){ 
				return view('play');
			}
		}else{
			return redirect('/');
		}
    }

    function getWord(){
    	$getWord = DB::table('m_word')
	    				->select('ID','WORD')
	    				->orderByRaw('RAND()')
	    				->first();
	    return $getWord;
    }

    function showWord(){
    	if(Session::has('play_id')){
	    	$word = $this->getWord();
			foreach($word as $key => $val)
			{
			    $arrWord[$key] = strtoupper($val);
			}
	    	
	        $split = explode(' ',$arrWord['WORD']);
	        
	        $data = '<tr>';
	        for ($i = 0; $i < count($split); $i++){
	            $data .= '<td align="center">';
	            $letter = str_split(str_shuffle($split[$i]));
	            
	            foreach ($letter as $val){
	                $data .= '<input type="text" style="width: 1.5em;color: #fff;font-size: 2em;padding:0 0.2em;text-align:center;line-height: 0;height: 25%;float: left;margin-right: 3px" value="'.$val.'" readonly>';
	            }
	            $data .= '</td>';
	            
	        }
	        $data .= '</tr>';
	        $getCount = DB::table('t_history')
		    				->selectRaw("COUNT(IF(CORRECT='1',1,NULL)) 'BENAR',COUNT(IF(CORRECT='0',1,NULL)) 'SALAH',COUNT(ID_HISTORY) AS COUNT")
		    				->where('ID_HISTORY',Crypt::decryptString(Session::get('play_id')))
		    				->first();
		    $scoreBenar = $getCount->BENAR * 10;
		    $scoreSalah = $getCount->SALAH * 10;
		    $score = $scoreBenar - $scoreSalah;
		    $count = $getCount->COUNT + 1;

	        $response = array(
					          'key' => Crypt::encryptString($arrWord['ID']),
					          'data' => $data,
					          'score' => $score,
					          'count' => $count,
					      );
		}else{
			$response = array();
		}  
		return response()->json($response); 
    }

    function letsplay(){
    	if(Session::has('play_id')){
			$status = 'sukses';
		}else{
			$kode = $this->generate_kode('WS',10);
			if(strlen($kode) == 14){
	    		Session::forget('play_id');
	    		Session::put('play_id',Crypt::encryptString($kode));
	    		$status = 'sukses';
	    	}else{
	    		$status = 'gagal';
	    	}
		}
		$response = array(
	    						'status' => $status,
					      );
		return response()->json($response); 
    }

    function generate_kode($inisial="",$digit=""){
		$random = date('s');
		$char   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ987654321ABCDEFGHIJKLMNOPQRSTUVWXY01234567890';
		$rchar  = substr(str_shuffle($char), 6, ($digit)?$digit:6);
		return substr($inisial.$random.$rchar, 0, 15);
	}
}
