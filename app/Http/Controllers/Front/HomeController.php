<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\ScriptModel as ScriptModel;
use App\Http\Models\Front\UserNotificationModel as UserNotificationModel;
use App\Http\Classes\Word as Word;
use DB, GeoIP;

class HomeController extends Controller
{
    public function index()
	{
		$scripts = ScriptModel::where('activated', true)->take((int)config('sourcemod.market.home_scripts_pagination'))->orderBy( DB::raw('RAND()') )->get();
		$tax = DB::table('vat_countries')->where('country_code', '=', GeoIP::getCountryCode())->first();
		if(isset($tax->tax_normal))
		{
			$tax = $tax->tax_normal;
		}
		else
		{
			$tax = 0;
		}
		return view('laravel-authentication-acl::client.home.index')->with(
			[
				'scripts' => $scripts,
				'tax' => $tax,
			]
		);
	}
	
	public function adblock(Request $request)
	{
		$user_id = $request->get('user_id');
		$run = $request->get('run');
		
		$n = new UserNotificationModel();
		$n->checkAdBlock($user_id, $run);
	}
}
