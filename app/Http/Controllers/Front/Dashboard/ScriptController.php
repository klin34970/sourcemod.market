<?php

namespace App\Http\Controllers\Front\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\ScriptModel as ScriptModel;
use App\Http\Models\Front\ScriptVersionModel as ScriptVersionModel;
use App\Http\Models\Front\ScriptPurchaseModel as ScriptPurchaseModel;
use App\Http\Models\Front\UserNotificationModel as UserNotificationModel;
use Intervention\Image\ImageManagerStatic as Image;
use App, Validator, Redirect, Input, File, Event, URL, DB;

class ScriptController extends Controller
{
	 /**
     * Route : dashboard.index
     * @return view
     */	
    public function index()
	{
		$authentication = App::make('authenticator'); 
		
		$year = 2016;
	
				
		$scripts_joins = ScriptModel::select('*', DB::raw('count(*) as total_count, Month(created_at) as month, Year(created_at) as year'))
				->where('scripts.user_id', '=', $authentication->getLoggedUser()->id)
				//->whereYear('created_at', '=', $year)
				->groupBy('id', 'year', 'month')
				->get();
				
		$scripts_spend = ScriptPurchaseModel::select('*', DB::raw('count(*) as total_count, Month(created_at) as month'))
				->where('user_id', '=', $authentication->getLoggedUser()->id)
				->whereYear('created_at', '=', $year)
				->groupBy('id', 'month')
				->get();
		
        $months = 12;
        for ($i = 1; $i <= $months; $i++) 
		{
			
            $charts_scripts[$i] = 0;
            foreach ($scripts_joins as $script) 
			{
                if ($script->month == $i && $script->year == $year) 
				{
                    $charts_scripts[$i] += $script->total_count;
                }
            }           

			$charts_purchases[$i] = 0;
			$charts_gains[$i] = 0;
			$charts_comissions[$i] = 0;
			$charts_taxes[$i] = 0;
            foreach ($scripts_joins as $script) 
			{
				$charts_purchases[$i] += $script->purchases()
										->where(DB::raw('Year(created_at)'), $year)
										->where(DB::raw('Month(created_at)'), $i)
										->count();
										
				$charts_gains[$i] += $script->purchases()
									->where(DB::raw('Year(created_at)'), $year)
									->where(DB::raw('Month(created_at)'), $i)
									->sum('amount');
									
				$charts_taxes[$i] += $script->purchases()
									->where(DB::raw('Year(created_at)'), $year)
									->where(DB::raw('Month(created_at)'), $i)
									->sum('tax');
									
				$charts_comissions[$i] += $script->purchases()
										->where(DB::raw('Year(created_at)'), $year)
										->where(DB::raw('Month(created_at)'), $i)
										->sum('comission');
                
            }
			
			$charts_downloads[$i] = 0;
            foreach ($scripts_joins as $script) 
			{
				$charts_downloads[$i] += $script->versions_downloads()
										->where(DB::raw('Year(scripts_versions_downloads.created_at)'), $year)
										->where(DB::raw('Month(scripts_versions_downloads.created_at)'), $i)
										->count();                
            }
			
			$charts_issues[$i] = 0;
            foreach ($scripts_joins as $script) 
			{
				$charts_issues[$i] += $script->issues()
									->where(DB::raw('Year(created_at)'), $year)
									->where(DB::raw('Month(created_at)'), $i)
									->count();                
            }
			
			$charts_spend[$i] = 0;
            foreach ($scripts_spend as $script) 
			{
				if ($script->month == $i) 
				{
					$charts_spend[$i] += $script->amount; 
				}
            }
        }
		
		//echo '<pre>' . print_r($charts_spend, true) . '</pre>';
		
		return view('laravel-authentication-acl::client.dashboard.index')->with(
			[
				'charts_scripts' => $charts_scripts,
				'charts_purchases' => $charts_purchases,
				'charts_downloads' => $charts_downloads,
				'charts_gains' => $charts_gains,
				'charts_issues' => $charts_issues,
				'charts_spend' => $charts_spend,
				'charts_taxes' => $charts_taxes,
				'charts_comissions' => $charts_comissions,
			]
		);
	}	 
	
