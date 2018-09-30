<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
class Home extends Controller
{
    public function index(Request $request){
    	
    	if($request->session()->get('LOGGED')){
			return redirect('/play');
		}else{
			return view('login');
		}
    }

    public function register(Request $request){
    	if ($request->isMethod('post')) {
		    $msg = "";
		    $data = $request->input('post');
		    $checkData = DB::table('t_user')
		    				->select('USERNAME','EMAIL')
		    				->where('USERNAME',$data['username'])
		    				->orWhere('EMAIL',$data['email'])
		    				->first();
		    if($checkData){
			    if($checkData->USERNAME == $data['username']){
			    	$status = 'gagal';
			    	$msg = 'Username <b>'.$data['username'].'</b> is not available, please try other username';
			    }elseif($checkData->EMAIL == $data['email']){
			    	$status = 'gagal';
			    	$msg = 'Email is already registered';
			    }
			}else{
		    	$insert = DB::table('t_user')->insert(
								    ['USERNAME' => $data['username'], 'PASSWORD' => Crypt::encryptString($data['password']), 'NAMA' => $data['name'], 'EMAIL' => $data['email']]
								);
			    if($insert){
			    	$status = 'sukses';
				    $msg = 'Yeeaayy, you have successfully registered, please login for playing games';
			    }else{
			    	$status = 'gagal';
				    $msg = 'Sorry your registration failed, please try again later';
			    }
		    }
		    $response = array(
				          'status' => $status,
				          'msg' => $msg,
				      );
		    
		    return response()->json($response); 
		}elseif($request->isMethod('get')){
			return view('register');
		}
    }

    public function login(Request $request){
    	if ($request->isMethod('post')) {
    		$data = $request->input('post');
		    $getData = DB::table('t_user')
		    				->select('ID','USERNAME','PASSWORD','NAMA','EMAIL')
		    				->where('USERNAME',$data['username'])
		    				->first();
		    if($getData){
		    	if($data['password'] == Crypt::decryptString($getData->PASSWORD)){
		    		$sess['id_user'] 	= $getData->ID;
		    		$sess['username']	= $getData->USERNAME;
		    		$sess['nama'] 		= $getData->NAMA;
		    		$sess['email'] 		= $getData->EMAIL;
		    		$sess['LOGGED']		= TRUE;
		    		session($sess);
		    		$status = 'sukses';
					$msg 	= 'Login successfully';
		    	}else{
		    		$status = 'gagal';
					$msg 	= 'Password is not match';
		    	}
		    }else{
		    	$status = 'gagal';
				$msg 	= 'Username is not registered';
		    }
		    $response = array(
				          'status' => $status,
				          'msg' => $msg,
				      );
		    
		    return response()->json($response); 
		}elseif($request->isMethod('get')){
			return view('login');
		}
    }

    public function logout(Request $request){
    	$request->session()->flush();
    	return redirect('/');
    }

}
