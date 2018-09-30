<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

class Score extends Controller
{
	public function __construct(){
		if(!Session::has('LOGGED')){
			return redirect('/');
		}
	}

    function result($id){
		if($id){
			$id_user = Session::get('id_user');
			$play_id = Crypt::decryptString($id);
			$getResult = DB::table("t_history")
							->leftJoin("m_word", "m_word.ID", "=", "t_history.ID_WORD")
		    				->select("m_word.WORD","t_history.ANSWER","t_history.CORRECT")
		    				->where("t_history.ID_HISTORY",$play_id)
		    				->where("t_history.ID_USER",$id_user)
		    				->get()->toArray();
		    return view('result',array('data' => $getResult));
		}else{
			return redirect('/highscore');
		}
	}

	function highscore(){
		$id_user = Session::get('id_user');
		$getScore = DB::table('t_history')
	    				->selectRaw("ID_HISTORY,(COUNT(IF(CORRECT='1',1,NULL)) - COUNT(IF(CORRECT='0',1,NULL))) * 10 AS 'SCORE'")
	    				->where('ID_USER',$id_user)
	    				->groupBy('ID_HISTORY','ID_USER')
	    				->orderBy('SCORE', 'desc')
	    				->get()->toArray();
	    return view('highscore',array('data' => $getScore));
	}
}