	/**
     * Route : dashboard.admin
     * @return view
     */	
    public function admin()
	{	
		$year = date('Y');
	
				
		$scripts_joins = ScriptModel::select('*', DB::raw('count(*) as total_count, Month(created_at) as month, Year(created_at) as year'))
				//->whereYear('created_at', '=', $year)
				->groupBy('id', 'year', 'month')
				->get();
				
		$scripts_spend = ScriptPurchaseModel::select('*', DB::raw('count(*) as total_count, Month(created_at) as month'))
				->whereYear('created_at', '=', $year)
				->groupBy('id', 'month')
				->get();
		
        $months = 12;
        for ($i = 1; $i <= $months; $i++) 
		{
			
            $charts_scripts[$i] = 0;
            foreach ($scripts_joins as $script) 
			{
                if ($script->month == $i && $script->year == $year) 
				{
                    $charts_scripts[$i] += $script->total_count;
                }
            }           

			$charts_purchases[$i] = 0;
			$charts_gains[$i] = 0;
			$charts_comissions[$i] = 0;
			$charts_taxes[$i] = 0;
            foreach ($scripts_joins as $script) 
			{
				$charts_purchases[$i] += $script->purchases()
										->where(DB::raw('Year(created_at)'), $year)
										->where(DB::raw('Month(created_at)'), $i)
										->count();
										
				$charts_gains[$i] += $script->purchases()
									->where(DB::raw('Year(created_at)'), $year)
									->where(DB::raw('Month(created_at)'), $i)
									->sum('amount');
									
				$charts_taxes[$i] += $script->purchases()
									->where(DB::raw('Year(created_at)'), $year)
									->where(DB::raw('Month(created_at)'), $i)
									->sum('tax');
									
				$charts_comissions[$i] += $script->purchases()
										->where(DB::raw('Year(created_at)'), $year)
										->where(DB::raw('Month(created_at)'), $i)
										->sum('comission');
                
            }
			
			$charts_downloads[$i] = 0;
            foreach ($scripts_joins as $script) 
			{
				$charts_downloads[$i] += $script->versions_downloads()
					->where(DB::raw('Year(scripts_versions_downloads.created_at)'), $year)
					->where(DB::raw('Month(scripts_versions_downloads.created_at)'), $i)
					->count();                
            }
			
			$charts_issues[$i] = 0;
            foreach ($scripts_joins as $script) 
			{
				$charts_issues[$i] += $script->issues()
									->where(DB::raw('Year(created_at)'), $year)
									->where(DB::raw('Month(created_at)'), $i)
									->count();                
            }
			
			$charts_spend[$i] = 0;
            foreach ($scripts_spend as $script) 
			{
				if ($script->month == $i) 
				{
					$charts_spend[$i] += $script->amount; 
				}
            }
        }
		
		//echo '<pre>' . print_r($charts_spend, true) . '</pre>';
		
		return view('laravel-authentication-acl::client.dashboard.admin')->with(
			[
				'charts_scripts' => $charts_scripts,
				'charts_purchases' => $charts_purchases,
				'charts_downloads' => $charts_downloads,
				'charts_gains' => $charts_gains,
				'charts_issues' => $charts_issues,
				'charts_spend' => $charts_spend,
				'charts_taxes' => $charts_taxes,
				'charts_comissions' => $charts_comissions,
			]
		);
	}
	
	 /**
     * Route : dashboard.notifications
     * @return view
     */	
	public function getNotificationsList()
	{
		$authentication = App::make('authenticator'); 
		$notifications = UserNotificationModel::where('user_id', '=', $authentication->getLoggedUser()->id)->orderBy('last_time', 'desc')->get();
		
		return view('laravel-authentication-acl::client.dashboard.notifications.list')->with(
			[
				'notifications' => $notifications,
			]
		);
	}
	
	public function readAllNotifications()
	{
		$authentication = App::make('authenticator'); 
		$notifications = UserNotificationModel::where('user_id', '=', $authentication->getLoggedUser()->id)->update(
			[
				'view' => 1
			]
		);
		
		return Redirect::back();
	}
	
	 /**
     * Route : dashboard.scripts
     * @return view
     */	
	public function getScriptsList()
	{
		//test event
		//Event::Fire(new App\Events\UserNotification(1, 'fa fa-user', 'test99', URL::route('dashboard.users.self')));
		
		$authentication = App::make('authenticator'); 
		$scripts = ScriptModel::where('user_id', '=', $authentication->getLoggedUser()->id)->orderBy('id', 'desc')->get();
		return view('laravel-authentication-acl::client.dashboard.scripts.list')->with(
			[
				'scripts' => $scripts,
			]
		);
	}	 
	
