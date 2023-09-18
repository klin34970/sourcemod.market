<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\ForumModel as ForumModel;
use App\Http\Models\Front\ForumThreadModel as ForumThreadModel;
use App\Http\Models\Front\ForumThreadReplyModel as ForumThreadReplyModel;
use Redirect, App, Validator;

class ForumController extends Controller
{
	
	 /**
     * Route : community.forum
     *
     * @return view
     */
    public function index()
	{
		$forums = ForumModel::all();
		
		return view('laravel-authentication-acl::client.forum.index')->with(
			[
				'forums' => $forums,
			]
		);
	}
	
	 /**
     * Route : community.forum.forums
     *
     * @param  int  	$id
	 * @param  string  	$title
     * @return view
     */
	public function forum($id, $title)
	{
		$forum = ForumModel::find($id);
		if(
			$id == null
			|| $title == null
			|| $forum == null
		)
		{
			return abort(404);
		}
		
		return view('laravel-authentication-acl::client.forum.forums')->with(
			[
				'forum' => $forum,
			]
		);
	}	
	
	 /**
     * Route : community.forum.threads.new
     *
     * @param  int  	$id
	 * @param  string  	$title
     * @return view
     */
	public function newThread($id, $title)
	{
		$authentication = App::make('authenticator');
		$forum = ForumModel::find($id);
		if(
			$id == null
			|| $title == null
			|| $forum == null
			|| $authentication->getLoggedUser()->isBanned()
			|| ($forum->closed && !$authentication->getLoggedUser()->hasPermission(['_superadmin']))
		)
		{
			return abort(404);
		}
		
		return view('laravel-authentication-acl::client.forum.threads.new')->with(
			[
				'forum' => $forum,
			]
		);
	}		
	
	 /**
     * Route : community.forum.threads.new
     *
     * @param  int  	$id
	 * @param  string  	$title
	 * @param  Request  $request
     * @return view
     */
	public function postNewThread($id, $title, Request $request)
	{
		$authentication = App::make('authenticator');
		$forum = ForumModel::find($id);
		if(
			$id == null
			|| $title == null
			|| $forum == null
			|| $authentication->getLoggedUser()->isBanned()
			|| ($forum->closed && !$authentication->getLoggedUser()->hasPermission(['_superadmin']))
		)
		{
			return abort(404);
		}
		
		$validator = Validator::make($request->all(), [
			'title' => 'required|min:10',
			'text' => 'required|min:10|max:16777215',
		]);
		
		if($validator->fails()) 
		{
			return Redirect::back()
				->withErrors($validator->errors())
				->withInput($request->all());
        }
		
		$lastid = ForumThreadModel::create(
			[
				'forum_id' => $id,
				'user_id' => $authentication->getLoggedUser()->id,
				'title' => strip_tags($request->get('title')),
				'text' => $request->get('text')
			]
		);
		
		return Redirect::route('community.forum.threads', ['id' => $lastid, 'title' => App\Http\Classes\Slug::filter($request->get('title'))]);
	}
	
	
	 /**
     * Route : community.forum.threads
     *
     * @param  int  	$id
	 * @param  string  	$title
     * @return view
     */
	public function thread($id, $title)
	{
		$thread = ForumThreadModel::find($id);
		if(
			$id == null
			|| $title == null
			|| $thread == null
		)
		{
			return abort(404);
		}
		
		$thread->view++;
		$thread->save();
		
		return view('laravel-authentication-acl::client.forum.threads')->with(
			[
				'thread' => $thread,
			]
		);
	}
	
	 /**
     * Route : community.forum.threads.edit
     *
     * @param  int  	$id
	 * @param  string  	$title
     * @return view
     */
	public function editThread($id, $title)
	{
		$authentication = App::make('authenticator');
		$thread = ForumThreadModel::find($id);
		if(
			$id == null
			|| $title == null
			|| $thread == null
			|| $thread->user->id != $authentication->getLoggedUser()->id
			|| $authentication->getLoggedUser()->isBanned()
			|| $thread->closed
		)
		{
			return abort(404);
		}
		
		return view('laravel-authentication-acl::client.forum.threads.edit')->with(
			[
				'thread' => $thread,
			]
		);
	}	
	
