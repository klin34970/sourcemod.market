<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\ScriptModel as ScriptModel;
use App\Http\Models\Front\ScriptStarModel as ScriptStarModel;
use App\Http\Models\Front\UserReportModel as UserReportModel;
use App\Http\Models\Front\UserMessageModel as UserMessageModel;
use \LaravelAcl\Authentication\Models\User as User;
use App, DB, Redirect, Event, URL, Validator, GeoIP, Curl;

class UserController extends Controller
{

	 /**
     * Route : users.list
     *
     * @return view
     */	
	public function getList(Request $request)
	{
		$users = User::select('*');
		
		switch($request->get('status'))
		{
			case 'online':
				$users = $users->where('online', '=', true);
				break;
			case 'banned':
				$users = $users->whereHas('bans', function ($query) 
				{
					return $query->where('activated', '=', true)->where('from', '<', date('Y-m-d H:i:s'))->where('to', '>', date('Y-m-d H:i:s'));
				});
		}
		
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
		
		$users = $users->paginate((int)config('sourcemod.market.users_pagination'));
		
		return view('laravel-authentication-acl::client.users.list')->with(
			[
				'users' => $users,
			]
		);
	}
	
	 /**
     * Route : dashboard.users.self
     *
     * @return view
     */	
	public function viewUserSelf()
	{
		$authentication = App::make('authenticator');
		$custom_profile_repo = App::make('custom_profile_repository', [$authentication->getLoggedUser()->user_profile->first()->id]);
		
		return view('laravel-authentication-acl::client.users.profile')->with(
		[
			"user_profile"   => $authentication->getLoggedUser()->user_profile->first(),
			"custom_profile" => $custom_profile_repo
		]);
	}	 
	
	/**
     * Route : dashboard.users.self
     *
     * @return view
     */	
	public function postUserSelf(Request $request)
	{
			$authentication = App::make('authenticator');
			
			$validator = Validator::make($request->all(), [
				'bio' => 'string',
				'vat' => 'string',
				'paypal_email' => 'email',
			]);
			
			if($validator->fails()) 
			{
				return Redirect::back()
					->withErrors($validator->errors())
					->withInput($request->all());
			}
			
			if(strlen(App\Http\Classes\Word::clean($request->get('bio'))) == 0)
			{
				$bio = '';
			}
			else
			{
				$bio = $request->get('bio');
			}
			
			//Check VAT through VIES
			$response = Curl::to(URL::route('soap.vies.vat', ['country' =>GeoIP::getCountryCode(), 'vat' => strip_tags($request->get('vat'))]))->get();
			if($response == 'true')
			{
				$vatnumer = strip_tags($request->get('vat'));
			}
			else
			{
				$vatnumer = null;
			}
			
			DB::table('user_profile')->where('user_id', $authentication->getLoggedUser()->id)->update(
				[
					'bio' => $bio,
					'vat' => $vatnumer,
					'last_name' => strip_tags($request->get('last_name')),
					'phone' => strip_tags($request->get('phone')),
					'state' => strip_tags($request->get('state')),
					'city' => strip_tags($request->get('city')),
					'zip' => strip_tags($request->get('zip')),
					'address' => strip_tags($request->get('address')),
					'paypal_email' => strip_tags($request->get('paypal_email')),
					'updated_at' => date('Y-m-d H:i:s')
				]
			);
			
			Event::fire(new App\Events\UserProfileUpdated($authentication->getLoggedUser()->id));
			

			Event::Fire(new App\Events\UserNotification(
				'profile_bio',
				$authentication->getLoggedUser()->id, 
				'fa fa-user', 
				'Your biography is empty', 
				URL::route('dashboard.users.self'),
				null,
				$bio ? true : false
				)
			);
			
			Event::Fire(new App\Events\UserNotification(
				'profile_paypal',
				$authentication->getLoggedUser()->id, 
				'fa fa-user', 
				'You need to set a Paypal email to sell your scripts', 
				URL::route('dashboard.users.self'), 
				null, 
				$request->get('paypal_email') != "" ? true : false
				)
			);
			
			
			return Redirect::route('dashboard.users.self');
	}
	
