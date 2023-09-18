<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\JobModel as JobModel;
use App\Http\Models\Front\JobDiscussionModel as JobDiscussionModel;
use App\Http\Models\Front\JobApplierModel as JobApplierModel;
use App, Redirect, Validator, Event, URL;

class JobController extends Controller
{
	 /**
     * Route : scripts.list
     *
     * @param  Request  $request
     * @return view
     */
	public function index(Request $request)
	{	
		$jobs = JobModel::where('activated', true);
		
		if($request->get('search'))
		{
			$search = $request->get('search');
			$jobs = $jobs->where(function ($query) use ($search) 
			{
				return $query->where('title', 'like', '%'.$search.'%')->orWhere('description', 'like', '%'.$search.'%');
			});
		}
		if($request->get('price_min'))
		{
			$jobs = $jobs->where('price', '>=', $request->get('price_min'));
		}
		if($request->get('price_max'))
		{
			$jobs = $jobs->where('price', '<=', $request->get('price_max'));
		}
		if($request->get('game_id'))
		{
			$jobs = $jobs->where('game_id', '=', $request->get('game_id'));
		}
		if($request->get('category_id'))
		{
			$jobs = $jobs->where('category_id', '=', $request->get('category_id'));
		}
		
		switch($request->get('added'))
		{
			case 'year';
				$jobs = $jobs->whereYear('created_at', '>=', date("Y", strtotime("-1 year")));
				$jobs = $jobs->whereYear('created_at', '<=', date("Y", strtotime("-1 year")));
				break;
			case 'month':
				$jobs = $jobs->whereDate('created_at', '>=', date("Y-m-d", strtotime("first day of previous month")));
				$jobs = $jobs->whereDate('created_at', '<=', date("Y-m-d", strtotime("last day of previous month")));
				break;
			case 'week':
				$jobs = $jobs->whereDate('created_at', '>=', date("Y-m-d", strtotime("last week")));
				$jobs = $jobs->whereDate('created_at', '<=', date("Y-m-d", strtotime("last week +6days")));
				break;
			case 'day':
				$jobs = $jobs->whereDate('created_at', '>=', date("Y-m-d", strtotime("-7 days")));
				$jobs = $jobs->whereDate('created_at', '<=', date("Y-m-d", strtotime("now")));
				break;
		}
		
		$p = (int)config('sourcemod.market.jobs_pagination');
		switch($request->get('sort'))
		{
			case 'price_low':
				$jobs = $jobs->orderBy('price', 'asc')->paginate($p);
				$links = $jobs;
				break;
			case 'price_high':
				$jobs = $jobs->orderBy('price', 'desc')->paginate($p);
				$links = $jobs;
				break;
			case 'newest_items';
				$jobs = $jobs->orderBy('created_at', 'desc')->paginate($p);
				$links = $jobs;
				break;
			case 'featured':
				$jobs = $jobs->orderBy('view', 'desc')->paginate($p);
				$links = $jobs;
				break;
			case 'recently_updated':
				$jobs = $jobs->orderBy('updated', 'desc')->paginate($p);
				$links = $jobs;
				break;
			default:
				$jobs = $jobs->orderBy('created_at', 'desc')->paginate($p);
				$links = $jobs;
				break;
		}	
		
		return view('laravel-authentication-acl::client.jobs.index')->with(
			[
				'jobs' => $jobs,
				'links' => $links
			]
		);
	}
	
	 /**
     * Route : job.view
     *
     * @param  int  	$id
	 * @param  string  	$game
	 * @param  string  	$title
     * @return view
     */
    public function viewJob($id, $game, $title)
	{
		$job = JobModel::find($id);
		if(
			$id == null
			|| $game == null
			|| $title == null
			|| $job == null
		)
		{
			return abort(404);
		}
		
		if(!$job->activated)
		{
			$authentication = App::make('authenticator');
			
			if($authentication->getLoggedUser()->id != $job->user_id && !$authentication->getLoggedUser()->hasPermission(['_approver']))
			{
				return abort(404);
			}
		}
		
		$job->view++;
		$job->save();
		
		return view('laravel-authentication-acl::client.jobs.view')->with(
			[
				'job' => $job
			]
		);

	}
	
