<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\UserNotificationModel as UserNotificationModel;
use Redirect, Input;

class NotificationController extends Controller
{
    public function view($id)
	{
		$notification = UserNotificationModel::find($id);
		$notification->view = true;
		$notification->save();
		
		return Redirect::to($notification->url);
	}
	
	public function postAjax(Request $request)
	{
		if($request->ajax())
		{
			switch($request->get('type'))
			{
				default:
					$take = 5;
					$skip = 0;
					break;
				case 'new':
					$take = $request->get('count') == 0 ? 1 : $request->get('count')+1;
					$skip = 0;
					break;
				case 'load':
					$take = 5;
					$skip = $request->get('count') == 0 ? 1 : $request->get('count');
					break;
			}
			
			$notifications = UserNotificationModel::where('user_id', '=', $request->get('user_id'))->orderby('view', 'asc')->orderby('last_time', 'desc');
			
			$list = $notifications->take($take)->skip($skip)->get();
			$count = $notifications->where('view', '=', '0')->count();
			
			if(!$list->isEmpty())
			{
				$view = view('laravel-authentication-acl::client.ajax.notifications')->with(
					[
						'notifications' => $list,
					]
				)->render();
				
				return response()->json(['success' => true, 'html' => $view, 'count' => $count, 'take' => $take, 'skip' => $skip]);
			}
		}
		else
		{
			return abort(404);
		}
	}
}