	/**
     * Route : dashboard.scripts.purchases
     * @return view
     */	
	public function getListPurchaseScript()
	{
		$authentication = App::make('authenticator'); 
		//$purchases = ScriptPurchaseModel::where('user_id', '=', $authentication->getLoggedUser()->id)->orderBy('id', 'desc')->get();
		$purchases = $authentication->getLoggedUser()->purchases;
		return view('laravel-authentication-acl::client.dashboard.scripts.purchases')->with(
			[
				'purchases' => $purchases,
			]
		);
	}
	
	public function getListSalesScript()
	{
		$authentication = App::make('authenticator'); 
		$sales = $authentication->getLoggedUser()->sales;
		return view('laravel-authentication-acl::client.dashboard.scripts.sales')->with(
			[
				'sales' => $sales,
			]
		);
	}
	
	 /**
     * Route : dashboard.scripts.disable
	 *
	 * @param  Request  $request
     * @return view
     */
	public function disableScript($script_id, Request $request)
	{
		$authentication = App::make('authenticator');
		
			//Check owner
			$script = ScriptModel::find($script_id);
			if($script->user_id)
			{
				$authentication = App::make('authenticator');
				if(
					$authentication->getLoggedUser()->id != $script->user_id
					|| $authentication->getLoggedUser()->isBanned()
				)
				{
					return abort(404);
				}
			}
			
			$script = ScriptModel::updateOrCreate(
				['id' => $script_id],
				[
					'reason_id' => 10,
					'activated' => false,
				]
			);
			
			Event::Fire(new App\Events\UserNotification(
					'disable_script_'.$script->id.'_user_'.$authentication->getLoggedUser()->id.'_date_'.date('Y-m-d_H:i:s'), 
					$script->user_id, 
					'fa fa-close', 
					'Your script ' . $script->title . ' has been disabled.', 
					URL::route('dashboard.scripts')
				));
			
		/* Finally redirect */
		return Redirect::route('dashboard.scripts');
	}
	
	public function activeScript($script_id, Request $request)
	{
		$authentication = App::make('authenticator');
		
			//Check owner
			$script = ScriptModel::find($script_id);
			if($script->user_id)
			{
				$authentication = App::make('authenticator');
				if(
					$authentication->getLoggedUser()->id != $script->user_id
					|| $authentication->getLoggedUser()->isBanned()
				)
				{
					return abort(404);
				}
			}
			
			$script = ScriptModel::updateOrCreate(
				['id' => $script_id],
				[
					'reason_id' => 2,
					'activated' => true,
				]
			);
			
			Event::Fire(new App\Events\UserNotification(
					'active_script_'.$script->id.'_user_'.$authentication->getLoggedUser()->id.'_date_'.date('Y-m-d_H:i:s'), 
					$script->user_id, 
					'fa fa-check', 
					'Your script ' . $script->title . ' has been activated.', 
					URL::route('dashboard.scripts')
				));
			
		/* Finally redirect */
		return Redirect::route('dashboard.scripts');
	}
	
	 /**
     * Route : dashboard.scripts.new
	 *
	 * @param  Request  $request
     * @return view
     */	
	public function newScript(Request $request)
	{
		$authentication = App::make('authenticator');
		
		//Banned
		if($authentication->getLoggedUser()->isBanned())
		{
			return abort(404);
		}
		
		$games = ScriptModel::_getGamesList();
		$categories = ScriptModel::_getCategoriesList();
		$dlcs = ScriptModel::_getUserDlc($authentication->getLoggedUser()->id);
		return view('laravel-authentication-acl::client.dashboard.scripts.new')->with(
			[
				'games' => $games,
				'categories' => $categories,
				'dlcs' => $dlcs,
			]
		);
	}
	
