<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\ScriptModel as ScriptModel;
use Response;

class ScriptController extends Controller
{
	
	protected $headers;
	
	protected $options;
	
	public function __construct()
	{
		$this->headers = [
			'Content-Type' => 'application/json; charset=UTF-8',
			'charset' => 'utf-8'
		];
		
		$this->options = JSON_PRETTY_PRINT;
		
	}
	
    public function index()
	{
		return view('laravel-authentication-acl::client.api.scripts')->with(
			[
				
			]
		);
	}
	
	public function getList(Request $request)
	{
		$user_id = $request->instance()->query('api_user_id');
		$scripts = ScriptModel::where('user_id', '=', $user_id)->get()->toArray();
		
		if($scripts)
		{
			return Response::json(['status' => 'success', 'scripts' => $scripts], 200, $this->headers, $this->options);
		}
		else
		{
			return Response::json(['status' => 'not found'], 200, $this->headers, $this->options);
		}
	}	
	
	public function getScript($id, Request $request)
	{
		$user_id = $request->instance()->query('api_user_id');
		$scripts = ScriptModel::where('id', '=', $id)->where('user_id', '=', $user_id)->get()->toArray();
		
		if($scripts)
		{
			return Response::json(['status' => 'success', 'scripts' => $scripts], 200, $this->headers, $this->options);
		}
		else
		{
			return Response::json(['status' => 'not found'], 200, $this->headers, $this->options);
		}
	}
}
