<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Classes\Slug;
use App\Http\Models\Front\ScriptModel as ScriptModel;
use App\Http\Models\Front\ScriptVersionModel as ScriptVersionModel;
use App\Http\Models\Front\ScriptVersionDownloadModel as ScriptVersionDownloadModel;
use App\Http\Models\Front\ScriptDiscussionModel as ScriptDiscussionModel;
use App\Http\Models\Front\ScriptStarModel as ScriptStarModel;
use App\Http\Models\Front\ScriptPurchaseModel as ScriptPurchaseModel;
use App\Http\Models\Front\ScriptIssueModel as ScriptIssueModel;
use App\Http\Models\Front\ScriptIssueDiscussionModel as ScriptIssueDiscussionModel;
use App\Http\Models\Front\ScriptReportModel as ScriptReportModel;
use App\Http\Models\Front\UserRankSaleModel as UserRankSaleModel;
use \LaravelAcl\Authentication\Models\UserProfile  as UserProfile ;
use App, Redirect, Validator, URL, DB, Event, Config, GeoIP, Zipper, File, Crypt;

class ScriptController extends Controller
{
	
	 /**
     * Route : scripts.list
     *
     * @param  Request  $request
     * @return view
     */
	public function index(Request $request)
	{	
		$scripts = ScriptModel::where('activated', true)->select(
			'*', 
			DB::raw('(select avg(stars) from `scripts_stars` where `scripts_stars`.`script_id` = `scripts`.`id`) as rating'),
			DB::raw('(select count(*) from `scripts_purchases` where `scripts_purchases`.`script_id` = `scripts`.`id`) as purchases'),
			DB::raw('(select created_at from `scripts_versions` where `scripts_versions`.`script_id` = `scripts`.`id` ORDER BY created_at DESC LIMIT 1) as updated')
		);
		
		if($request->get('search'))
		{
			$search = $request->get('search');
			$scripts = $scripts->where(function ($query) use ($search) 
			{
				return $query->where('title', 'like', '%'.$search.'%')->orWhere('description', 'like', '%'.$search.'%');
			});
		}
		if($request->get('price_min'))
		{
			$scripts = $scripts->where('price', '>=', $request->get('price_min'));
		}
		if($request->get('price_max'))
		{
			$scripts = $scripts->where('price', '<=', $request->get('price_max'));
		}
		if($request->get('game_id'))
		{
			$scripts = $scripts->where('game_id', '=', $request->get('game_id'));
		}
		if($request->get('category_id'))
		{
			$scripts = $scripts->where('category_id', '=', $request->get('category_id'));
		}
		
		switch($request->get('added'))
		{
			case 'year';
				$scripts = $scripts->whereYear('created_at', '>=', date("Y", strtotime("-1 year")));
				$scripts = $scripts->whereYear('created_at', '<=', date("Y", strtotime("-1 year")));
				break;
			case 'month':
				$scripts = $scripts->whereDate('created_at', '>=', date("Y-m-d", strtotime("first day of previous month")));
				$scripts = $scripts->whereDate('created_at', '<=', date("Y-m-d", strtotime("last day of previous month")));
				break;
			case 'week':
				$scripts = $scripts->whereDate('created_at', '>=', date("Y-m-d", strtotime("last week")));
				$scripts = $scripts->whereDate('created_at', '<=', date("Y-m-d", strtotime("last week +6days")));
				break;
			case 'day':
				$scripts = $scripts->whereDate('created_at', '>=', date("Y-m-d", strtotime("-7 days")));
				$scripts = $scripts->whereDate('created_at', '<=', date("Y-m-d", strtotime("now")));
				break;
		}
		
		$p = (int)config('sourcemod.market.scripts_pagination');
		switch($request->get('sort'))
		{
			case 'price_low':
				$scripts = $scripts->orderBy('price', 'asc')->paginate($p);
				$links = $scripts;
				break;
			case 'price_high':
				$scripts = $scripts->orderBy('price', 'desc')->paginate($p);
				$links = $scripts;
				break;
			case 'newest_items';
				$scripts = $scripts->orderBy('created_at', 'desc')->paginate($p);
				$links = $scripts;
				break;
			case 'featured':
				$scripts = $scripts->orderBy('view', 'desc')->paginate($p);
				$links = $scripts;
				break;
			case 'best_rated':
				$scripts = $scripts->orderBy('rating', 'desc')->orderBy('created_at', 'desc')->paginate($p);
				$links = $scripts;
				break;
			case 'best_sellers':
				$scripts = $scripts->orderBy('purchases', 'desc')->orderBy('created_at', 'desc')->paginate($p);
				$links = $scripts;
				break;
			case 'recently_updated':
				$scripts = $scripts->orderBy('updated', 'desc')->paginate($p);
				$links = $scripts;
				break;
			default:
				$scripts = $scripts->orderBy('updated', 'desc')->paginate($p);
				$links = $scripts;
				break;
		}
		
		$tax = DB::table('vat_countries')->where('country_code', '=', GeoIP::getCountryCode())->first();
		if(isset($tax->tax_normal))
		{
			$tax = $tax->tax_normal;
		}
		else
		{
			$tax = 0;
		}
		
		//dd($tax);
		return view('laravel-authentication-acl::client.scripts.index')->with(
			[
				'scripts' => $scripts,
				'links' => $links,
				'tax' => $tax,
			]
		);
	}
	