	 /**
     * Route : dashboard.scripts.new
	 *
	 * @param  Request  $request
     * @return view
     */	
	public function postNewScript(Request $request)
	{
		$authentication = App::make('authenticator');
		
		//banned
		if($authentication->getLoggedUser()->isBanned())
		{
			return abort(404);
		}	
		
		
		$validator = Validator::make($request->all(), [
			'title' => 'required|min:5|max:255',
			'description' => 'required|min:20|max:16777215',
			'price' => 'required|min:0',
			'price_discount' => 'required|min:0',
			'image' => 'image|required|max:1000|dimensions:min_width=920,min_height=260,max_width=920,max_height=260',
			'file' => $authentication->getLoggedUser()->id == 1 ? 'required|mimes:zip' : 'required|mimes:zip|max:100000',
			
		]);	
		
		
		if($validator->fails()) 
		{
            return Redirect::route('dashboard.scripts.new')
                        ->withErrors($validator->errors())
                        ->withInput($request->all());
        }
		
		$type = 0;
		if(is_array($request->get('types')))
		{
			foreach($request->get('types') as $key => $value)
			{
				$type += $value;
			}
		}
		
		if($request->get('game_id') == 6)
		{
			$price = 0;
			$price_discount = 0;
		}
		else
		{
			$price = $request->get('price');
			$price_discount = $request->get('price_discount');
		}
		/* Update or Create */ 
		$script = ScriptModel::Create(
			[
				'user_id' => $authentication->getLoggedUser()->id,
				'dlc_id' => strip_tags($request->get('dlc_id')),
				'type' => ($type == 0) ? 1 : $type,
				'title' => strip_tags($request->get('title')), 
				'description' => $request->get('description'), 
				'game_id' => $request->get('game_id'),
				'category_id' => $request->get('category_id'),				
				'price' => $price,
				'price_discount' => $price_discount,
				'reason_id' => 1,
				'tags' => strip_tags($request->get('tags')),
			]
		);	
		
		
		if(Input::hasFile('image'))
		{
			File::makeDirectory('assets/images/scripts/'.$script->id, 0777, true, true);
			Image::make(Input::file('image'))->resize(340, 96)->save('assets/images/scripts/'.$script->id.'/340x96.jpg', 100);
			Image::make(Input::file('image'))->resize(750, 212)->save('assets/images/scripts/'.$script->id.'/750x212.jpg', 100);
		}
		
		if(Input::hasFile('file'))
		{
			$scriptversion = ScriptVersionModel::create(
				[
					'script_id' => $script->id,
					'name' => '1.0.0',
					'changes' => 'Initial version'
				]
			);

			$file = Input::file('file');
			$destination = storage_path() . '/scripts/'.$script->id.'/versions/'.$scriptversion->id;
			File::makeDirectory($destination, 0777, true, true);
			$file->move($destination, $script->id.$scriptversion->id.'.'.$file->getClientOriginalExtension());
		}
		
		/* Event */
		Event::Fire(new App\Events\ScriptAdded($authentication->getLoggedUser()->id, $script->id));
		
		$approvers = DB::table('users_groups')->where('group_id', '=', 4)->get();
		
		foreach($approvers as $approver)
		{
			Event::Fire(new App\Events\UserNotification(
				'approvement_script_'.$script->id.'_user_'.$authentication->getLoggedUser()->id.'_date_'.date('Y-m-d_H:i:s'), 
				$approver->user_id, 
				'fa fa-eye', 
				'The script ' . $request->get('title') . ' has been submitted and waiting for approval.', 
				URL::route('admins.scripts', ['game_id' => $request->get('game_id'), 'search' => $request->get('title')])
			));
		}
		
		
		/* Finally redirect */
		return Redirect::route('dashboard.scripts.edit', ['id' => $script->id]);

	}
	
	 /**
     * Route : dashboard.scripts.edit
	 *
	 * @param  Request  $request
     * @return view
     */	
	public function editScript($script_id, Request $request)
	{
		$authentication = App::make('authenticator');
		$id = $request->get('id');
		$script = ScriptModel::where('id', '=', $script_id)->first();
		
		//Banned
		if($authentication->getLoggedUser()->isBanned())
		{
			return abort(404);
		}
			
		//Check owner
		if($script->user_id)
		{
			if($authentication->getLoggedUser()->id != $script->user_id)
			{
				return abort(404);
			}
		}
		else
		{
			return abort(404);
		}
		
		$games = ScriptModel::_getGamesList();
		$categories = ScriptModel::_getCategoriesList();
		$dlcs = ScriptModel::_getUserDlc($authentication->getLoggedUser()->id);
		return view('laravel-authentication-acl::client.dashboard.scripts.edit')->with(
			[
				'script' => $script,
				'games' => $games,
				'categories' => $categories,
				'dlcs' => $dlcs,
			]
		);
	}
	