	 /**
     * Route : jobs.view.discussion
     *
     * @param  int  	$id
	 * @param  string  	$game
	 * @param  string  	$category
	 * @param  string  	$title
     * @return view
     */
	public function viewJobDiscussions($id, $game, $title)
	{
		$job = JobModel::find($id);
		if(
			$id == null
			|| $game == null
			|| $title == null
			|| $job == null
		)
		{
			return abort(404);
		}
		
		if(!$job->activated)
		{
			$authentication = App::make('authenticator');
			if($authentication->getLoggedUser()->id != $job->user_id && !$authentication->getLoggedUser()->hasPermission(['_approver']))
			{
				return abort(404);
			}
		}
		
		$job->view++;
		$job->save();
		
		return view('laravel-authentication-acl::client.jobs.discussions')->with(
			[
				'job' => $job
			]
		);
	}

	 /**
     * Route : jobs.discussions.add
     *
     * @param  int  	$id
	 * @param  string  	$game
	 * @param  string  	$title
	 * @param  Request  $request
     * @return view
     */
	public function addJobDiscussions($id, $game, $title, Request $request)
	{
		$job = JobModel::find($id);
		if(
			$id == null
			|| $game == null
			|| $title == null
			|| $job == null
		)
		{
			return abort(404);
		}

		$validator = Validator::make($request->all(), [
			'text' => 'required|min:10|max:65535',
		]);
		
		if($validator->fails()) 
		{
			return Redirect::route('jobs.view.discussions', ['id' => $id, 'game'=> $game, 'title' => $title])
				->withErrors($validator->errors())
				->withInput($request->all());
        }
			
		$authentication = App::make('authenticator'); 
		$discussion = JobDiscussionModel::create(
			[
				'job_id' => $id,
				'user_id' => $authentication->getLoggedUser()->id,
				'text' => $request->get('text')
			]
		);
		
		if($authentication->getLoggedUser()->id != $job->user_id)
		{
			/* notify scripter */
			Event::Fire(new \App\Events\UserNotification(
				'user_discussion' . $job->user_id . '_user_' . $authentication->getLoggedUser()->id . '_date_' . date('Y-m-d_H:i:s'),
				$job->user_id, 
				'fa fa-comments', 
				''.(isset($authentication->getLoggedUser()->user_profile->first()->first_name) ? $authentication->getLoggedUser()->user_profile->first()->first_name : $authentication->getLoggedUser()->steam_id).' comment '.$job->title.'.', 
				URL::route('jobs.view.discussions', ['id' => $job->id, 'game' => App\Http\Classes\Slug::filter($job->game->title), 'title' => App\Http\Classes\Slug::filter($job->title) ])
				)
			);
		}
		
		return Redirect::route('jobs.view.discussions', ['id' => $id, 'game'=> $game, 'title' => $title]);
	}
	
	 /**
     * Route : jobs.discussions.delete
     *
	 * @param  Request  $request
     * @return view
     */
	public function deleteJobDiscussions($id)
	{
		$jobdiscussion = JobDiscussionModel::find($id);
		
		/* 30 minutes before to delete your own comment */
		if(time() - strtotime($jobdiscussion->created_at) >= (int)config('sourcemod.market.delete_delay'))
		{
			return Redirect::back();
		}
		
		//Check owner
		if($jobdiscussion->user_id)
		{
			$authentication = App::make('authenticator');
			if($authentication->getLoggedUser()->id != $jobdiscussion->user_id)
			{
				return Redirect::route('home.index');
			}
		}
		if($jobdiscussion)
		{
			$jobdiscussion->delete();
		}
		return Redirect::back();		
	}	 
	
	 /**
     * Route : jobs.appliers
     *
     * @param  int  	$id
	 * @param  string  	$game
	 * @param  string  	$category
	 * @param  string  	$title
     * @return view
     */
	public function appliers($id, $game, $title)
	{
		$job = JobModel::find($id);
		if(
			$id == null
			|| $game == null
			|| $title == null
			|| $job == null
		)
		{
			return abort(404);
		}
		
		if(!$job->activated)
		{
			$authentication = App::make('authenticator');
			if($authentication->getLoggedUser()->id != $job->user_id && !$authentication->getLoggedUser()->hasPermission(['_approver']))
			{
				return Redirect::route('home.index');
			}
		}
		
		$job->view++;
		$job->save();
		
		return view('laravel-authentication-acl::client.jobs.appliers')->with(
			[
				'job' => $job
			]
		);		
	}
	
