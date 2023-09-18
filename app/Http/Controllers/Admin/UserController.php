<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\ScriptModel as ScriptModel;
use App\Http\Models\Front\UserBanModel as UserBanModel;
use \LaravelAcl\Authentication\Models\User as User;
use App, Validator, Redirect, DB, Event, URL;

class UserController extends Controller
{
	
    public function getList(Request $request)
	{
		$users = User::select(
			'*', 
			DB::raw('(select count(*) from `users_reports` where `users_reports`.`user_id` = `users`.`id`) as report')
		);
		
		$users = $users->orderBy('report', $request->has('report') ?  $request->get('report') : 'asc');
		
		if($request->get('search'))
		{
			$search = $request->get('search');
			$users = $users->where(function ($query) use ($search) 
			{
				return $query->where('steam_id', 'like', '%'.$search.'%');
			});
			
			$users = $users->orWhereHas('user_profile', function ($query) use ($search) 
			{
				return $query->where('first_name', 'like', '%'.$search.'%');
			});
		}
		
		if($request->get('banned'))
		{
			$search = $request->get('search');
			
			$users = $users->whereHas('bans', function ($query) use ($search) 
			{
				return $query->where('activated', '=', true)->where('from', '<', date('Y-m-d H:i:s'))->where('to', '>', date('Y-m-d H:i:s'));
			});
		}
		
		$users = $users->paginate((int)config('sourcemod.market.admins_users_pagination'));
		
		return view('laravel-authentication-acl::client.admins.users.list')->with(
			[
				'users' => $users,
			]
		);
	}
	public function viewUserReports($id)
	{
		$authentication = App::make('authenticator');
		if($authentication->getLoggedUser()->hasPermission(['_approver']))
		{
			$user = User::find($id);
			if(
				$id == null
				|| $user == null
			)
			{
				return abort(404);
			}
			
			
			return view('laravel-authentication-acl::client.users.reports')->with(
				[
					'user' => $user
				]
			);
		}
		else
		{
			return abort(404);
		}
	}	
	
	public function banUser($id)
	{
		$authentication = App::make('authenticator');
		if($authentication->getLoggedUser()->hasPermission(['_users-management']))
		{
			$user = User::find($id);
			if(
				$id == null
				|| $user == null
			)
			{
				return abort(404);
			}
			
			
			return view('laravel-authentication-acl::client.users.bans')->with(
				[
					'user' => $user
				]
			);
		}
		else
		{
			return abort(404);
		}
	}	
	
	public function postBanUser($id, Request $request)
	{
		$authentication = App::make('authenticator');
		if($authentication->getLoggedUser()->hasPermission(['_users-management']))
		{
			$user = User::find($id);
			if(
				$id == null
				|| $user == null
			)
			{
				return abort(404);
			}
			
			$dates = explode(' - ', $request->get('date'));
			$from = $dates[0];
			$to = $dates[1];
			$validator = Validator::make($request->all(), [
				'reason' => 'required|min:10'
			]);
			
			if($validator->fails()) 
			{
				return Redirect::route('users.bans', ['id' => $id])
					->withErrors($validator->errors())
					->withInput($request->all());
			}
			
			if($user->isBanned())
			{
				UserBanModel::where('user_id', '=', $id)->update(
					[
						'user_id' => $id,
						'banner_user_id' => $authentication->getLoggedUser()->id,
						'activated' => true,
						'reason' => $request->get('reason'),
						'from' => $from,
						'to' => $to
					]
				);
			}
			else
			{
				UserBanModel::create(
					[
						'user_id' => $id,
						'banner_user_id' => $authentication->getLoggedUser()->id,
						'activated' => true,
						'reason' => $request->get('reason'),
						'from' => $from,
						'to' => $to
					]
				);	
			}
			
			ScriptModel::where('user_id', '=', $id)->update(
				[
					'activated' => false,
					'reason_id' => 9
				]
			);
			
			/* notify approver */
			$approvers = DB::table('users_groups')->where('group_id', '=', (int)config('sourcemod.market.group_report_users'))->get();
			foreach($approvers as $approver)
			{
				Event::Fire(new App\Events\UserNotification(
					'ban_user_'.$id.'_banner_user_'.$authentication->getLoggedUser()->id.'_date_'.date('Y-m-d_H:i:s'), 
					$approver->user_id, 
					'fa fa-meh-o', 
					''.$authentication->getLoggedUser()->user_profile->first()->first_name.' banned '.$authentication->getUserById($id)->user_profile->first()->first_name.'', 
					URL::route('users.bans', ['id' => $id])
				));
			}
			
			/* user notify */
			Event::Fire(new App\Events\UserNotification(
				'ban_user_'.$id.'_banner_user_'.$authentication->getLoggedUser()->id.'_date_'.date('Y-m-d_H:i:s'), 
				$id, 
				'fa fa-meh-o', 
				''.$authentication->getLoggedUser()->user_profile->first()->first_name.' banned you', 
				URL::route('home.index')
			));
			
			return Redirect::route('users.bans', ['id' => $id]);
		}
		else
		{
			return abort(404);
		}
	}	
	
	public function postUnbanUser($id, Request $request)
	{
		$authentication = App::make('authenticator');
		if($authentication->getLoggedUser()->hasPermission(['_users-management']))
		{
			$user = User::find($id);
			if(
				$id == null
				|| $user == null
			)
			{
				return abort(404);
			}
			
			UserBanModel::where('user_id', '=', $id)->update(
				[
					'activated' => false,
				]
			);
			
			ScriptModel::where('user_id', '=', $id)->where('reason_id', '=', 9)->update(
				[
					'activated' => true,
					'reason_id' => 2
				]
			);
			
			/* notify approver */
			$approvers = DB::table('users_groups')->where('group_id', '=', (int)config('sourcemod.market.group_report_users'))->get();
			foreach($approvers as $approver)
			{
				Event::Fire(new App\Events\UserNotification(
					'unban_user_'.$id.'_unbanner_user_'.$authentication->getLoggedUser()->id.'_date_'.date('Y-m-d_H:i:s'), 
					$approver->user_id, 
					'fa fa-meh-o', 
					''.$authentication->getLoggedUser()->user_profile->first()->first_name.' unbanned '.$authentication->getUserById($id)->user_profile->first()->first_name.'', 
					URL::route('users.bans', ['id' => $id])
				));
			}
			
			/* user notify */
			Event::Fire(new App\Events\UserNotification(
				'unban_user_'.$id.'_unbanner_user_'.$authentication->getLoggedUser()->id.'_date_'.date('Y-m-d_H:i:s'), 
				$id, 
				'fa fa-meh-o', 
				''.$authentication->getLoggedUser()->user_profile->first()->first_name.' unbanned you', 
				URL::route('home.index')
			));
			
			return Redirect::route('admins.users');
		}
		else
		{
			return abort(404);
		}
	}
}