	 /**
     * Route : dashboard.scripts.edit
	 *
	 * @param  Request  $request
     * @return view
     */	
	public function postEditScript($script_id, Request $request)
	{
		$authentication = App::make('authenticator');
		
		//banned
		if($authentication->getLoggedUser()->isBanned())
		{
			return abort(404);
		}	
		
		//Check owner
		$script = ScriptModel::find($script_id);
		if(isset($script->user_id))
		{
			if($authentication->getLoggedUser()->id != $script->user_id)
			{
				return abort(404);
			}
		}
		else
		{
			return abort(404);
		}
		
		$validator = Validator::make($request->all(), [
			'title' => 'required|min:5|max:255',
			'description' => 'required|min:20|max:16777215',
			'price' => 'required|min:0',
			'price_discount' => 'required|min:0',
			'image' => 'image|max:1000|dimensions:min_width=920,min_height=260,max_width=920,max_height=260',
		]);
		
		
		if($validator->fails()) 
		{
            return Redirect::route('dashboard.scripts.edit', ['script_id' => $script_id])
                        ->withErrors($validator->errors())
                        ->withInput($request->all());
        }
		
		$type = 0;
		if(is_array($request->get('types')))
		{
			foreach($request->get('types') as $key => $value)
			{
				$type += $value;
			}
		}
		
		if($request->get('game_id') == 6)
		{
			$price = 0;
			$price_discount = 0;
		}
		else
		{
			$price = $request->get('price');
			$price_discount = $request->get('price_discount');
		}
		/* Update or Create */ 			
		ScriptModel::where('id', '=', $script_id)->update(
			[
				'user_id' => $authentication->getLoggedUser()->id,
				'type' => ($type == 0) ? 1 : $type,
				'dlc_id' => strip_tags($request->get('dlc_id')),
				'title' => strip_tags($request->get('title')), 
				'description' => $request->get('description'), 
				'game_id' => $request->get('game_id'),
				'category_id' => $request->get('category_id'),				
				'price' => $price,
				'price_discount' => $price_discount,
				'tags' => strip_tags($request->get('tags')),
			]
		);
		
		if(Input::hasFile('image'))
		{
			File::makeDirectory('assets/images/scripts/'.$script->id, 0777, true, true);
			Image::make(Input::file('image'))->resize(340, 96)->save('assets/images/scripts/'.$script->id.'/340x96.jpg', 100);
			Image::make(Input::file('image'))->resize(750, 212)->save('assets/images/scripts/'.$script->id.'/750x212.jpg', 100);
		}
		
		/* Event */
		Event::Fire(new App\Events\ScriptUpdated($authentication->getLoggedUser()->id, $script->id));
		
		/* Finally redirect */
		return Redirect::route('dashboard.scripts.edit', ['script_id' => $script->id]);

	}	
	
	 /**
     * Route : dashboard.scripts.versions.new
	 *
	 * @param  Request  $request
     * @return view
     */	
	public function newScriptVersion($script_id, Request $request)
	{
		$script = ScriptModel::where('id', '=', $script_id)->first();
		
		//Check owner
		if(isset($script->user_id))
		{
			$authentication = App::make('authenticator');
			if(
				$authentication->getLoggedUser()->id != $script->user_id
				|| $authentication->getLoggedUser()->isBanned()
			)
			{
				return abort(404);
			}
		}
		else
		{
			return abort(404);
		}
		
		return view('laravel-authentication-acl::client.dashboard.scripts.versions.new')->with(
			[
				'script' => $script,
			]
		);
	}
	
