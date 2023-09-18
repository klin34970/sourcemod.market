<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Http\Models\Front\ScriptModel as ScriptModel;

use DB;

class FooterComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
		$total_scripts = DB::table('scripts')->where('activated', '=', true)->count();
		$total_views = DB::table('scripts')->sum('view')+DB::table('jobs')->sum('view');
		$total_users = DB::table('users')->count();
		$total_users_online = DB::table('users')->where('online', true)->count();
		$total_jobs = DB::table('jobs')->where('activated', '=', true)->count();
		$total_downloads = DB::table('scripts_versions_downloads')->count();
		
        $view->with(
			[
				'total_scripts' => $total_scripts,
				'total_users' => $total_users,
				'total_users_online' => $total_users_online,
				'total_jobs' => $total_jobs,
				'total_views' => $total_views,
				'total_downloads' => $total_downloads,
			]
		);
    }
}