	 /**
     * Route : community.forum.threads.edit
     *
     * @param  int  	$id
	 * @param  string  	$title
	 * @param  Request  $request
     * @return view
     */
	public function postEditThread($id, $title, Request $request)
	{
		$authentication = App::make('authenticator');
		$thread = ForumThreadModel::find($id);
		if(
			$id == null
			|| $title == null
			|| $thread == null
			|| $thread->user->id != $authentication->getLoggedUser()->id
			|| $authentication->getLoggedUser()->isBanned()
			|| $thread->closed
		)
		{
			return abort(404);
		}
		
		$validator = Validator::make($request->all(), [
			'title' => 'required|min:10',
			'text' => 'required|min:10|max:16777215',
		]);
		
		if($validator->fails()) 
		{
			return Redirect::back()
				->withErrors($validator->errors())
				->withInput($request->all());
        }
		
		ForumThreadModel::where('id', '=', $id)->update(
			[
				'title' => strip_tags($request->get('title')),
				'text' => $request->get('text')
			]
		);
		
		return Redirect::route('community.forum.threads', ['id' => $id, 'title' => App\Http\Classes\Slug::filter($request->get('title'))]);
		
	}	
	
	 /**
     * Route : community.forum.replies.new
     *
	 * @param  Request  $request
     * @return view
     */
	public function postNewReply($id, Request $request)
	{
		$authentication = App::make('authenticator');
		$thread = ForumThreadModel::find($id);
		
		if(
			$thread == null
			|| $thread->closed
			|| $authentication->getLoggedUser()->isBanned()
		)
		{
			return abort(404);
		}
		
		$validator = Validator::make($request->all(), [
			'text' => 'required|min:10|max:16777215',
		]);
		
		if($validator->fails()) 
		{
			return Redirect::back()
				->withErrors($validator->errors())
				->withInput($request->all());
        }
		
		$newreply = ForumThreadReplyModel::create(
			[
				'thread_id' => $thread->id,
				'user_id' => $authentication->getLoggedUser()->id,
				'text' => $request->get('text')
			]
		);
		
		/* Already automatic */
		//$thread->where('id', '=', $request->get('thread_id'))->update(['updated_at' => date('Y-m-d H:i:s')]);
		
		if($request->has('page'))
		{
			return Redirect::route('community.forum.threads', ['id' => $thread->id, 'title' => App\Http\Classes\Slug::filter($thread->title), 'page' => $request->get('page'), '#reply-'.$newreply->id.'']);
		}
		else
		{
			return Redirect::route('community.forum.threads', ['id' => $thread->id, 'title' => App\Http\Classes\Slug::filter($thread->title), '#reply-'.$newreply->id.'']);
		}	
	}
	

	
	 /**
     * Route : community.forum.replies.edit
     *
     * @param  int  	$id
     * @return view
     */
	public function editReply($id)
	{
		$authentication = App::make('authenticator');
		$reply = ForumThreadReplyModel::find($id);
		if(
			$id == null
			|| $reply == null
			|| $reply->user->id != $authentication->getLoggedUser()->id
			|| $authentication->getLoggedUser()->isBanned()
			|| $reply->thread->closed
		)
		{
			return abort(404);
		}
		
		return view('laravel-authentication-acl::client.forum.replies.edit')->with(
			[
				'reply' => $reply,
			]
		);
	}
	
	 /**
     * Route : community.forum.replies.edit
     *
     * @param  int  	$id
	 * @param  Request  $request
     * @return view
     */
	public function postEditReply($id, Request $request)
	{
		$authentication = App::make('authenticator');
		$reply = ForumThreadReplyModel::find($id);
		if(
			$id == null
			|| $reply == null
			|| $reply->user->id != $authentication->getLoggedUser()->id
			|| $authentication->getLoggedUser()->isBanned()
			|| $reply->thread->closed
		)
		{
			return abort(404);
		}
		
		$validator = Validator::make($request->all(), [
			'text' => 'required|min:10|max:16777215',
		]);
		
		if($validator->fails()) 
		{
			return Redirect::back()
				->withErrors($validator->errors())
				->withInput($request->all());
        }
		
		ForumThreadReplyModel::where('id', '=', $id)->update(
			[
				'text' => $request->get('text')
			]
		);
		
		if($request->has('page'))
		{
			return Redirect::route('community.forum.threads', ['id' => $reply->thread->id, 'title' => App\Http\Classes\Slug::filter($reply->thread->title), 'page' => $request->get('page'), '#reply-'.$reply->id.'']);
		}
		else
		{
			return Redirect::route('community.forum.threads', ['id' => $reply->thread->id, 'title' => App\Http\Classes\Slug::filter($reply->thread->title), '#reply-'.$reply->id.'']);
		}
	}
}
