<?php

namespace App\Http\Controllers\Front\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\UserAPIModel as UserAPIModel;
use App, Redirect;

class APIController extends Controller
{
	
	 /**
     * Route : dashboard.api.keys
     * @return view
     */	
    public function getList()
	{
		$authentication = App::make('authenticator');
		$api_keys = UserAPIModel::where('user_id', '=', $authentication->getLoggedUser()->id)->get();
		
		return view('laravel-authentication-acl::client.dashboard.api.keys.list')->with(
			[
				'api_keys' => $api_keys,
			]
		);		
	}
	
	public function new1()
	{
		$authentication = App::make('authenticator');
		
		//banned
		if($authentication->getLoggedUser()->isBanned())
		{
			abort(404);
		}
	
		return view('laravel-authentication-acl::client.dashboard.api.keys.new');	
	}
	
	public function postNew(Request $request)
	{
		$authentication = App::make('authenticator');

		//banned
		if($authentication->getLoggedUser()->isBanned())
		{
			abort(404);
		}


		$api_key = UserAPIModel::Create(
			[
				'user_id' => $authentication->getLoggedUser()->id,
				'key' => base64_encode(hash_hmac('sha256', urlencode($authentication->getLoggedUser()->steam_id.date('Y-m-d H:i:s')), config('app.key'))),
				'permissions' => json_encode($request->get('permissions'))
			]
		);
		
		
		return Redirect::route('dashboard.api.keys');
	}
	
	public function edit($id)
	{
		$authentication = App::make('authenticator');
		
		//banned
		if($authentication->getLoggedUser()->isBanned())
		{
			abort(404);
		}
		
		$api_key = UserAPIModel::find($id);
		
		//Check owner
		if(isset($api_key->user_id))
		{
			if($authentication->getLoggedUser()->id != $api_key->user_id)
			{
				abort(404);
			}
		}
		else
		{
			abort(404);
		}
	
		return view('laravel-authentication-acl::client.dashboard.api.keys.edit')->with(
			[
				'api_key' => $api_key,
			]
		);	
	}	
	
	public function postEdit($id, Request $request)
	{
		$authentication = App::make('authenticator');

		//banned
		if($authentication->getLoggedUser()->isBanned())
		{
			abort(404);
		}

		//Check owner
		$api_key = UserAPIModel::find($id);
		if(isset($api_key->user_id))
		{
			if($authentication->getLoggedUser()->id != $api_key->user_id)
			{
				abort(404);
			}
		}
		else
		{
			abort(404);
		}

		$api_key = UserAPIModel::updateOrCreate(
			['id' => $id],
			[
				'user_id' => $authentication->getLoggedUser()->id,
				'permissions' => json_encode($request->get('permissions'))
			]
		);			
		
		return Redirect::route('dashboard.api.keys');
	}
}
