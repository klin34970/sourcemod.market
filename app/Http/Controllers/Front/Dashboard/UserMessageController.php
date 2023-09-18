<?php

namespace App\Http\Controllers\Front\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\UserMessageModel as UserMessageModel;
use App\Http\Models\Front\UserMessageReplyModel as UserMessageReplyModel;
use App, Redirect, Validator, Event, URL;

class UserMessageController extends Controller
{
	 /**
     * Route : messages.list
     *
     * @return view
     */
    public function getList(Request $request)
	{
		$authentication = App::make('authenticator');
		
		$messages = UserMessageModel::select('*');
		
		if($request->get('search'))
		{
			$search = $request->get('search');
			$messages = $messages->where(function ($query) use ($search) 
			{
				return $query->where('title', 'like', '%'.$search.'%')->orWhere('text', 'like', '%'.$search.'%');
			});
		}
		
		if($request->has('status'))
		{
			$messages = $messages->where('read', '=', $request->get('status'));
		}
		
		$messages = $messages->where('user_id', '=', $authentication->getLoggedUser()->id)
			->orWhere('target_id', '=', $authentication->getLoggedUser()->id)
			->orderBy('id', 'desc')
			->paginate((int)config('sourcemod.market.users_messages_pagination'));
		
		return view('laravel-authentication-acl::client.dashboard.messages.list')->with(
			[
				'messages' => $messages
			]
		);		
	}	 
	
	/**
     * Route : messages.read
     *
     * @param  Request  $request
     * @return view
     */
    public function read($id, Request $request)
	{
		$authentication = App::make('authenticator');
		$message = UserMessageModel::where('id', '=', $id)->first();
		
		if(
			isset($message->user_id)
			&&
			($message->user_id == $authentication->getLoggedUser()->id 
			|| $message->target_id == $authentication->getLoggedUser()->id)
		)
		{
			if(isset($message->user_messages_replies()->orderBy('id', 'desc')->first()->user_id) && $message->user_messages_replies()->orderBy('id', 'desc')->first()->user_id != $authentication->getLoggedUser()->id)
			{
				$message->read = true;
				$message->save();
			}
			
			return view('laravel-authentication-acl::client.dashboard.messages.read')->with(
				[
					'message' => $message
				]
			);
		}
		else
		{
			return Redirect::route('home.index');
		}
		
	}	
	
	/**
     * Route : messages.read
     *
     * @param  Request  $request
     * @return view
     */
    public function reply($id, Request $request)
	{
		$authentication = App::make('authenticator');
		$message = UserMessageModel::where('id', '=', $id)->first();
		if(
			isset($message->user_id)
			&&
			!$message->closed
			&&
				($message->user_id == $authentication->getLoggedUser()->id 
				|| 
				$message->target_id == $authentication->getLoggedUser()->id)
		)
		{
			$validator = Validator::make($request->all(), [
				'text' => 'required|min:10|max:65535',
			]);
			
			if($validator->fails()) 
			{
				return Redirect::back()
					->withErrors($validator->errors())
					->withInput($request->all());
			}
			
			UserMessageReplyModel::Create(
				[
					'user_id' => $authentication->getLoggedUser()->id,
					'user_message_id' => $id,
					'text' => $request->get('text')
				]
			);
			
			
			UserMessageModel::where('id', '=', $id)->update(
				[
					'read' => 0,
					'updated_at' => date('Y-m-d H:i:s')
				]
			);
			
			
			if($authentication->getLoggedUser()->id == $message->user_id)
			{
				/* notify target */
				Event::Fire(new App\Events\UserNotification(
					'contact_user_'.$message->target_id.'_sender_user_'.$authentication->getLoggedUser()->id.'_date_'.date('Y-m-d_H:i:s'), 
					$message->target_id, 
					'fa fa-envelope', 
					$authentication->getLoggedUser()->user_profile->first()->first_name.' sent you a private message.', 
					URL::route('dashboard.messages.read', ['id' => $message->id, 'page' => $request->get('page')])
				));
			}
			else
			{
				/* notify target */
				Event::Fire(new App\Events\UserNotification(
					'contact_user_'.$message->user_id.'_sender_user_'.$authentication->getLoggedUser()->id.'_date_'.date('Y-m-d_H:i:s'), 
					$message->user_id, 
					'fa fa-envelope', 
					$authentication->getLoggedUser()->user_profile->first()->first_name.' sent you a private message.', 
					URL::route('dashboard.messages.read', ['id' => $message->id, 'page' => $request->get('page')])
				));	
			}
			return Redirect::route('dashboard.messages.read', ['id' => $id, 'page' => $request->get('page')]);
		}
		else
		{
			return Redirect::route('home.index');
		}
		
	}
}