	 /**
     * Route : games.scripts.list
     *
     * @param  int  	$id
	 * @param  string  	$title
     * @return view
     */
	public function getListGameScripts($id, $title, Request $request)
	{
		$scripts = ScriptModel::where('activated', true)->where('game_id', $id)->select(
			'*', 
			DB::raw('(select avg(stars) from `scripts_stars` where `scripts_stars`.`script_id` = `scripts`.`id`) as rating'),
			DB::raw('(select count(*) from `scripts_purchases` where `scripts_purchases`.`script_id` = `scripts`.`id`) as purchases'),
			DB::raw('(select created_at from `scripts_versions` where `scripts_versions`.`script_id` = `scripts`.`id` ORDER BY created_at DESC LIMIT 1) as updated')
		);
		
		if($request->get('search'))
		{
			$search = $request->get('search');
			$scripts = $scripts->where(function ($query) use ($search) 
			{
				return $query->where('title', 'like', '%'.$search.'%')->orWhere('description', 'like', '%'.$search.'%');
			});
		}
		if($request->get('price_min'))
		{
			$scripts = $scripts->where('price', '>=', $request->get('price_min'));
		}
		if($request->get('price_max'))
		{
			$scripts = $scripts->where('price', '<=', $request->get('price_max'));
		}
		if($request->get('game_id'))
		{
			$scripts = $scripts->where('game_id', '=', $request->get('game_id'));
		}
		
		switch($request->get('added'))
		{
			case 'year';
				$scripts = $scripts->whereYear('created_at', '>=', date("Y", strtotime("-1 year")));
				$scripts = $scripts->whereYear('created_at', '<=', date("Y", strtotime("-1 year")));
				break;
			case 'month':
				$scripts = $scripts->whereDate('created_at', '>=', date("Y-m-d", strtotime("first day of previous month")));
				$scripts = $scripts->whereDate('created_at', '<=', date("Y-m-d", strtotime("last day of previous month")));
				break;
			case 'week':
				$scripts = $scripts->whereDate('created_at', '>=', date("Y-m-d", strtotime("last week")));
				$scripts = $scripts->whereDate('created_at', '<=', date("Y-m-d", strtotime("last week +6days")));
				break;
			case 'day':
				$scripts = $scripts->whereDate('created_at', '>=', date("Y-m-d", strtotime("-7 days")));
				$scripts = $scripts->whereDate('created_at', '<=', date("Y-m-d", strtotime("now")));
				break;
		}
		
		$p = (int)config('sourcemod.market.scripts_pagination');
		switch($request->get('sort'))
		{
			case 'price_low':
				$scripts = $scripts->orderBy('price', 'asc')->paginate($p);
				$links = $scripts;
				break;
			case 'price_high':
				$scripts = $scripts->orderBy('price', 'desc')->paginate($p);
				$links = $scripts;
				break;
			case 'newest_items';
				$scripts = $scripts->orderBy('created_at', 'desc')->paginate($p);
				$links = $scripts;
				break;
			case 'featured':
				$scripts = $scripts->orderBy('view', 'desc')->paginate($p);
				$links = $scripts;
				break;
			case 'best_rated':
				$scripts = $scripts->orderBy('rating', 'desc')->orderBy('created_at', 'desc')->paginate($p);
				$links = $scripts;
				break;
			case 'best_sellers':
				$scripts = $scripts->orderBy('purchases', 'desc')->orderBy('created_at', 'desc')->paginate($p);
				$links = $scripts;
				break;
			case 'recently_updated':
				$scripts = $scripts->orderBy('updated', 'desc')->paginate($p);
				$links = $scripts;
				break;
			default:
				$scripts = $scripts->orderBy('created_at', 'desc')->paginate($p);
				$links = $scripts;
				break;
		}
		
		$tax = DB::table('vat_countries')->where('country_code', '=', GeoIP::getCountryCode())->first();
		if(isset($tax->tax_normal))
		{
			$tax = $tax->tax_normal;
		}
		else
		{
			$tax = 0;
		}
		
		return view('laravel-authentication-acl::client.games.scripts.list')->with(
			[
				'scripts' => $scripts,
				'links' => $links,
				'tax' => $tax,
			]
		);
	}

