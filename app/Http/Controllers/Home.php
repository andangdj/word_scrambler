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

	    	$data = array('nama' => 'ANDANG DWI JAYANTO');
			return view('login',$data);
		}else{
			//Session::put('LOGGED',TRUE);
			$request->session()->flush();
			$data = array('nama' => 'ANDANG DWI JAYANTO');
			return view('login',$data);
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
			    	$msg = 'Username <b>'.$data['username'].'</b> sudah digunakan, gunakan username lain';
			    }elseif($checkData->EMAIL == $data['email']){
			    	$status = 'gagal';
			    	$msg = 'Email anda sudah terdaftar';
			    }
			}else{
		    	$insert = DB::table('t_user')->insert(
								    ['USERNAME' => $data['username'], 'PASSWORD' => Crypt::encryptString($data['password']), 'NAMA' => $data['name'], 'EMAIL' => $data['email']]
								);
			    if($insert){
			    	$status = 'sukses';
				    $msg = 'Selamat anda berhasil terdaftar, silahkan login menggunakan akun anda untuk mulai bermain';
			    }else{
			    	$status = 'gagal';
				    $msg = 'Maaf registrasi anda gagal, silahkan coba beberapa saat lagi';
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
		    die($data['username']);
		}elseif($request->isMethod('get')){
			return view('login');
		}
    }

}
