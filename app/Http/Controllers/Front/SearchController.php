<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\ScriptModel as ScriptModel;
use App\Http\Models\Front\ScriptIssueModel as ScriptIssueModel;
use App\Http\Models\Front\ScriptIssueDiscussionModel as ScriptIssueDiscussionModel;
use App\Http\Models\Front\ForumThreadModel as ForumThreadModel;
use App\Http\Models\Front\ForumThreadReplyModel as ForumThreadReplyModel;
use \LaravelAcl\Authentication\Models\User as User;
use \LaravelAcl\Authentication\Models\UserProfile as UserProfile;
use App, URL, DB;

class SearchController extends Controller
{
	
	 /**
     * Route : search
     *
     * @param  Request  $request
     * @return view
     */
    public function search(Request $request)
	{
		$search = '';
		
		$keywords = $request->get('keywords');
		
		/* scripts */
		$scripts = ScriptModel::where(function ($query) use ($keywords) 
		{
			return $query->where('title', 'like', '%'.$keywords.'%')
				->orWhere('description', 'like', '%'.$keywords.'%')
				->orWhere('tags', 'like', '%'.$keywords.'%');
		});
		$scripts = $scripts->take((int)config('sourcemod.market.max_search_items'))->get();
		
		if(!$scripts->isEmpty())
		{
			foreach($scripts as $key => $script)
			{
				$search['script'.$key]['tab'] = 'scripts';
				$search['script'.$key]['title'] = str_ireplace($keywords, '<span class="search_keyworkds">'.$keywords.'</span>', $script->title);
				$search['script'.$key]['description'] = str_ireplace($keywords, '<span class="search_keyworkds">'.$keywords.'</span>', $script->description);
				$search['script'.$key]['image'] = url('/') . '/assets/images/scripts/'.$script->id.'/750x212.jpg';
				$search['script'.$key]['url'] = URL::route('scripts.view', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title)]);
			}
		}
		
		
		/* users */
		$users = User::where(function ($query) use ($keywords) 
		{
			return $query->where('steam_id', 'like', '%'.$keywords.'%');
		});
		$users = $users->take((int)config('sourcemod.market.max_search_items'))->get();	
		
		if(!$users->isEmpty())
		{
			foreach($users as $key => $user)
			{
				$search['user'.$key]['tab'] = 'users';
				$search['user'.$key]['title'] = str_ireplace($keywords, '<span class="search_keyworkds">'.$keywords.'</span>', $user->user_profile->first()->first_name);
				$search['user'.$key]['description'] = str_ireplace($keywords, '<span class="search_keyworkds">'.$keywords.'</span>', $user->user_profile->first()->bio);
				$search['user'.$key]['image'] = $user->user_profile->first()->presenter()->avatar('30');
				$search['user'.$key]['url'] = URL::route('users.view', ['id' => $user->id]);
			}
		}
		
		/* users profiles */
		$users_profiles = UserProfile::where(function ($query) use ($keywords) 
		{
			return $query->where('first_name', 'like', '%'.$keywords.'%');
		});
		$users_profiles = $users_profiles->take((int)config('sourcemod.market.max_search_items'))->get();
		
		if(!$users_profiles->isEmpty())
		{
			foreach($users_profiles as $key => $user_profile)
			{
				$search['profile'.$key]['tab'] = 'users';
				$search['profile'.$key]['title'] = str_ireplace($keywords, '<span class="search_keyworkds">'.$keywords.'</span>', $user_profile->first_name);
				$search['profile'.$key]['description'] = str_ireplace($keywords, '<span class="search_keyworkds">'.$keywords.'</span>', $user_profile->bio);
				$search['profile'.$key]['image'] = $user_profile->presenter()->avatar('30');
				$search['profile'.$key]['url'] = URL::route('users.view', ['id' => $user_profile->user_id]);
			}
		}
		
		/* scripts issues */
		$scripts_issues = ScriptIssueModel::where(function ($query) use ($keywords) 
		{
			return $query->where('title', 'like', '%'.$keywords.'%')->orWhere('text', 'like', '%'.$keywords.'%');
		});
		$scripts_issues = $scripts_issues->take((int)config('sourcemod.market.max_search_items'))->get();
		
		if(!$scripts_issues->isEmpty())
		{
			foreach($scripts_issues as $key => $script_issue)
			{
				$search['issues'.$key]['tab'] = 'issues';
				$search['issues'.$key]['title'] = str_ireplace($keywords, '<span class="search_keyworkds">'.$keywords.'</span>', $script_issue->title);
				$search['issues'.$key]['description'] = str_ireplace($keywords, '<span class="search_keyworkds">'.$keywords.'</span>', $script_issue->text);
				$search['issues'.$key]['image'] = url('/') . '/assets/images/scripts/'.$script_issue->script->id.'/750x212.jpg';
				$search['issues'.$key]['url'] = URL::route('scripts.view.issues', ['id' => $script_issue->script->id, 'game' => App\Http\Classes\Slug::filter($script_issue->script->game->title), 'category' => App\Http\Classes\Slug::filter($script_issue->script->category->title), 'title' => App\Http\Classes\Slug::filter($script_issue->script->title), 'search' => $script_issue->title]);
				
				//var_dump($script_issue->title);
			}
		}		
		
		/* forum */
		$forum_threads = ForumThreadModel::where(function ($query) use ($keywords) 
		{
			return $query->where('title', 'like', '%'.$keywords.'%')->orWhere('text', 'like', '%'.$keywords.'%');
		});
		$forum_threads = $forum_threads->take((int)config('sourcemod.market.max_search_items'))->get();
		
		if(!$forum_threads->isEmpty())
		{
			foreach($forum_threads as $key => $forum_thread)
			{
				$search['threads'.$key]['tab'] = 'forum';
				$search['threads'.$key]['title'] = str_ireplace($keywords, '<span class="search_keyworkds">'.$keywords.'</span>', $forum_thread->title);
				$search['threads'.$key]['description'] = str_ireplace($keywords, '<span class="search_keyworkds">'.$keywords.'</span>', $forum_thread->text);
				$search['threads'.$key]['image'] = '';
				$search['threads'.$key]['url'] = URL::route('community.forum.threads', ['id' => $forum_thread->id, 'game' => App\Http\Classes\Slug::filter($forum_thread->title)]);
				
				//var_dump($forum_thread->title);
			}
		}		
		
		/* forum */
		$forum_thread_replies = ForumThreadReplyModel::where(function ($query) use ($keywords) 
		{
			return $query->where('text', 'like', '%'.$keywords.'%');
		});
		$forum_thread_replies = $forum_thread_replies->take((int)config('sourcemod.market.max_search_items'))->get();
		
		if(!$forum_thread_replies->isEmpty())
		{
			foreach($forum_thread_replies as $key => $forum_thread_replie)
			{
				$search['threads'.$key]['tab'] = 'forum';
				$search['threads'.$key]['title'] = str_ireplace($keywords, '<span class="search_keyworkds">'.$keywords.'</span>', $forum_thread_replie->thread->title);
				$search['threads'.$key]['description'] = str_ireplace($keywords, '<span class="search_keyworkds">'.$keywords.'</span>', $forum_thread_replie->text);
				$search['threads'.$key]['image'] = '';
				$search['threads'.$key]['url'] = URL::route('community.forum.threads', ['id' => $forum_thread_replie->thread->id, 'game' => App\Http\Classes\Slug::filter($forum_thread_replie->thread->title)]);
				
				//var_dump($forum_thread_replie->title);
			}
		}
		
		return view('laravel-authentication-acl::client.search.search')->with(
			[
				'search' => $search
			]
		);
	}
}