	 /**
     * Route : jobs.applier.add
     *
     * @param  int  	$id
	 * @param  string  	$game
	 * @param  string  	$title
	 * @param  Request  $request
     * @return view
     */
	public function addJobApplier($id, $game, $title, Request $request)
	{
		$job = JobModel::find($id);
		if(
			$id == null
			|| $game == null
			|| $title == null
			|| $job == null
			|| $job->appliers()->where('choosen', '=', true)->exists()
		)
		{
			return abort(404);
		}

		$validator = Validator::make($request->all(), [
			'text' => 'required|min:10|max:65535',
			'price' => 'required|min:0',
		]);
		
		if($validator->fails()) 
		{
			return Redirect::route('jobs.view.appliers', ['id' => $id, 'game'=> $game, 'title' => $title])
				->withErrors($validator->errors())
				->withInput($request->all());
        }
			
		$authentication = App::make('authenticator'); 
		$discussion = JobApplierModel::create(
			[
				'job_id' => $id,
				'user_id' => $authentication->getLoggedUser()->id,
				'text' => $request->get('text'),
				'price' => $request->get('price'),
			]
		);
		
		if($authentication->getLoggedUser()->id != $job->user_id)
		{
			/* notify scripter */
			Event::Fire(new \App\Events\UserNotification(
				'user_discussion' . $job->user_id . '_user_' . $authentication->getLoggedUser()->id . '_date_' . date('Y-m-d_H:i:s'),
				$job->user_id, 
				'fa fa-suitcase', 
				''.(isset($authentication->getLoggedUser()->user_profile->first()->first_name) ? $authentication->getLoggedUser()->user_profile->first()->first_name : $authentication->getLoggedUser()->steam_id).' applied for '.$job->title.'.', 
				URL::route('jobs.view.appliers', ['id' => $job->id, 'game' => App\Http\Classes\Slug::filter($job->game->title), 'title' => App\Http\Classes\Slug::filter($job->title) ])
				)
			);
		}
		return Redirect::route('jobs.view.appliers', ['id' => $id, 'game'=> $game, 'title' => $title]);
	}
	
	 /**
     * Route : jobs.applier.delete
     *
	 * @param  Request  $request
     * @return view
     */
	public function deleteJobApplier($id)
	{
		$jobapplier = JobApplierModel::find($id);
		
		/* 30 minutes before to delete your own comment */
		if(time() - strtotime($jobapplier->created_at) >= (int)config('sourcemod.market.delete_delay'))
		{
			return Redirect::back();
		}
		
		//Check owner
		if($jobapplier->user_id)
		{
			$authentication = App::make('authenticator');
			if($authentication->getLoggedUser()->id != $jobapplier->user_id)
			{
				return abort(404);
			}
		}
		if($jobapplier)
		{
			$jobapplier->delete();
		}
		return Redirect::back();		
	}	 
	
	/**
     * Route : jobs.applier.user
     *
	 * @param  Request  $request
     * @return view
     */
	public function JobApplierUser($id)
	{
		$jobapplier = JobApplierModel::find($id);
		
		//Check owner
		if($jobapplier->user_id)
		{
			$authentication = App::make('authenticator');
			if($authentication->getLoggedUser()->id != $jobapplier->job->user_id)
			{
				return abort(404);
			}
		}
		if($jobapplier)
		{
			$jobapplier->choosen = true;
			$jobapplier->save();
		}
		return Redirect::back();		
	}	
	
	/**
     * Route : jobs.applier.user.done
     *
	 * @param  Request  $request
     * @return view
     */
	public function JobDoneApplierUser($id)
	{
		$jobapplier = JobApplierModel::find($id);
		
		//Check owner
		if($jobapplier->user_id)
		{
			$authentication = App::make('authenticator');
			if($authentication->getLoggedUser()->id != $jobapplier->job->user_id)
			{
				return abort(404);
			}
		}
		if($jobapplier)
		{
			$jobapplier->job->finished = true;
			$jobapplier->job->save();
		}
		return Redirect::back();		
	}
}
