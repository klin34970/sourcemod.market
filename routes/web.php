<?php
 /*
  |--------------------------------------------------------------------------
  | API
  |--------------------------------------------------------------------------
  |
  */
//dd(Auth::user());
Route::group(['middlewareGroups' => ['api']], function ()
{
	
	/**
	 * API
	 */	
	Route::any('api/tracker/v1/sourcemod', [
		"as"   => "api.tracker.sourcemod",
		"uses" => 'API\TrackerScriptController@sourcemod',
	]);		
	Route::post('api/tracker/v1/garrysmod', [
		"as"   => "api.tracker.garrysmod",
		"uses" => 'API\TrackerScriptController@garrysmod',
	]);
	
	/**
	 * API with auth
	 */
	Route::group(['middleware' => ['api']], function ()
    {	
		
		Route::get('api/scripts/v1/list', [
				"as"   => "api.scripts.list",
				"uses" => 'API\ScriptController@getList',
				"permissions" => "read_scripts"
		]);
		Route::get('api/scripts/v1/{id}', [
				"as"   => "api.scripts.id",
				"uses" => 'API\ScriptController@getScript',
				"permissions" => "read_scripts"
		]);
	});
	
});

/*
  |--------------------------------------------------------------------------
  | Public side (no auth required)
  |--------------------------------------------------------------------------
  |
*/
Route::group(['middlewareGroups' => ['web'], 'middleware' => ['forceSSL']], function ()
{
	
	Route::get('/callback/paypal/ipn', [
		"as"   => "purchase.scripts.ipn",
		"uses" => 'Front\ScriptController@purchaseScriptIPN'
	]);
	
	/**
	 * ERRORS
	 */	
	Route::get('401', function () 
	{
		return response()->view('laravel-authentication-acl::client.exceptions.401', array(), 401);
	}
	)->name('error.401');
	
	Route::get('404', function () 
	{
		return response()->view('laravel-authentication-acl::client.exceptions.404', array(), 404);
	}
	)->name('error.404');
	
	Route::get('500', function () 
	{
		return response()->view('laravel-authentication-acl::client.exceptions.500', array(), 500);
	}
	)->name('error.500');
	
	// Route::get('test', function () 
	// {
		// $key = 'eyJpdiI6IkxQV09RMU9yRTNcLzE5Y0JhNklsSVhBPT0iLCJ2YWx1ZSI6IlwvWTMxdnJ3bnpxRlZnZnR3MFlIOGxRPT0iLCJtYWMiOiJjNWMzNzFmZDgyNDJmZTYzNGE3NWQ4ZTY4MWExMDljN2EyMjMyZjYzMWZlYWQ3MTM1OTc3MGViYjQxNjc2ZjM0In0=';
		// return Crypt::decrypt($key);
	// }
	// )->name('test');
	
	/**
	 * SOAP
	 */	
	Route::get('soap/vies/{country}/{vat}', [
		"as"   => "soap.vies.vat",
		"uses" => 'SOAP\ViesController@checkVAT',
	]);	
	
	/**
	 * SOURCE GUARD
	 */	
	Route::get('sourceguard/servers', [
		"as"   => "sourceguard.servers.list",
		"uses" => 'Front\SourceGuardController@getList',
	]);
	
	/**
	 * SITEMAP
	 */
	Route::get('/process/sitemap-scripts', [
            "as"   => "sitemap.scripts",
            "uses" => 'Front\SitemapController@scripts'
    ]);
	Route::get('/process/sitemap-threads', [
            "as"   => "sitemap.threads",
            "uses" => 'Front\SitemapController@threads'
    ]);
	
	/**
	 * TYPEAHEAD
	 */
	Route::get('/process/typeahead/typeahead', [
            "as"   => "typeahead.typeahead",
            "uses" => 'Front\TypeAHeadController@typeahead'
    ]);	
	
	/**
	 * SEARCH
	 */
	Route::get('/search', [
            "as"   => "search",
            "uses" => 'Front\SearchController@search'
    ]);
	
	/**
	 * HOME
	 */
	Route::get('/', [
            "as"   => "home.index",
            "uses" => 'Front\HomeController@index'
    ]);
	
	/**
	 * GAME
	 */
	// Route::get('/games', [
            // "as"   => "games.list",
            // "uses" => 'Front\GameController@index'
    // ]);
	Route::get('/games/{id}/{title}/scripts', [
            "as"   => "games.scripts.list",
            "uses" => 'Front\ScriptController@getListGameScripts'
    ]);
	
	/**
	 * SCRIPT
	 */
	Route::get('/scripts', [
            "as"   => "scripts.list",
            "uses" => 'Front\ScriptController@index'
    ]);
	Route::get('/scripts/{id}/{game}/{category}/{title}', [
            "as"   => "scripts.view",
            "uses" => 'Front\ScriptController@viewScript'
    ]);
	Route::get('/scripts/{id}/{game}/{category}/{title}/versions', [
            "as"   => "scripts.view.versions",
            "uses" => 'Front\ScriptController@viewScriptVersions'
    ]);
	Route::get('/scripts/{id}/{game}/{category}/{title}/discussions', [
            "as"   => "scripts.view.discussions",
            "uses" => 'Front\ScriptController@viewScriptDiscussions'
    ]);
	Route::get('/scripts/{id}/{game}/{category}/{title}/issues', [
            "as"   => "scripts.view.issues",
            "uses" => 'Front\ScriptController@viewScriptIssues'
    ]);	
	Route::get('/scripts/{id}/{game}/{category}/{title}/issues/{issue_id}', [
            "as"   => "scripts.single.issues",
            "uses" => 'Front\ScriptController@viewSingleScriptIssues'
    ]);
	Route::post('/callback/paypal/ipn', [
		"as"   => "purchase.scripts.ipn",
		"uses" => 'Front\ScriptController@purchaseScriptIPN'
	]);
	
	/**
	 *  JOBS
	 */
	Route::get('/jobs', [
            "as"   => "jobs.list",
            "uses" => 'Front\JobController@index'
    ]);
	Route::get('/jobs/{id}/{game}/{title}', [
            "as"   => "jobs.view",
            "uses" => 'Front\JobController@viewJob'
    ]);
	Route::get('/jobs/{id}/{game}/{title}/discussions', [
            "as"   => "jobs.view.discussions",
            "uses" => 'Front\JobController@viewJobDiscussions'
    ]);
	Route::get('/jobs/{id}/{game}/{title}/appliers', [
			"as"   => "jobs.view.appliers",
			"uses" => 'Front\JobController@appliers'
	]);
	
	/**
	 * FORUM
	 */
	Route::get('/community', [
            "as"   => "community.forum",
            "uses" => 'Front\ForumController@index'
    ]);
	Route::get('/community/forums/{id}-{title}', [
            "as"   => "community.forum.forums",
            "uses" => 'Front\ForumController@forum'
    ]);
	Route::get('/community/threads/{id}/{title}', [
            "as"   => "community.forum.threads",
            "uses" => 'Front\ForumController@thread'
    ]);
	
	/**
	 * ABOUT
	 */
	Route::get('/about/terms', [
            "as"   => "about.terms",
            "uses" => 'Front\AboutController@terms'
    ]);
	Route::get('/about/policy', [
            "as"   => "about.policy",
            "uses" => 'Front\AboutController@policy'
    ]);
	
	/**
	 * HELP
	 */
	Route::get('/help/contact', [
            "as"   => "help.contact",
            "uses" => 'Front\HelpController@contact'
    ]);
	Route::get('/help/faq', [
            "as"   => "help.faq",
            "uses" => 'Front\HelpController@faq'
    ]);
	
	/**
	 * USER
	 */
	 Route::get('/users', [
            "as"   => "users.front.list",
            "uses" => 'Front\UserController@getList'
    ]);
	Route::get('/users/{id}', [
            "as"   => "users.view",
            "uses" => 'Front\UserController@viewUser'
    ]);
	Route::get('/users/{id}/scripts', [
            "as"   => "users.view.scripts",
            "uses" => 'Front\UserController@viewUserScripts'
    ]);
	Route::get('/users/{id}/reputations', [
            "as"   => "users.view.reputations",
            "uses" => 'Front\UserController@viewUserReputations'
    ]);
	
	/**
	 * AUTH
	 */
	Route::get('/login', [
            "as"   => "steam.login",
            "uses" => 'SteamController@getSteamLogin'
    ]);
    Route::get('/admin/login', [
            "as"   => "user.admin.login",
            "uses" => '\LaravelAcl\Authentication\Controllers\AuthController@getAdminLogin'
    ]);
    Route::get('/user/logout', [
            "as"   => "user.logout",
            "uses" => '\LaravelAcl\Authentication\Controllers\AuthController@getLogout'
    ]);
	
	Route::post('/user/login', [
            "uses" => '\LaravelAcl\Authentication\Controllers\AuthController@postAdminLogin',
            "as"   => "user.login.process"
    ]);
	
	/**
	 * NOTIFICATIONS
	 */
	 
	Route::get('/notifications/{id}/view', [
            "as"   => "notifications.view",
            "uses" => 'NotificationController@view'
    ]);
	
	Route::post('/ajax/notifications/list', [
            "as"   => "notifications.user.post.ajax",
            "uses" => 'NotificationController@postAjax'
    ]);

    /*
      |--------------------------------------------------------------------------
      | Logged side (auth required)
      |--------------------------------------------------------------------------
      |
      */
    Route::group(['middleware' => ['logged', 'can_see']], function ()
    {
		/*
		 * SCRIPTS
		 */
		Route::get('/discussions/{id}/scripts/delete', [
				"as"   => "discussions.scripts.delete",
				"uses" => 'Front\ScriptController@deleteScriptDiscussions'
		]);
		Route::post('/scripts/{id}/{game}/{category}/{title}/discussions', [
				"as"   => "scripts.discussions.add",
				"uses" => 'Front\ScriptController@addScriptDiscussions'
		]);
		Route::post('/scripts/{id}/{game}/{category}/{title}/stars', [
            "as"   => "scripts.stars.edit",
            "uses" => 'Front\ScriptController@postEditScriptStars'
		]);
		Route::post('/scripts/{id}/issues/new', [
            "as"   => "scripts.new.issues",
            "uses" => 'Front\ScriptController@newPostScriptIssues'
		]);
		Route::get('/discussions/{id}/scripts/issues/delete', [
            "as"   => "discussions.issues.delete",
            "uses" => 'Front\ScriptController@deleteScriptIssuesDiscussions'
		]);
		Route::post('/scripts/{id}/issues/discussions/add', [
            "as"   => "discussions.issues.add",
            "uses" => 'Front\ScriptController@addScriptIssuesDiscussions'
		]);
		Route::get('report/scripts/{id}/{game}/{category}/{title}', [
            "as"   => "report.scripts",
            "uses" => 'Front\ScriptController@reportScripts'
		]);
		Route::post('report/scripts/{id}/{game}/{category}/{title}', [
            "as"   => "report.scripts",
            "uses" => 'Front\ScriptController@postReportScripts'
		]);
		Route::get('/downloads/scripts/{script_id}/versions/{version_id}', [
            "as"   => "scripts.view.downloads",
            "uses" => 'Front\ScriptController@viewScriptDownloads'
		]);
		
		/*
		 * JOBS
		 */
		Route::get('/discussions/{id}/jobs/delete', [
				"as"   => "discussions.jobs.delete",
				"uses" => 'Front\JobController@deleteJobDiscussions'
		]);
		Route::post('/jobs/{id}/{game}/{title}/discussions', [
				"as"   => "jobs.discussions.add",
				"uses" => 'Front\JobController@addJobDiscussions'
		]);
		Route::get('/appliers/{id}/jobs/delete', [
				"as"   => "appliers.jobs.delete",
				"uses" => 'Front\JobController@deleteJobApplier'
		]);
		Route::post('/jobs/{id}/{game}/{title}/appliers', [
				"as"   => "jobs.appliers.add",
				"uses" => 'Front\JobController@addJobApplier'
		]);
		Route::get('/appliers/{id}/jobs/users', [
				"as"   => "appliers.jobs.users",
				"uses" => 'Front\JobController@JobApplierUser'
		]);
		Route::get('/appliers/done/{id}/jobs/users', [
				"as"   => "appliers.jobs.users.done",
				"uses" => 'Front\JobController@JobDoneApplierUser'
		]);

		
		/*
		 * PURCHASE
		 */
		Route::get('/purchase/scripts/{id}', [
				"as"   => "purchase.scripts",
				"uses" => 'Front\ScriptController@purchaseScripts'
		]);
		
		/*
		 * FORUM
		 */
		Route::get('/community/forums/{id}-{title}/new', [
            "as"   => "community.forum.threads.new",
            "uses" => 'Front\ForumController@newThread'
		]);
		Route::post('/community/forums/{id}-{title}/new', [
            "as"   => "community.forum.threads.new",
            "uses" => 'Front\ForumController@postNewThread'
		]);
		
		Route::get('/community/threads/{id}/{title}/edit', [
            "as"   => "community.forum.threads.edit",
            "uses" => 'Front\ForumController@editThread'
		]);
		Route::post('/community/threads/{id}/{title}/edit', [
            "as"   => "community.forum.threads.edit",
            "uses" => 'Front\ForumController@postEditThread'
		]);

		Route::post('/community/replies/{id}/new', [
            "as"   => "community.forum.replies.new",
            "uses" => 'Front\ForumController@postNewReply'
		]);
		
		Route::get('/community/replies/{id}/edit', [
            "as"   => "community.forum.replies.edit",
            "uses" => 'Front\ForumController@editReply'
		]);
		Route::post('/community/replies/{id}/edit', [
            "as"   => "community.forum.replies.edit",
            "uses" => 'Front\ForumController@postEditReply'
		]);
		
		
        /**
         * DASHBOARD
         */
		Route::get('/dashboard', [
                'as'   => 'dashboard.index',
                'uses' => 'Front\Dashboard\ScriptController@index'
        ]);
		
		/* Scripts*/
		Route::get('/dashboard/scripts', [
                'as'   => 'dashboard.scripts',
                'uses' => 'Front\Dashboard\ScriptController@getScriptsList'
        ]);
		Route::get('/dashboard/scripts/new', [
                'as'   => 'dashboard.scripts.new',
                'uses' => 'Front\Dashboard\ScriptController@newScript'
        ]);
		Route::post('/dashboard/scripts/new', [
                'as'   => 'dashboard.scripts.new',
                'uses' => 'Front\Dashboard\ScriptController@postNewScript'
        ]);
		Route::get('/dashboard/scripts/{script_id}/edit', [
                'as'   => 'dashboard.scripts.edit',
                'uses' => 'Front\Dashboard\ScriptController@editScript'
        ]);
		Route::post('/dashboard/scripts/{script_id}/edit', [
                'as'   => 'dashboard.scripts.edit',
                'uses' => 'Front\Dashboard\ScriptController@postEditScript'
        ]);
		Route::get('/dashboard/scripts/{script_id}/disable', [
                'as'   => 'dashboard.scripts.disable',
                'uses' => 'Front\Dashboard\ScriptController@disableScript'
        ]);
		Route::get('/dashboard/scripts/{script_id}/active', [
                'as'   => 'dashboard.scripts.active',
                'uses' => 'Front\Dashboard\ScriptController@activeScript'
        ]);
		
		Route::get('/dashboard/scripts/{script_id}/versions/new', [
                'as'   => 'dashboard.scripts.versions.new',
                'uses' => 'Front\Dashboard\ScriptController@newScriptVersion'
        ]);
		Route::post('/dashboard/scripts/{script_id}/versions/new', [
                'as'   => 'dashboard.scripts.versions.new',
                'uses' => 'Front\Dashboard\ScriptController@postNewScriptVersion'
        ]);
		Route::get('/dashboard/scripts/{script_id}/versions/{version_id}/edit', [
                'as'   => 'dashboard.scripts.versions.edit',
                'uses' => 'Front\Dashboard\ScriptController@editScriptVersion'
        ]);
		Route::post('/dashboard/scripts/{script_id}/versions/{version_id}/edit', [
                'as'   => 'dashboard.scripts.versions.edit',
                'uses' => 'Front\Dashboard\ScriptController@postEditScriptVersion'
        ]);
		Route::get('/dashboard/scripts/{script_id}/versions/{version_id}/delete', [
                'as'   => 'dashboard.scripts.versions.delete',
                'uses' => 'Front\Dashboard\ScriptController@deleteScriptVersion'
        ]);
		
		/* Jobs */
		Route::get('/dashboard/jobs', [
                'as'   => 'dashboard.jobs',
                'uses' => 'Front\Dashboard\JobController@getJobsList'
        ]);
		Route::get('/dashboard/jobs/new', [
                'as'   => 'dashboard.jobs.new',
                'uses' => 'Front\Dashboard\JobController@newJob'
        ]);
		Route::post('/dashboard/jobs/new', [
                'as'   => 'dashboard.jobs.new',
                'uses' => 'Front\Dashboard\JobController@postNewJob'
        ]);
		Route::get('/dashboard/jobs/{job_id}/edit', [
                'as'   => 'dashboard.jobs.edit',
                'uses' => 'Front\Dashboard\JobController@editJob'
        ]);
		Route::post('/dashboard/jobs/{job_id}/edit', [
                'as'   => 'dashboard.jobs.edit',
                'uses' => 'Front\Dashboard\JobController@postEditJob'
        ]);
		
		/* Api */
		Route::get('/dashboard/api', [
                'as'   => 'dashboard.api.keys',
                'uses' => 'Front\Dashboard\APIController@getList'
        ]);
		Route::get('/dashboard/api/key/new', [
                'as'   => 'dashboard.api.keys.new',
                'uses' => 'Front\Dashboard\APIController@new1'
        ]);
		Route::post('/dashboard/api/key/new', [
                'as'   => 'dashboard.api.keys.new',
                'uses' => 'Front\Dashboard\APIController@postNew'
        ]);
		Route::get('/dashboard/api/key/{id}/edit', [
                'as'   => 'dashboard.api.keys.edit',
                'uses' => 'Front\Dashboard\APIController@edit'
        ]);
		Route::post('/dashboard/api/key/{id}/edit', [
                'as'   => 'dashboard.api.keys.edit',
                'uses' => 'Front\Dashboard\APIController@postEdit'
        ]);
		
		/* Messages */
		Route::get('/dashboard/messages', [
                'as'   => 'dashboard.messages.list',
                'uses' => 'Front\Dashboard\UserMessageController@getList'
        ]);
		Route::get('/dashboard/messages/read/{id}', [
                'as'   => 'dashboard.messages.read',
                'uses' => 'Front\Dashboard\UserMessageController@read'
        ]);
		Route::post('/dashboard/messages/reply/{id}', [
                'as'   => 'dashboard.messages.replies',
                'uses' => 'Front\Dashboard\UserMessageController@reply'
        ]);
		
		/**
         * USER
         */
		Route::get('dashboard/users/profile', [
            "as"   => "dashboard.users.self",
            "uses" => 'Front\UserController@viewUserSelf'
		]);
		Route::post('dashboard/users/profile', [
            "as"   => "dashboard.users.self",
            "uses" => 'Front\UserController@postUserSelf'
		]);
		Route::get('report/users/{id}', [
            "as"   => "report.users",
            "uses" => 'Front\UserController@reportUsers'
		]);
		Route::post('report/users/{id}', [
            "as"   => "report.users",
            "uses" => 'Front\UserController@postReportUsers'
		]);
		Route::get('contact/users/{id}', [
            "as"   => "contact.users",
            "uses" => 'Front\UserController@contactUsers'
		]);
		Route::post('contact/users/{id}', [
            "as"   => "contact.users",
            "uses" => 'Front\UserController@postContactUsers'
		]);
		
		/**
         * PURCHASES
         */
		Route::get('dashboard/purchase/scripts', [
            "as"   => "dashboard.scripts.purchases",
            "uses" => 'Front\Dashboard\ScriptController@getListPurchaseScript'
		]);
		
		/*
		 * SALES
		 */
		Route::get('dashboard/sales/scripts/', [
				"as"   => "dashboard.scripts.sales",
				"uses" => 'Front\Dashboard\ScriptController@getListSalesScript'
		]);
		
		/*
		 * NOTIFICATIONS
		 */
		Route::get('dashboard/notifications/', [
				"as"   => "dashboard.notifications",
				"uses" => 'Front\Dashboard\ScriptController@getNotificationsList'
		]);
		
		Route::get('dashboard/notifications/read/all', [
				"as"   => "dashboard.notifications.read.all",
				"uses" => 'Front\Dashboard\ScriptController@readAllNotifications'
		]);
		
		
	});
	
	
     /*
      |--------------------------------------------------------------------------
      | Approver (auth required)
      |--------------------------------------------------------------------------
      |
      */
	Route::group(['middleware' => ['has_perm:_approver']], function ()
    {
		Route::get('admins/scripts', [
				"as"   => "admins.scripts",
				"uses" => 'Admin\ScriptController@getList'
		]);
		Route::post('admins/scripts/approvement', [
				"as"   => "admins.scripts.approvement",
				"uses" => 'Admin\ScriptController@postApprovement'
		]);
		Route::get('/scripts/{id}/{game}/{category}/{title}/reports', [
            "as"   => "scripts.view.reports",
            "uses" => 'Admin\ScriptController@viewScriptReports'
		]);

		
	});
	
     /*
      |--------------------------------------------------------------------------
      | Users Management (auth required)
      |--------------------------------------------------------------------------
      |
      */
	Route::group(['middleware' => ['has_perm:_users-management']], function ()
    {
		Route::get('admins/users', [
				"as"   => "admins.users",
				"uses" => 'Admin\UserController@getList'
		]);
		Route::get('/users/{id}/reports', [
            "as"   => "users.view.reports",
            "uses" => 'Admin\UserController@viewUserReports'
		]);
		
		Route::get('/users/{id}/ban', [
            "as"   => "users.bans",
            "uses" => 'Admin\UserController@banUser'
		]);	
		Route::post('/users/{id}/ban', [
            "as"   => "users.bans",
            "uses" => 'Admin\UserController@postBanUser'
		]);
		Route::get('/users/{id}/unban', [
            "as"   => "users.unbans",
            "uses" => 'Admin\UserController@postunBanUser'
		]);		
	});
	
	
    /*
      |--------------------------------------------------------------------------
      | Admin side (auth required)
      |--------------------------------------------------------------------------
      |
      */
    Route::group(['middleware' => ['admin_logged', 'has_perm:_superadmin']], function ()
    {		
		Route::get('/dashboard/admin', [
                'as'   => 'dashboard.admin',
                'uses' => 'Front\Dashboard\ScriptController@admin'
        ]);	
		/**
         * user
         */
        Route::get('/admin/users/dashboard', [
                'as'   => 'dashboard.default',
                'uses' => '\LaravelAcl\Authentication\Controllers\UserController@getList'
        ]);
        Route::get('/admin/users/list', [
                'as'   => 'users.list',
                'uses' => '\LaravelAcl\Authentication\Controllers\UserController@getList'
        ]);
        Route::get('/admin/users/edit', [
                'as'   => 'users.edit',
                'uses' => '\LaravelAcl\Authentication\Controllers\UserController@editUser'
        ]);
        Route::post('/admin/users/edit', [
                'as'   => 'users.edit',
                'uses' => '\LaravelAcl\Authentication\Controllers\UserController@postEditUser'
        ]);
        Route::get('/admin/users/delete', [
                'as'   => 'users.delete',
                'uses' => '\LaravelAcl\Authentication\Controllers\UserController@deleteUser'
        ]);
        Route::post('/admin/users/groups/add', [
                'as'   => 'users.groups.add',
                'uses' => '\LaravelAcl\Authentication\Controllers\UserController@addGroup'
        ]);
        Route::post('/admin/users/groups/delete', [
                'as'   => 'users.groups.delete',
                'uses' => '\LaravelAcl\Authentication\Controllers\UserController@deleteGroup'
        ]);
        Route::post('/admin/users/editpermission', [
                'as'   => 'users.edit.permission',
                'uses' => '\LaravelAcl\Authentication\Controllers\UserController@editPermission'
        ]);
        Route::get('/admin/users/profile/edit', [
                'as'   => 'users.profile.edit',
                'uses' => '\LaravelAcl\Authentication\Controllers\UserController@editProfile'
        ]);
        Route::post('/admin/users/profile/edit', [
                'as'   => 'users.profile.edit',
                'uses' => '\LaravelAcl\Authentication\Controllers\UserController@postEditProfile'
        ]);
        Route::post('/admin/users/profile/addField', [
                'as'   => 'users.profile.addfield',
                'uses' => '\LaravelAcl\Authentication\Controllers\UserController@addCustomFieldType'
        ]);
        Route::post('/admin/users/profile/deleteField', [
                'as'   => 'users.profile.deletefield',
                'uses' => '\LaravelAcl\Authentication\Controllers\UserController@deleteCustomFieldType'
        ]);
        Route::post('/admin/users/profile/avatar', [
                'as'   => 'users.profile.changeavatar',
                'uses' => '\LaravelAcl\Authentication\Controllers\UserController@changeAvatar'
        ]);
        Route::get('/admin/users/profile/self', [
                'as'   => 'users.selfprofile.edit',
                'uses' => '\LaravelAcl\Authentication\Controllers\UserController@editOwnProfile'
        ]);

        /**
         * groups
         */
        Route::get('/admin/groups/list', [
                'as'   => 'groups.list',
                'uses' => '\LaravelAcl\Authentication\Controllers\GroupController@getList'
        ]);
        Route::get('/admin/groups/edit', [
                'as'   => 'groups.edit',
                'uses' => '\LaravelAcl\Authentication\Controllers\GroupController@editGroup'
        ]);
        Route::post('/admin/groups/edit', [
                'as'   => 'groups.edit',
                'uses' => '\LaravelAcl\Authentication\Controllers\GroupController@postEditGroup'
        ]);
        Route::get('/admin/groups/delete', [
                'as'   => 'groups.delete',
                'uses' => '\LaravelAcl\Authentication\Controllers\GroupController@deleteGroup'
        ]);
        Route::post('/admin/groups/editpermission', [
                'as'   => 'groups.edit.permission',
                'uses' => '\LaravelAcl\Authentication\Controllers\GroupController@editPermission'
        ]);

        /**
         * permissions
         */
        Route::get('/admin/permissions/list', [
                'as'   => 'permission.list',
                'uses' => '\LaravelAcl\Authentication\Controllers\PermissionController@getList'
        ]);
        Route::get('/admin/permissions/edit', [
                'as'   => 'permission.edit',
                'uses' => '\LaravelAcl\Authentication\Controllers\PermissionController@editPermission'
        ]);
        Route::post('/admin/permissions/edit', [
                'as'   => 'permission.edit',
                'uses' => '\LaravelAcl\Authentication\Controllers\PermissionController@postEditPermission'
        ]);
        Route::get('/admin/permissions/delete', [
                'as'   => 'permission.delete',
                'uses' => '\LaravelAcl\Authentication\Controllers\PermissionController@deletePermission'
        ]);
    });
});