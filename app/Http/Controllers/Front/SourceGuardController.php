<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\ScriptTrackerModel as ScriptTrackerModel;

class SourceGuardController extends Controller
{
	 /**
     * Route : sourceguard.servers.list
     *
     * @return view
     */
    public function getList(Request $request)
	{
		$scripts = ScriptTrackerModel::whereDate('last_activity', '>', date('Y-m-d',strtotime('-2 day')));
		
		if($request->get('search'))
		{
			$search = $request->get('search');
			$scripts = $scripts->where(function ($query) use ($search) 
			{
				return $query->where('hostname', 'like', '%'.$search.'%')
					->orWhere('ip', 'like', '%'.$search.'%');
			});
		}
		
		if($request->get('game_id'))
		{
			$scripts = $scripts->where('game_id', '=', $request->get('game_id'));
		}
		
		$scripts = $scripts->orderBy('last_activity', 'desc')->paginate((int)config('sourcemod.market.sourceguard_servers_pagination'));
		
		return view('laravel-authentication-acl::client.sourceguard.servers.list')->with(
			[
				'scripts' => $scripts,
			]
		);
	}
}
