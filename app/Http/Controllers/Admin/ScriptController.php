<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\ScriptModel as ScriptModel;
use App\Http\Models\Front\ScriptReasonModel as ScriptReasonModel;
use App, URL, Event, DB;

class ScriptController extends Controller
{
    public function getList(Request $request)
	{
		$reasons = new ScriptReasonModel();
		$scripts = ScriptModel::select(
			'*', 
			DB::raw('(select count(*) from `scripts_reports` where `scripts_reports`.`script_id` = `scripts`.`id`) as report')
		);
		
		$scripts = $scripts->orderBy('report', $request->has('report') ?  $request->get('report') : 'asc');
		
		$scripts = $scripts->orderBy('created_at', $request->has('create') ?  $request->get('create') : 'asc');
		
		if($request->get('search'))
		{
			$search = $request->get('search');
			$scripts = $scripts->where(function ($query) use ($search) 
			{
				return $query->where('title', 'like', '%'.$search.'%')->orWhere('description', 'like', '%'.$search.'%');
			});
		}
		if($request->has('activated'))
		{
			$scripts = $scripts->where('activated', '=', $request->get('activated'));
		}
		if($request->get('game_id'))
		{
			$scripts = $scripts->where('game_id', '=', $request->get('game_id'));
		}
		
		if($request->get('reason_id'))
		{
			$scripts = $scripts->where('reason_id', '=', $request->get('reason_id'));
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
		
		$scripts = $scripts->paginate((int)config('sourcemod.market.admins_scripts_pagination'));
		
		return view('laravel-authentication-acl::client.admins.scripts.list')->with(
			[
				'scripts' => $scripts,
				'reasons' => $reasons->_getReasonsList(),
			]
		);
	}
	
	public function postApprovement(Request $request)
	{
		$reason_id = $request->get('reason_id');
		$script_id = $request->get('script_id');
		
		$reason = ScriptReasonModel::find($reason_id);

		switch($reason->action)
		{
			default:
				$active = false;
				break;
			case 'active':
				$active = true;
				break;
			case 'pending':
				$active = false;
				break;
			case 'disable':
				$active = false;
				break;
		}
		
		$update = ScriptModel::where('id', $script_id)->update(
			[
				'activated' => $active,
				'reason_id' => $reason_id,
			]
		);
		
		if($update)
		{
			$authentication = App::make('authenticator');
			$script = ScriptModel::find($script_id);
			
			Event::Fire(new \App\Events\UserNotification(
				'approvement_script_' . $script_id . '_user_' . $authentication->getLoggedUser()->id .'_date_'.date('Y-m-d_H:i:s'),
				$script->user_id, 
				'fa fa-eye', 
				'Your script '.$script->title.' has been reviewed by a Moderator: '.$script->reason->reason.'', 
				URL::route('dashboard.scripts')
				)
			);
			
			return response()->json(['success' => true]);
		}
	}
	
	public function viewScriptReports($id, $game, $category, $title)
	{
		$authentication = App::make('authenticator');
		if($authentication->getLoggedUser()->hasPermission(['_approver']))
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
			
			
			return view('laravel-authentication-acl::client.scripts.reports')->with(
				[
					'script' => $script
				]
			);
		}
		else
		{
			return abort(404);
		}
	}
}