	 /**
     * Route : dashboard.scripts.versions.new
	 *
	 * @param  Request  $request
     * @return view
     */	
	public function postNewScriptVersion($script_id, Request $request)
	{
		$script = ScriptModel::where('id', '=', $script_id)->first();
		
		$authentication = App::make('authenticator');
				
		//Check owner
		if(isset($script->user_id))
		{
			if(
				$authentication->getLoggedUser()->id != $script->user_id
				|| $authentication->getLoggedUser()->isBanned()
			)
			{
				return abort(404);
			}
		}
		else
		{
			return abort(404);
		}
		
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
			'changes' => 'required|min:10|max:65535',
			'file' => $authentication->getLoggedUser()->id == 1 ? 'required|mimes:zip' : 'required|mimes:zip|max:100000',
		]);	
		
		
		if($validator->fails()) 
		{
            return Redirect::route('dashboard.scripts.versions.new', ['script_id' => $script_id])
                        ->withErrors($validator->errors())
                        ->withInput($request->all());
        }
			
		$scriptversion = ScriptVersionModel::Create(
			[
				'script_id' => $script_id,
				'name' => strip_tags($request->get('name')),
				'changes' => $request->get('changes')
			]
		);
		
		if(Input::hasFile('file'))
		{
			$file = Input::file('file');
			$destination = storage_path() . '/scripts/'.$scriptversion->script_id.'/versions/'.$scriptversion->id;
			File::makeDirectory($destination, 0777, true, true);
			$file->move($destination, $scriptversion->script_id.$scriptversion->id.'.'.$file->getClientOriginalExtension());
		}
		
		
		/* Finally redirect */
		return Redirect::route('dashboard.scripts.edit', ['script_id' => $script_id]);
	}
	
	 /**
     * Route : dashboard.scripts.versions.edit
	 *
	 * @param  Request  $request
     * @return view
     */	
	public function editScriptVersion($script_id, $version_id, Request $request)
	{
		$scriptversion = ScriptVersionModel::where('id', '=', $version_id)->first();
		
		//Check owner
		if(isset($scriptversion->script->user_id))
		{
			$authentication = App::make('authenticator');
			if(
				$authentication->getLoggedUser()->id != $scriptversion->script->user_id
				|| $authentication->getLoggedUser()->isBanned()
			)
			{
				return abort(404);
			}
		}
		
		return view('laravel-authentication-acl::client.dashboard.scripts.versions.edit')->with(
			[
				'version' => $scriptversion,
			]
		);
	}
	
	 /**
     * Route : dashboard.scripts.versions.edit
	 *
	 * @param  Request  $request
     * @return view
     */	
	public function postEditScriptVersion($script_id, $version_id, Request $request)
	{
		$authentication = App::make('authenticator');
		
		//Check owner
		$scriptversion = ScriptVersionModel::where('id', '=', $version_id)->first();
		if(isset($scriptversion->script->user_id))
		{
			if(
				$authentication->getLoggedUser()->id != $scriptversion->script->user_id
				|| $authentication->getLoggedUser()->isBanned()
			)
			{
				return abort(404);
			}
		}
		else
		{
			return abort(404);
			
		}
		
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
			'changes' => 'required|min:10|max:65535',
			'file' => $authentication->getLoggedUser()->id == 1 ? 'mimes:zip' : 'mimes:zip|max:100000',
		]);
		
		if($validator->fails()) 
		{
            return Redirect::route('dashboard.scripts.versions.edit', ['script_id' => $script_id, 'version_id' => $version_id])
                        ->withErrors($validator->errors())
                        ->withInput($request->all());
        }
			
		$scriptversion = ScriptVersionModel::where('id', '=', $version_id)->update(
			[
				'script_id' => $script_id,
				'name' => strip_tags($request->get('name')),
				'changes' => $request->get('changes')
			]
		);
		
		if(Input::hasFile('file'))
		{
			$file = Input::file('file');
			$destination = storage_path() . '/scripts/'.$script_id.'/versions/'.$version_id;
			File::makeDirectory($destination, 0777, true, true);
			$file->move($destination, $script_id.$version_id.'.'.$file->getClientOriginalExtension());
		}
		
		
		/* Finally redirect */
		return Redirect::route('dashboard.scripts.edit', ['script_id' => $script_id]);
	}
	
	 /**
     * Route : dashboard.scripts.versions.delete
	 *
	 * @param  Request  $request
     * @return view
     */	
	public function deleteScriptVersion($script_id, $version_id, Request $request)
	{		
		$scriptversion = ScriptVersionModel::find($version_id);
		//Check owner
		if($scriptversion->script->user_id)
		{
			$authentication = App::make('authenticator');
			if(
				$authentication->getLoggedUser()->id != $scriptversion->script->user_id
				|| $authentication->getLoggedUser()->isBanned()
			)
			{
				return abort(404);
			}
		}

		if($scriptversion)
		{
			File::deleteDirectory(storage_path() . '/scripts/'.$scriptversion->script_id.'/versions/'.$scriptversion->id);
			$scriptversion->delete();
		}
		return Redirect::back();
	}
}