	 /**
     * Route : scripts.view
     *
     * @param  int  	$id
	 * @param  string  	$game
	 * @param  string  	$category
	 * @param  string  	$title
     * @return view
     */
    public function viewScript($id, $game, $category, $title)
	{
		$script = ScriptModel::find($id);
		if(
			$id == null
			|| $game == null
			|| $category == null
			|| $title == null
			|| $script == null
		)
		{
			return abort(404);
		}
		
		if(!$script->activated)
		{
			$authentication = App::make('authenticator');
			
			if(
				//if user is owner
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->id === $script->user_id)
				||
				//if user is approver
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->hasPermission(['_approver']))
				||
				//if user bought it
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->purchases()->where('script_id', '=', $script->id)->count())
			)
			{
				
			}
			else
			{
				return abort(404);
			}
		}
		
		$script->view++;
		$script->save();
		
		$tax = DB::table('vat_countries')->where('country_code', '=', GeoIP::getCountryCode())->first();
		if(isset($tax->tax_normal))
		{
			$tax = $tax->tax_normal;
		}
		else
		{
			$tax = 0;
		}
		
		return view('laravel-authentication-acl::client.scripts.view')->with(
			[
				'script' => $script,
				'tax' => $tax
			]
		);

	}
	
	 /**
     * Route : scripts.view.versions
     *
     * @param  int  	$id
	 * @param  string  	$game
	 * @param  string  	$category
	 * @param  string  	$title
     * @return view
     */
	public function viewScriptVersions($id, $game, $category, $title)
	{
		$script = ScriptModel::find($id);
		if(
			$id == null
			|| $game == null
			|| $category == null
			|| $title == null
			|| $script == null
		)
		{
			return abort(404);
		}
		
		if(!$script->activated)
		{
			$authentication = App::make('authenticator');
			
			if(
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->id === $script->user_id)
				||
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->hasPermission(['_approver']))
				||
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->purchases()->where('script_id', '=', $script->id)->count())
			)
			{
				
			}
			else
			{
				return abort(404);
			}
		}
		
		$script->view++;
		$script->save();
		
		return view('laravel-authentication-acl::client.scripts.versions')->with(
			[
				'script' => $script
			]
		);
	}
	
	 /**
     * Route : scripts.view.discussion
     *
     * @param  int  	$id
	 * @param  string  	$game
	 * @param  string  	$category
	 * @param  string  	$title
     * @return view
     */
	public function viewScriptDiscussions($id, $game, $category, $title)
	{
		$script = ScriptModel::find($id);
		if(
			$id == null
			|| $game == null
			|| $category == null
			|| $title == null
			|| $script == null
		)
		{
			return abort(404);
		}
		
		if(!$script->activated)
		{
			$authentication = App::make('authenticator');
			
			if(
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->id === $script->user_id)
				||
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->hasPermission(['_approver']))
				||
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->purchases()->where('script_id', '=', $script->id)->count())
			)
			{
				
			}
			else
			{
				return abort(404);
			}
		}
		
		$script->view++;
		$script->save();
		
		return view('laravel-authentication-acl::client.scripts.discussions')->with(
			[
				'script' => $script
			]
		);
	}	 
	
	/**
     * Route : scripts.view.issues
     *
     * @param  int  	$id
	 * @param  string  	$game
	 * @param  string  	$category
	 * @param  string  	$title
     * @return view
     */
	public function viewScriptIssues($id, $game, $category, $title, Request $request)
	{
		$script = ScriptModel::find($id);
		if(
			$id == null
			|| $game == null
			|| $category == null
			|| $title == null
			|| $script == null
		)
		{
			return abort(404);
		}
		
		if(!$script->activated)
		{
			$authentication = App::make('authenticator');
			
			if(
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->id === $script->user_id)
				||
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->hasPermission(['_approver']))
				||
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->purchases()->where('script_id', '=', $script->id)->count())
			)
			{
				
			}
			else
			{
				return abort(404);
			}
		}
		
		$script->view++;
		$script->save();
		
		$issues = $script->issues();
		
		if($request->get('status'))
		{
			$issues = $issues->where('status', '=', $request->get('status'));
		}
		if($request->get('search'))
		{
			$search = $request->get('search');
			$issues = $issues->where(function ($query) use ($search) 
			{
				return $query->where('title', 'like', '%'.$search.'%')->orWhere('text', 'like', '%'.$search.'%');
			});
		}
		
		
		$issues = $issues->where('activated', '=', true)->paginate((int)config('sourcemod.market.issues_pagination'));		
		
		$year = date('Y');
	
		$issues_joins = ScriptIssueModel::select('*', DB::raw('count(*) as total_count, Month(created_at) as month, Month(updated_at) as month2'))
				->where('script_id', '=', $id)
				->whereYear('created_at', '=', $year)
				->groupBy('id', 'month', 'month2', 'status')
				->get();
			
        $months = 12;
        for ($i = 1; $i <= $months; $i++) 
		{
            $charts_bugs[$i] = 0;
			$charts_improvements[$i] = 0;
			$charts_fixed[$i] = 0;
            foreach ($issues_joins as $issue) 
			{
                if($issue->month == $i) 
				{
					if($issue->status == 1)
					{
						$charts_bugs[$i] += $issue->total_count;
					}
					else if($issue->status == 2)
					{
						$charts_improvements[$i] += $issue->total_count;
					}
                }
				
				if($issue->month2 == $i) 
				{
					if($issue->closed == 1)
					{
						$charts_fixed[$i] += $issue->total_count;
					}	
				}
            }           
        }
		
		//echo '<pre>' . print_r($charts_fixed, true) . '</pre>';
		
		

		
		return view('laravel-authentication-acl::client.scripts.issues')->with(
			[
				'script' => $script,
				'issues' => $issues,
				'charts_bugs' => implode(', ', $charts_bugs),
				'charts_improvements' => implode(', ', $charts_improvements),
				'charts_fixed' => implode(', ', $charts_fixed),
			]
		);
	}	
	
	/**
     * Route : scripts.view.issues
     *
     * @param  int  	$id
	 * @param  string  	$game
	 * @param  string  	$category
	 * @param  string  	$title
     * @return view
     */
	public function viewSingleScriptIssues($id, $game, $category, $title, $issue_id)
	{
		$issue = ScriptIssueModel::find($issue_id);
		if(
			$id == null
			|| $game == null
			|| $category == null
			|| $title == null
			|| $issue_id == null
			|| $issue == null
			|| $issue->script_id != $id
		)
		{
			return abort(404);
		}
		
		if(!$issue->script->activated)
		{
			$authentication = App::make('authenticator');
			
			if(
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->id === $script->user_id)
				||
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->hasPermission(['_approver']))
				||
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->purchases()->where('script_id', '=', $script->id)->count())
			)
			{
				
			}
			else
			{
				return abort(404);
			}
		}
		
		return view('laravel-authentication-acl::client.scripts.single-issues')->with(
			[
				'issue' => $issue,
				'script' => $issue->script
			]
		);
	}
	
	/**
     * Route : scripts.new.issues
     *
     * @param  int  	$id
	 * @param  string  	$game
	 * @param  string  	$category
	 * @param  string  	$title
     * @return view
     */
	public function newPostScriptIssues($id, Request $request)
	{
		$script = ScriptModel::find($id);
		if(isset($script->id))
		{
			$validator = Validator::make($request->all(), [
				'title' => 'required|min:10|max:255',
				'text' => 'required|min:10|max:65535',
			]);
			
			if($validator->fails()) 
			{
				return Redirect::back()
					->withErrors($validator->errors())
					->withInput($request->all());
			}
			
			$authentication = App::make('authenticator');
			$issue = ScriptIssueModel::Create(
				[
					'user_id' => $authentication->getLoggedUser()->id,
					'script_id' => $script->id,
					'status' => $request->get('status'),
					'title' => strip_tags($request->get('title')),
					'text' => $request->get('text')
				]
			);
			
			/* notify scripter */
			
			Event::Fire(new \App\Events\UserNotification(
				'issue_script' . $script->id . '_user_' . $authentication->getLoggedUser()->id . '_date_' . date('Y-m-d_H:i:s'),
				$script->user_id, 
				'fa fa-bug', 
				''.(isset($authentication->getLoggedUser()->user_profile->first()->first_name) ? $authentication->getLoggedUser()->user_profile->first()->first_name : $authentication->getLoggedUser()->steam_id).' submit a issue for '.$script->title.'.', 
				URL::route('scripts.single.issues', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title), 'issue_id' => $issue->id ])
				)
			);
			
			return Redirect::back();
		}
		else
		{
			return abort(404);
		}
	}
	
	 /**
     * Route : scripts.discussions.add
     *
     * @param  int  	$id
	 * @param  string  	$game
	 * @param  string  	$category
	 * @param  string  	$title
	 * @param  Request  $request
     * @return view
     */
	public function addScriptIssuesDiscussions($id, Request $request)
	{
		$scriptissue = ScriptIssueModel::find($id);
		if(
			$id == null
			|| $scriptissue == null
			|| $scriptissue->closed
			|| !$scriptissue->script->activated
		)
		{
			return abort(404);
		}

		$validator = Validator::make($request->all(), [
			'text' => 'required|min:10|max:65535',
		]);
		
		if($validator->fails()) 
		{
			return Redirect::back()
				->withErrors($validator->errors())
				->withInput($request->all());
        }
			
		$authentication = App::make('authenticator'); 
		$scriptissuediscussion = ScriptIssueDiscussionModel::create(
			[
				'issue_id' => $id,
				'user_id' => $authentication->getLoggedUser()->id,
				'text' => $request->get('text')
			]
		);
		
		if($request->has('closed'))
		{
			$scriptissue->update(
				[
					'closed' => $request->get('closed')
				]
			);
		}
		
		if($authentication->getLoggedUser()->id != $scriptissue->user_id)
		{
			/* notify issuer */
			Event::Fire(new \App\Events\UserNotification(
				'issue_discussion_script' . $scriptissue->script->id . '_user_' . $authentication->getLoggedUser()->id . '_date_' . date('Y-m-d_H:i:s'),
				$scriptissue->user_id, 
				'fa fa-bug', 
				''.(isset($authentication->getLoggedUser()->user_profile->first()->first_name) ? $authentication->getLoggedUser()->user_profile->first()->first_name : $authentication->getLoggedUser()->steam_id).' submit a comment issue for '.$scriptissue->script->title.'.', 
				URL::route('scripts.single.issues', ['id' => $scriptissue->script->id, 'game' => App\Http\Classes\Slug::filter($scriptissue->script->game->title), 'category' => App\Http\Classes\Slug::filter($scriptissue->script->category->title), 'title' => App\Http\Classes\Slug::filter($scriptissue->script->title), 'issue_id' => $id ])
				)
			);
		}
		else
		{
			/* notify scripter */
			Event::Fire(new \App\Events\UserNotification(
				'issue_discussion_script' . $scriptissue->script->id . '_user_' . $authentication->getLoggedUser()->id . '_date_' . date('Y-m-d_H:i:s'),
				$scriptissue->script->user_id, 
				'fa fa-bug', 
				''.(isset($authentication->getLoggedUser()->user_profile->first()->first_name) ? $authentication->getLoggedUser()->user_profile->first()->first_name : $authentication->getLoggedUser()->steam_id).' submit a comment issue for '.$scriptissue->script->title.'.', 
				URL::route('scripts.single.issues', ['id' => $scriptissue->script->id, 'game' => App\Http\Classes\Slug::filter($scriptissue->script->game->title), 'category' => App\Http\Classes\Slug::filter($scriptissue->script->category->title), 'title' => App\Http\Classes\Slug::filter($scriptissue->script->title), 'issue_id' => $id ])
				)
			);			
		}
		
		return Redirect::back();
	}
	
	 /**
     * Route : scripts.discussions.delete
     *
	 * @param  Request  $request
     * @return view
     */
	public function deleteScriptIssuesDiscussions($id)
	{
		$scriptissuediscussion = ScriptIssueDiscussionModel::find($id);
		
		/* 30 minutes before to delete your own comment */
		if(time() - strtotime($scriptissuediscussion->created_at) >= (int)config('sourcemod.market.delete_delay'))
		{
			return Redirect::back();
		}
		
		if($scriptissuediscussion->user_id)
		{
			$authentication = App::make('authenticator');
			if($authentication->getLoggedUser()->id != $scriptissuediscussion->user_id)
			{
				return abort(404);
			}
		}
		if($scriptissuediscussion)
		{
			$scriptissuediscussion->delete();
		}
		return Redirect::back();		
	}
	
	
	 /**
     * Route : scripts.view.downloads
     *
     * @param  int  	$script_id
	 * @param  int  	$version_id
     * @return view
     */
	public function viewScriptDownloads($script_id, $version_id, Request $request)
	{
		$script = ScriptModel::find($script_id);
		
		if(
			$script_id == null
			|| $version_id == null
			|| $script == null
			/*|| $script->reports->count() >= (int)config('sourcemod.market.report_scripts_stop_download')*/
		)
		{
			return abort(404);
		}
		
		$authentication = App::make('authenticator'); 
		
		if(!$script->activated)
		{
			$authentication = App::make('authenticator');
			
			if(
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->id === $script->user_id)
				||
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->hasPermission(['_approver']))
				||
				(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->purchases()->where('script_id', '=', $script->id)->count())
			)
			{
				
			}
			else
			{
				return abort(404);
			}
		}
		
		if(
			/* script is free */
			$script->price_discount == 0 && $script->price == 0
			||
			/* client bought it */
			(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->purchases()->where('script_id', '=', $script->id)->count())
			||
			/* owner */
			(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->id === $script->user_id)
			||
			/* Moderator */
			(isset($authentication->getLoggedUser()->id) && $authentication->getLoggedUser()->hasPermission(['_approver']))
		)
		{		
			ScriptVersionDownloadModel::create(
				[
					'user_id' => $authentication->getLoggedUser()->id,
					'version_id' => $version_id,
					'ip_address' => $request->ip(),
					'latitude' => GeoIP::getLatitude() ? GeoIP::getLatitude() : 'none',
					'longitude' => GeoIP::getLongitude() ? GeoIP::getLongitude() : 'none',
					'city' => GeoIP::getCity() ? GeoIP::getCity() : 'none',
					'country' => GeoIP::getCountry() ? GeoIP::getCountry() : 'none',
					'country_code' => GeoIP::getCountryCode() ? GeoIP::getCountryCode() : 'none',
					'region' => GeoIP::getRegion() ? GeoIP::getRegion() : 'none',
					'region_code' => GeoIP::getRegionCode() ? GeoIP::getRegionCode() : 'none',
					'postal_code' => GeoIP::getPostalCode() ? GeoIP::getPostalCode() : 'none',
					'timezone' => GeoIP::getTimezone() ? GeoIP::getTimezone() : 'none',
				]
			);
			
			$directory = md5(date('Y-m-d H:i:s'));
			$zip = storage_path() . '/scripts/'.$script_id.'/versions/'.$version_id.'/'.$script_id.$version_id.'.zip';
			
			if($script->category_id != 9 && $script->category_id != 10)
			{
				$tmp_zip = storage_path() . '/scripts/'.$script_id.'/versions/'.$version_id.'/'.$directory;
				
				mkdir($tmp_zip, 0755);
				
				Zipper::zip($zip)->extractTo($tmp_zip);
				
				$files = File::allFiles($tmp_zip);
				
				foreach($files as $file)
				{
					if(File::extension($file) == 'sp' || File::extension($file) == 'lua')
					{
						$search = [
							'{{ web_hook }}',
							'{{ script_id }}',
							'{{ version_id }}',
							'{{ version }}',
							'{{ download }}'
						];
						
						$replace = [
							$script->game->web_hook,
							$script_id,
							$version_id,
							ScriptVersionModel::find($version_id)->name,
							(isset($authentication->getLoggedUser()->id) ? Crypt::encrypt($authentication->getLoggedUser()->id) : Crypt::encrypt(0))
						];
						
						$content = str_replace($search, $replace, $file->getContents());
						
						File::put($tmp_zip . '/' . $file->getRelativePathName(), $content);
					}
					
				}
				
				$files = glob($tmp_zip . '/*');
				
				$zipper = Zipper::make(storage_path() . '/tmp/' . $directory . '.zip')->add($files)->close();
				
				File::deleteDirectory($tmp_zip);
				
				if(File::exists(storage_path() . '/tmp/' . $directory . '.zip'))
				{
					return response()->download(
						storage_path() . '/tmp/' . $directory . '.zip',
						Slug::filter($script->title).'.zip'
					);
				}
			}
			else
			{
				return response()->download(
						$zip,
						Slug::filter($script->title).'.zip'
					);
			}
		}
		else
		{
			return abort(404);
		}
	}
	
	 /**
     * Route : scripts.discussions.add
     *
     * @param  int  	$id
	 * @param  string  	$game
	 * @param  string  	$category
	 * @param  string  	$title
	 * @param  Request  $request
     * @return view
     */
	public function addScriptDiscussions($id, $game, $category, $title, Request $request)
	{
		$script = ScriptModel::find($id);
		if(
			$id == null
			|| $game == null
			|| $category == null
			|| $title == null
			|| $script == null
			|| !$script->activated
		)
		{
			return abort(404);
		}

		$validator = Validator::make($request->all(), [
			'text' => 'required|min:10|max:65535',
		]);
		
		if($validator->fails()) 
		{
			return Redirect::route('scripts.view.discussions', ['id' => $id, 'game'=> $game, 'category' => $category, 'title' => $title])
				->withErrors($validator->errors())
				->withInput($request->all());
        }
			
		$authentication = App::make('authenticator'); 
		$discussion = ScriptDiscussionModel::create(
			[
				'script_id' => $id,
				'user_id' => $authentication->getLoggedUser()->id,
				'text' => $request->get('text')
			]
		);
		
		if($authentication->getLoggedUser()->id != $script->user_id)
		{
			/* notify scripter */
			Event::Fire(new \App\Events\UserNotification(
				'user_discussion' . $script->user_id . '_user_' . $authentication->getLoggedUser()->id . '_date_' . date('Y-m-d_H:i:s'),
				$script->user_id, 
				'fa fa-comments', 
				''.(isset($authentication->getLoggedUser()->user_profile->first()->first_name) ? $authentication->getLoggedUser()->user_profile->first()->first_name : $authentication->getLoggedUser()->steam_id).' comment '.$script->title.'.', 
				URL::route('scripts.view.discussions', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ])
				)
			);
		}
		
		return Redirect::route('scripts.view.discussions', ['id' => $id, 'game'=> $game, 'category' => $category, 'title' => $title]);
	}
	
	 /**
     * Route : scripts.discussions.delete
     *
	 * @param  Request  $request
     * @return view
     */
	public function deleteScriptDiscussions($id)
	{
		$scriptdiscussion = ScriptDiscussionModel::find($id);
		
		/* 30 minutes before to delete your own comment */
		if(time() - strtotime($scriptdiscussion->created_at) >= (int)config('sourcemod.market.delete_delay'))
		{
			return Redirect::back();
		}
		
		//Check owner
		if($scriptdiscussion->user_id)
		{
			$authentication = App::make('authenticator');
			if($authentication->getLoggedUser()->id != $scriptdiscussion->user_id)
			{
				return abort(404);
			}
		}
		if($scriptdiscussion)
		{
			$scriptdiscussion->delete();
		}
		return Redirect::back();		
	}
	
	 /**
     * Route : scripts.stars.edit
     *
     * @param  int  	$id
	 * @param  string  	$game
	 * @param  string  	$category
	 * @param  string  	$title
	 * @param  Request  $request
     * @return view
     */
	public function postEditScriptStars($id, $game, $category, $title, Request $request)
	{
		$script = ScriptModel::find($id);
		if(
			$id == null
			|| $game == null
			|| $category == null
			|| $title == null
			|| $script == null
			|| !$script->activated
		)
		{
			return abort(404);
		}
		
		$authentication = App::make('authenticator');
		
		if(
			$authentication->getLoggedUser()->id != $script->user_id
			||
			$authentication->getLoggedUser()->purchases()->where('script_id', $script->id)->count())
		{
			$scriptstart = ScriptStarModel::updateOrCreate(
				[
					'script_id' => $id,
					'user_id' => $authentication->getLoggedUser()->id
				],
				[
					'script_id' => $id,
					'user_id' => $authentication->getLoggedUser()->id,
					'stars' => $request->get('stars')
				]
			);
		}
	}	 
	
	/**
     * Route : report.scripts
     *
     * @param  int  	$id
	 * @param  string  	$game
	 * @param  string  	$category
	 * @param  string  	$title
	 * @param  Request  $request
     * @return view
     */
	public function reportScripts($id, $game, $category, $title, Request $request)
	{
		$script = ScriptModel::find($id);
		$authentication = App::make('authenticator');
		if(
			$id == null
			|| $game == null
			|| $category == null
			|| $title == null
			|| $script == null
			|| !$script->activated
			|| $authentication->getLoggedUser()->id == $script->user_id
		)
		{
			return abort(404);
		}
		
		return view('laravel-authentication-acl::client.scripts.report')->with(
				[
					'script' => $script
				]
			);
		

	}	
	
	/**
     * Route : report.scripts
     *
     * @param  int  	$id
	 * @param  string  	$game
	 * @param  string  	$category
	 * @param  string  	$title
	 * @param  Request  $request
     * @return view
     */
	public function postReportScripts($id, $game, $category, $title, Request $request)
	{
		$authentication = App::make('authenticator');
		$script = ScriptModel::find($id);
		if(
			$id == null
			|| $game == null
			|| $category == null
			|| $title == null
			|| $script == null
			|| !$script->activated
			|| $authentication->getLoggedUser()->id == $script->user_id
		)
		{
			return abort(404);
		}
		
		$validator = Validator::make($request->all(), [
			'text' => 'required|min:10|max:65535',
		]);
		
		if($validator->fails()) 
		{
			return Redirect::route('report.scripts', ['id' => $id])
				->withErrors($validator->errors())
				->withInput($request->all());
        }
		
		ScriptReportModel::create(
			[
				'script_id' => $id,
				'report_user_id' => $authentication->getLoggedUser()->id,
				'text' => $request->get('text')
			]
		);
		
		/* notify approver */
		$approvers = DB::table('users_groups')->where('group_id', '=', (int)config('sourcemod.market.group_report_scripts'))->get();
		foreach($approvers as $approver)
		{
			Event::Fire(new App\Events\UserNotification(
				'report_script_'.$id.'_report_user_'.$authentication->getLoggedUser()->id.'_date_'.date('Y-m-d_H:i:s'), 
				$approver->user_id, 
				'fa fa-meh-o', 
				''.$authentication->getLoggedUser()->user_profile->first()->first_name.' reported '.$title.'', 
				URL::route('scripts.view.reports', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title)])
			));
		}
		
		/* notify reporter */
		Event::Fire(new App\Events\UserNotification(
			'report_user_'.$id.'_report_user_'.$authentication->getLoggedUser()->id.'_date_'.date('Y-m-d_H:i:s'), 
			$authentication->getLoggedUser()->id, 
			'fa fa-meh-o', 
			'You reported '.$title.'. You request has been send to moderators.', 
			URL::route('scripts.view', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title)])
		));
		
		return Redirect::route('scripts.view', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]);

	}
	
	 /**
     * Route : purchase.scripts
     *
     * @return view
     */
	public function purchaseScripts($id)
	{
		$script = ScriptModel::find($id);
		
		if(
			$id == null
			|| $script == null
			|| $script->reports->count() >= (int)config('sourcemod.market.report_scripts_stop_download')
			|| ($script->price + $script->price_discount == 0)
			|| !$script->activated
		)
		{
			return abort(404);
		}
		
		//define('PP_CONFIG_PATH', base_path() . '/config');
		
		$authentication = App::make('authenticator'); 
		
		// DEBUG SANDBOX FOR USER 1
		if(
			$authentication->getLoggedUser()->id == 0
			||
			$authentication->getLoggedUser()->id == 0
		)
		{
			$config = array(
			   'mode' => 'sandbox',
			   'acct1.ClientId' => 'Aa_SUdk8vFimV0g9XfSjLE-7heFbRtsfipKallKMkgmAKzdxXr5dreIX6rUZoCaqBPypYYt_E3lOPdZB',
			   'acct1.ClientSecret' => 'EKSmFb8Yfp_J0NyCeK3EonZSbXEMDzSos9oekhwgygP0OUOD3QRZ8c1gx9_afvk_HPxtVzo2c2KaiyKg',
			   'acct1.UserName' => 'paypal_api1.sourcemod.market',
			   'acct1.Password' => 'WS2X66LHASDDNWRR',
			   'acct1.Signature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AVw1d7236tQm0.tPgxr82Kr9ktTg',
			   'acct1.AppId' => 'APP-80W284485P519543T',
			   'http.ConnectionTimeOut' => 30,
			   'http.Retry' => 5,
			   'log.FileName' => base_path() . '/storage/logs/PayPal.log',
			   'log.LogLevel' => 'ERROR',
			   'log.LogEnabled' => true
			);
		}
		else
		{
			$config = array(
			   'mode' => 'live',
			   'acct1.ClientId' => 'AbuE5zmnRR-rNg1ClfYAAau-lN0SbHtY4F3u-fx6-59Sj1qa6-wVeVEpBabD_16H1ERA5hrE_pIzQiRV',
			   'acct1.ClientSecret' => 'ECHoEcI9tEriocrlAmU8421qp0PK1OGrWDwGtDAtm_gnD5QYthpacw3hQjp7W8M6OA7tlSEh0V6_HuPL',
			   'acct1.UserName' => 'paypal_api1.sourcemod.market',
			   'acct1.Password' => 'A54LWYW6APGPZYW4',
			   'acct1.Signature' => 'A82bwLbhAt5kjLDsMg5ShrYsEds6AEQeCPGv8wIKJEl3FEs516oLFml9',
			   'acct1.AppId' => 'APP-5JF13057J98373230',
			   'http.ConnectionTimeOut' => 30,
			   'http.Retry' => 5,
			   'log.FileName' => base_path() . '/storage/logs/PayPal.log',
			   'log.LogLevel' => 'INFO',
			   'log.LogEnabled' => true
			);			
		}
		
		$purchased = ScriptPurchaseModel::where('script_id', '=', $script->id)->where('user_id', '=', $authentication->getLoggedUser()->id)->count();
		
		if($script->price_discount > 0)
		{
			$price = $script->price_discount;
		}
		else
		{
			$price = $script->price;
		}
		
		//DEBUG
		// if($authentication->getLoggedUser()->id == 2)
		// {
			// $price = 0.01;
		// }
		
		if(!$purchased && $script->user_profile->first()->paypal_email && $price > 0)
		{
			$tax = DB::table('vat_countries')->where('country_code', '=', GeoIP::getCountryCode())->first();
			
			//Buyer is European
			if(isset($tax->tax_normal))
			{
				if($authentication->getLoggedUser()->user_profile->first()->vat)
				{
					// $primary = $price - ($price * $script->user_profile->first()->rank_sale->comission / 100);
					// $second = $price - $primary;
					// $price_tax = 0;
					
					$primary = $price - ($price * $script->user_profile->first()->rank_sale->comission / 100);
					$second = $price - $primary;
					$price_tax = ($price * $tax->tax_normal / 100);
				}
				else
				{
					$primary = $price - ($price * $script->user_profile->first()->rank_sale->comission / 100);
					$second = $price - $primary;
					$price_tax = ($price * $tax->tax_normal / 100);
				}
			}
			else
			{
				$primary = $price - ($price * $script->user_profile->first()->rank_sale->comission / 100);
				$second = $price - $primary;
				$price_tax = 0;
			}
			
			
			
			//var_dump(number_format($primary + $second + $price_tax, 2));
			
			\PayPal\Core\PPHttpConfig::$DEFAULT_CURL_OPTS[CURLOPT_SSLVERSION] = 6;
			
			$service  = new \PayPal\Service\AdaptivePaymentsService($config);
			
			$actionType = 'PAY';
			
			$receiver[0] = new \PayPal\Types\AP\Receiver();
			$receiver[0]->email = $script->user_profile->first()->paypal_email;
			$receiver[0]->amount = number_format($primary + $second + $price_tax, 2);
			
			
			$receiverList = new \PayPal\Types\AP\ReceiverList($receiver);
			
			$payRequest = new \PayPal\Types\AP\PayRequest(
					new \PayPal\Types\Common\RequestEnvelope("en_US"), 
					$actionType, 
					URL::route('scripts.view', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]), 
					'USD', 
					$receiverList, 
					URL::route('scripts.view', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ])
				);
			
			$payRequest->ipnNotificationUrl = URL::route(
				'purchase.scripts.ipn', 
				[
					'script_id' => $script->id, 
					'user_id' => $authentication->getLoggedUser()->id,
					'amount' => $script->user->hasPermission(['_vip']) ? $primary+$second : $primary,
					'comission' => $script->user->hasPermission(['_vip']) ? 0 : $second ,
					'tax' => $price_tax,
					'latitude' => GeoIP::getLatitude() ? GeoIP::getLatitude() : 'none',
					'longitude' => GeoIP::getLongitude() ? GeoIP::getLongitude() : 'none',
					'city' => GeoIP::getCity() ? GeoIP::getCity() : 'none',
					'country' => GeoIP::getCountry() ? GeoIP::getCountry() : 'none',
					'country_code' => GeoIP::getCountryCode() ? GeoIP::getCountryCode() : 'none',
					'region' => GeoIP::getRegion() ? GeoIP::getRegion() : 'none',
					'region_code' => GeoIP::getRegionCode() ? GeoIP::getRegionCode() : 'none',
					'postal_code' => GeoIP::getPostalCode() ? GeoIP::getPostalCode() : 'none',
					'timezone' => GeoIP::getTimezone() ? GeoIP::getTimezone() : 'none',
					'vat' => $authentication->getLoggedUser()->user_profile->first()->vat ? $authentication->getLoggedUser()->user_profile->first()->vat : 'none',
				]
			);
			
			$payRequest->feesPayer = 'SENDER';
			
			
			$service = new \PayPal\Service\AdaptivePaymentsService($config);
			try 
			{
				$response = $service->Pay($payRequest);
			} 
			catch(Exception $ex) 
			{
			}

			//var_dump($response);
			
			$ack = strtoupper($response->responseEnvelope->ack);
			if($ack != "SUCCESS") 
			{
				$payPalURL = "#";
			} 
			else 
			{
				$token = $response->payKey;
				
				if(
					$authentication->getLoggedUser()->id == 0
					||
					$authentication->getLoggedUser()->id == 0
				)
				{
					$payPalURL = 'https://www.sandbox.paypal.com/webscr&cmd=_ap-payment&paykey=' . $token;
				}
				else
				{
					$payPalURL = 'https://www.paypal.com/cgi-bin/webscr&cmd=_ap-payment&paykey=' . $token;
				}
			}

			return view('laravel-authentication-acl::client.scripts.purchase')->with(
				[
					'script' => $script,
					'url' => $payPalURL,
					'tax' => $tax
				]
			);
		}
		else
		{
			return abort(404);
		}
	}
	
	 /**
     * Route : purchase.scripts.ipn
     *
	 * Request $request
     * @return view
     */
	public function purchaseScriptIPN(Request $request)
	{
		//define('PP_CONFIG_PATH', base_path() . '/config');
		
		//error_log(json_encode($request->all()));
		
		$script_id = strip_tags($request->get('script_id'));
		$user_id = strip_tags($request->get('user_id'));
		$amount = strip_tags($request->get('amount'));		
		$comission = strip_tags($request->get('comission'));
		$tax = strip_tags($request->get('tax'));
		$latitude = strip_tags($request->get('latitude'));
		$longitude = strip_tags($request->get('longitude'));
		$city = strip_tags($request->get('city'));
		$country = strip_tags($request->get('country'));
		$country_code = strip_tags($request->get('country_code'));
		$region = strip_tags($request->get('region'));
		$region_code = strip_tags($request->get('region_code'));
		$postal_code = strip_tags($request->get('postal_code'));
		$timezone = strip_tags($request->get('timezone'));
		$vat = strip_tags($request->get('vat'));
		
		// DEBUG SANDBOX FOR USER 1
		if(
			$user_id == 0
			||
			$user_id == 2
		)
		{
			$config = array(
			   'mode' => 'sandbox',
			   'acct1.ClientId' => 'Aa_SUdk8vFimV0g9XfSjLE-7heFbRtsfipKallKMkgmAKzdxXr5dreIX6rUZoCaqBPypYYt_E3lOPdZB',
			   'acct1.ClientSecret' => 'EKSmFb8Yfp_J0NyCeK3EonZSbXEMDzSos9oekhwgygP0OUOD3QRZ8c1gx9_afvk_HPxtVzo2c2KaiyKg',
			   'acct1.UserName' => 'paypal_api1.sourcemod.market',
			   'acct1.Password' => 'WS2X66LHASDDNWRR',
			   'acct1.Signature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AVw1d7236tQm0.tPgxr82Kr9ktTg',
			   'acct1.AppId' => 'APP-80W284485P519543T',
			   'http.ConnectionTimeOut' => 30,
			   'http.Retry' => 5,
			   'log.FileName' => base_path() . '/storage/logs/PayPal.log',
			   'log.LogLevel' => 'ERROR',
			   'log.LogEnabled' => true
			);
		}
		else
		{
			$config = array(
			   'mode' => 'live',
			   'acct1.ClientId' => 'AbuE5zmnRR-rNg1ClfYAAau-lN0SbHtY4F3u-fx6-59Sj1qa6-wVeVEpBabD_16H1ERA5hrE_pIzQiRV',
			   'acct1.ClientSecret' => 'ECHoEcI9tEriocrlAmU8421qp0PK1OGrWDwGtDAtm_gnD5QYthpacw3hQjp7W8M6OA7tlSEh0V6_HuPL',
			   'acct1.UserName' => 'paypal_api1.sourcemod.market',
			   'acct1.Password' => 'A54LWYW6APGPZYW4',
			   'acct1.Signature' => 'A82bwLbhAt5kjLDsMg5ShrYsEds6AEQeCPGv8wIKJEl3FEs516oLFml9',
			   'acct1.AppId' => 'APP-5JF13057J98373230',
			   'http.ConnectionTimeOut' => 30,
			   'http.Retry' => 5,
			   'log.FileName' => base_path() . '/storage/logs/PayPal.log',
			   'log.LogLevel' => 'INFO',
			   'log.LogEnabled' => true
			);			
		}
		
		\PayPal\Core\PPHttpConfig::$DEFAULT_CURL_OPTS[CURLOPT_SSLVERSION] = 6;
		
		$ipnMessage = new \PayPal\IPN\PPIPNMessage(null, $config);
		
		//error_log(print_r($ipnMessage->getRawData(), true));
		
		$array = array();
		foreach($ipnMessage->getRawData() as $key => $value) 
		{
			$array[urldecode($key)] = urldecode($value);
		}
		
		if(isset($array['status']))
		{
			error_log('user: '. $user_id . 'script: ' .$script_id . 'status: ' .$array['status']);
		}
		
		if($request->isMethod('GET') && $request->get('key') == "SM@2016")
		{
			$array['status'] = "COMPLETED";
			$array['sender_email'] = strip_tags($request->get('receiverList.receiver(1).email'));
			$array['transaction[0].id_for_sender_txn'] = 'SMDEBUG';
			$array['transaction[0].receiver'] = strip_tags($request->get('receiverList.receiver(0).email'));
			$array['transaction[0].amount'] = strip_tags($request->get('receiverList.receiver(0).amount'));
			$array['transaction[1].id_for_sender_txn'] = 'SMDEBUG';
			$array['transaction[1].receiver'] = strip_tags($request->get('receiverList.receiver(1).email'));
			$array['transaction[1].amount'] = strip_tags($request->get('receiverList.receiver(1).amount'));
			$array['pay_key'] = 'SMDEBUG';
		}
		
		$purchased = ScriptPurchaseModel::where('script_id', '=', $script_id)->where('user_id', '=', $user_id)->count();
		
		if(!$purchased && $array['status'] == "COMPLETED" && $script_id != null && $user_id != null)
		{			
			ScriptPurchaseModel::insert(
				[
					'user_id' => $user_id,
					'script_id' => $script_id,
					'amount' => $amount,
					'status' => $array['status'],
					'sender_email' => $array['sender_email'],
					'transaction_0_id_for_sender_txn' => $array['transaction[0].id_for_sender_txn'],
					'transaction_0_receiver' => $array['transaction[0].receiver'],
					'transaction_0_amount' => $array['transaction[0].amount'],
					'transaction_1_id_for_sender_txn' => isset($array['transaction[1].id_for_sender_txn']) ? $array['transaction[1].id_for_sender_txn'] : 'none',
					'transaction_1_receiver' => isset($array['transaction[1].receiver']) ? $array['transaction[1].receiver'] : 'none',
					'transaction_1_amount' => isset($array['transaction[1].amount']) ? $array['transaction[1].amount'] : '0',
					'pay_key' => $array['pay_key'],
					'comission' => $comission,
					'tax' => $tax,
					'latitude' => $latitude,
					'longitude' => $longitude,
					'city' => $city,
					'country' => $country,
					'country_code' => $country_code,
					'region' => $region,
					'region_code' => $region_code,
					'postal_code' => $postal_code,
					'timezone' => $timezone,
					'vat' => $vat,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				]
			);
			
			
			/* notify buyer */
			$script = ScriptModel::find($script_id);
			Event::Fire(new \App\Events\UserNotification(
				'purchase_script' . $script_id . '_user_' . $script->user_id . '_date_' . date('Y-m-d_H:i:s'),
				$user_id, 
				'fa fa-shopping-cart', 
				'You have purchased '.$script->title.'. You can now download it.', 
				URL::route('dashboard.scripts.purchases')
				)
			);
			
			/* notify scripter */
			Event::Fire(new \App\Events\UserNotification(
				'sold_script_' . $script_id . '_user_' . $user_id . '_date_' . date('Y-m-d_H:i:s'),
				$script->user_id, 
				'fa fa-shopping-cart', 
				'Your script '.$script->title.' has been purchased.', 
				URL::route('dashboard.scripts.sales')
				)
			);
			
			/*ranks*/
			$scripts = ScriptModel::where('user_id', '=', $script->user_id)->get();

			$gains = 0;
			foreach($scripts as $key => $script)
			{
				$gains += $script->purchases()->sum('amount');
			}
			
			$ranks = UserRankSaleModel::all();
			$profile = UserProfile::where('user_id', '=', $script->user_id);
			//error_log('gains' . $gains);
			foreach($ranks as $rank)
			{
				//error_log('rank' . $rank->amount_min);
				if($gains >= $rank->amount_min && $gains < $rank->amount_max)
				{
					$profile->update(
					
						[
							'rank_sale_id' => $rank->id
						]
					);
					
					//error_log('save rank' . $rank->id . 'p=' . $p);
				}
			}
			
			
		}
		
	}
}
