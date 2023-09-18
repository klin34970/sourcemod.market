<?php

namespace App\Http\Controllers\Front\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\JobModel as JobModel;
use App, Validator, Redirect;

class JobController extends Controller
{
	
	 /**
     * Route : dashboard.jobs
     * @return view
     */	
    public function getJobsList()
	{
		$authentication = App::make('authenticator'); 
		$jobs = JobModel::where('user_id', '=', $authentication->getLoggedUser()->id)->orderBy('id', 'desc')->get();
		return view('laravel-authentication-acl::client.dashboard.jobs.list')->with(
			[
				'jobs' => $jobs,
			]
		);		
	}
	
	 /**
     * Route : dashboard.jobs.new
	 *
	 * @param  Request  $request
     * @return view
     */	
	public function newJob(Request $request)
	{
		$authentication = App::make('authenticator');
		//Banned
		if($authentication->getLoggedUser()->isBanned())
		{
			return abort(404);
		}
			
		
		$games = JobModel::_getGamesList();
		return view('laravel-authentication-acl::client.dashboard.jobs.new')->with(
			[
				'games' => $games,
			]
		);
	}
	
	 /**
     * Route : dashboard.jobs.new
	 *
	 * @param  Request  $request
     * @return view
     */	
	public function postNewJob(Request $request)
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
			
		]);

		
		if($validator->fails()) 
		{
            return Redirect::route('dashboard.jobs.new')
                        ->withErrors($validator->errors())
                        ->withInput($request->all());
        }
		
		/* Update or Create */ 
		$job = JobModel::Create(
			[
				'user_id' => $authentication->getLoggedUser()->id,
				'title' => strip_tags($request->get('title')), 
				'description' => $request->get('description'), 
				'game_id' => $request->get('game_id'),			
				'price' => $request->get('price'),
				'tags' => strip_tags($request->get('tags')),
				'activated' => true
			]
		);
		
		/* Finally redirect */
		return Redirect::route('dashboard.jobs.edit', ['id' => $job->id]);

	}	
	
	 /**
     * Route : dashboard.jobs.edit
	 *
	 * @param  Request  $request
     * @return view
     */	
	public function editJob($job_id, Request $request)
	{
		$authentication = App::make('authenticator');
		$job = JobModel::find($job_id);
		
		//Banned
		if($authentication->getLoggedUser()->isBanned())
		{
			return abort(404);
		}
			
		//Check owner
		if($job->user_id)
		{
			if($authentication->getLoggedUser()->id != $job->user_id)
			{
				return abort(404);
			}
		}
		
		$games = JobModel::_getGamesList();
		return view('laravel-authentication-acl::client.dashboard.jobs.edit')->with(
			[
				'job' => $job,
				'games' => $games,
			]
		);
	}
	
	 /**
     * Route : dashboard.jobs.edit
	 *
	 * @param  Request  $request
     * @return view
     */	
	public function postEditJob($job_id, Request $request)
	{
		$authentication = App::make('authenticator');
		
		//banned
		if($authentication->getLoggedUser()->isBanned())
		{
			return abort(404);
		}	
		
		//Check owner
		$job = JobModel::find($job_id);
		if(isset($job->user_id))
		{
			if($authentication->getLoggedUser()->id != $job->user_id)
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
		]);
		
		if($validator->fails()) 
		{
            return Redirect::route('dashboard.jobs.edit', ['job_id' => $job_id])
                        ->withErrors($validator->errors())
                        ->withInput($request->all());
        }
		
		/* Update or Create */ 
		JobModel::where('id', '=', $job_id)->update(
			[
				'user_id' => $authentication->getLoggedUser()->id,
				'title' => strip_tags($request->get('title')), 
				'description' => $request->get('description'), 
				'game_id' => $request->get('game_id'),			
				'price' => $request->get('price'),
				'tags' => strip_tags($request->get('tags')),
			]
		);
		
		/* Finally redirect */
		return Redirect::route('dashboard.jobs.edit', ['job_id' => $job->id]);

	}	
}