	 /**
     * Route : users.view
     *
     * @param  int  $id
     * @return view
     */
    public function viewUser($id)
	{
		if(DB::table('users')->where('id', '=', $id)->exists())
		{
			$authentication = App::make('authenticator');
			if($user = $authentication->getUserById($id))
			{
				$scripts = ScriptModel::where('user_id', '=', $user->id)->orderBy('id', 'desc')->get();
				if(!$scripts->isEmpty())
				{
					$reputations = ScriptStarModel::orderBy('id', 'desc');
					foreach($scripts as $script)
					{
						$reputations->orWhere('script_id', '=', $script->id);
					}
					
					$reputations = $reputations->get();
				
					return view('laravel-authentication-acl::client.users.view')->with(
						[
							'user' => $user,
							'scripts' => $scripts,
							'reputations' => $reputations
						]
					);
				}
				else
				{
					return view('laravel-authentication-acl::client.users.view')->with(
						[
							'user' => $user,
						]
					);	
				}
			}
			else
			{
				return abort(404);
			}
		}
		else
		{
			return abort(404);
		}
	}    
	
	 /**
     * Route : users.view.scripts
     *
     * @param  int  $id
     * @return view
     */
	public function viewUserScripts($id)
	{
		if(DB::table('users')->where('id', '=', $id)->exists())
		{
			$authentication = App::make('authenticator');
			if($user = $authentication->getUserById($id))
			{

				$scripts = ScriptModel::where('user_id', '=', $id)->orderBy('id', 'desc')->get();
				if(!$scripts->isEmpty())
				{
					$reputations = ScriptStarModel::orderBy('id', 'desc');
					foreach($scripts as $script)
					{
						$reputations->orWhere('script_id', '=', $script->id);
					}
					
					$reputations = $reputations->get();
					
					$tax = DB::table('vat_countries')->where('country_code', '=', GeoIP::getCountryCode())->first();
					if(isset($tax->tax_normal))
					{
						$tax = $tax->tax_normal;
					}
					else
					{
						$tax = 0;
					}
					
					return view('laravel-authentication-acl::client.users.scripts')->with(
						[
							'user' => $user,
							'scripts' => $scripts,
							'reputations' => $reputations,
							'tax' => $tax,
						]
					);
				}
				else
				{
					return view('laravel-authentication-acl::client.users.scripts')->with(
						[
							'user' => $user,
						]
					);	
				}
			}
			else
			{
				return abort(404);
			}
		}
		else
		{
			return abort(404);
		}
	}
	
	 /**
     * Route : users.view.reputations
     *
     * @param  int  $id
     * @return view
     */
	public function viewUserReputations($id)
	{
		if(DB::table('users')->where('id', '=', $id)->exists())
		{
			$authentication = App::make('authenticator');
			if($user = $authentication->getUserById($id))
			{
				$scripts = ScriptModel::with('stars')->where('user_id', '=', $id)->orderBy('id', 'desc')->get();
				
				if(!$scripts->isEmpty())
				{
					$r = ScriptStarModel::orderBy('id', 'desc');
					foreach($scripts as $script)
					{
						$r->orWhere('script_id', '=', $script->id);
					}
					$reputations = $r->get();
					$reputations_p = $r->paginate((int)config('sourcemod.market.users_reputations_pagination'));
					
					return view('laravel-authentication-acl::client.users.reputations')->with(
						[
							'user' => $user,
							'scripts' => $scripts,
							'reputations' => $reputations,
							'reputations_p' => $reputations_p,
						]
					);
				}
				else
				{
					return view('laravel-authentication-acl::client.users.reputations')->with(
						[
							'user' => $user,
							'scripts' => $scripts,
						]
					);
				}
			}
			else
			{
				return abort(404);
			}
		}
		else
		{
			return abort(404);
		}
	}

	 /**
     * Route : report.users
     *
     * @param  int  $id
     * @return view
     */	
	public function reportUsers($id)
	{
		if(DB::table('users')->where('id', '=', $id)->exists())
		{
			$authentication = App::make('authenticator');
			
			if($authentication->getUserById($id)->id == $authentication->getLoggedUser()->id)
			{
				return Redirect::back();
			}
			
			if($user = $authentication->getUserById($id))
			{
				return view('laravel-authentication-acl::client.users.report')->with(
					[
						'user' => $user
					]
				);
			}
		}
		else
		{
			abort(404);
		}
	}
	
