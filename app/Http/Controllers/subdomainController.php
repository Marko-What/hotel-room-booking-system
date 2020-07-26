<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class subdomainController extends Controller
{
    private $username;

	
	public function __construct(Request $request){
		$this->username = $request->username;
	}

	
	public function show(Request $request){
		$user = User::where("name", "=", $this->username)->first();
		return view("dashboard")->with("user", $user);
	}




}