	 /**
     * Route : report.users
     *
     * @param  int  $id
	 * @param  request $request
     * @return view
     */	
	public function postReportUsers($id, Request $request)
	{
		if(DB::table('users')->where('id', '=', $id)->exists())
		{
			$authentication = App::make('authenticator');
			
			if($authentication->getUserById($id)->id == $authentication->getLoggedUser()->id)
			{
				return Redirect::back();
			}
			
			$validator = Validator::make($request->all(), [
				'text' => 'required|min:10',
			]);
			
			if($validator->fails()) 
			{
				return Redirect::route('report.users', ['id' => $id])
					->withErrors($validator->errors())
					->withInput($request->all());
			}
			
			UserReportModel::create(
				[
					'user_id' => $id,
					'report_user_id' => $authentication->getLoggedUser()->id,
					'text' => $request->get('text')
				]
			);
			
			/* notify approver */
			$approvers = DB::table('users_groups')->where('group_id', '=', (int)config('sourcemod.market.group_report_users'))->get();
			foreach($approvers as $approver)
			{
				Event::Fire(new App\Events\UserNotification(
					'report_user_'.$id.'_reporter_user_'.$authentication->getLoggedUser()->id.'_date_'.date('Y-m-d_H:i:s'), 
					$approver->user_id, 
					'fa fa-meh-o', 
					''.$authentication->getLoggedUser()->user_profile->first()->first_name.' reported '.$authentication->getUserById($id)->user_profile->first()->first_name.'', 
					URL::route('users.view.reports', ['id' => $id])
				));
			}
			
			/* notify reporter */
			Event::Fire(new App\Events\UserNotification(
				'report_user_'.$id.'_reporter_user_'.$authentication->getLoggedUser()->id.'_date_'.date('Y-m-d_H:i:s'), 
				$authentication->getLoggedUser()->id, 
				'fa fa-meh-o', 
				'You reported '.$authentication->getUserById($id)->user_profile->first()->first_name.'. You request has been send to moderators.', 
				URL::route('users.view', ['id' => $id])
			));
			
			return Redirect::route('report.users', ['id' => $id]);
		}
		else
		{
			abort(404);
		}
	}
	
	 /**
     * Route : contact.users
     *
     * @param  int  $id
     * @return view
     */	
	public function contactUsers($id)
	{
		if(DB::table('users')->where('id', '=', $id)->exists())
		{
			$authentication = App::make('authenticator');
			
			if($authentication->getUserById($id)->id == $authentication->getLoggedUser()->id)
			{
				return Redirect::back();
			}
			
			if($user = $authentication->getUserById($id))
			{
				return view('laravel-authentication-acl::client.users.contact')->with(
					[
						'user' => $user
					]
				);
			}
		}
		else
		{
			abort(404);
		}
	}
	
	 /**
     * Route : contact.users
     *
     * @param  int  $id
	 * @param  request $request
     * @return view
     */	
	public function postContactUsers($id, Request $request)
	{
		if(DB::table('users')->where('id', '=', $id)->exists())
		{
			$authentication = App::make('authenticator');
			
			if($authentication->getUserById($id)->id == $authentication->getLoggedUser()->id)
			{
				return Redirect::back();
			}
			
			$validator = Validator::make($request->all(), [
				'title' => 'required|min:10',
				'text' => 'required|min:10',
			]);
			
			if($validator->fails()) 
			{
				return Redirect::route('contact.users', ['id' => $id])
					->withErrors($validator->errors())
					->withInput($request->all());
			}
			
			$message = UserMessageModel::create(
				[
					'user_id' => $authentication->getLoggedUser()->id,
					'target_id' => $id,
					'title' => strip_tags($request->get('title')),
					'text' => $request->get('text'),
					'read' => true
				]
			);
			
			/* notify target */
			Event::Fire(new App\Events\UserNotification(
				'contact_user_'.$id.'_sender_user_'.$authentication->getLoggedUser()->id.'_date_'.date('Y-m-d_H:i:s'), 
				$id, 
				'fa fa-envelope', 
				$authentication->getLoggedUser()->user_profile->first()->first_name.' sent you a private message.', 
				URL::route('dashboard.messages.read', ['id' => $message->id])
			));
			
			return Redirect::route('dashboard.messages.read', ['id' => $message->id]);
		}
		else
		{
			abort(404);
		}
	}
}
