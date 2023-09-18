<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Classes\Steam\LightOpenID;
use Redirect, DB, App, Event, URL;

class SteamController extends Controller
{
	/**
     * Get user informations throught Steam
     *
     * @param  Request  $request
     * @return redirect
     */
	public function getSteamLogin(Request $request)
	{
		$openid = new LightOpenID($request->getHost());
	
		if(!$openid->mode)
		{
			$openid->identity = 'http://steamcommunity.com/openid';
			return Redirect::to($openid->authUrl());
		}
		elseif ($openid->mode == 'cancel')
		{
			return Redirect::to('/');
		}
		else
		{
			if($openid->validate())
			{
				$id = $openid->identity;
				$ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
				preg_match($ptn, $id, $matches);
				
				//$request->session()->put('steamid', $matches[1]);
				
				$url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".config('steam.apikey')."&steamids=".$matches[1];
				
				$ch = curl_init();
				curl_setopt ($ch, CURLOPT_URL, $url);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				$content = curl_exec($ch);
				curl_close($ch);
				
				//dd(json_decode($content));
				$content = json_decode($content, true);
				//echo '<pre>' . print_r($content, true) . '</pre>';

				if($steam_id = $content['response']['players'][0]['steamid'])
				{
					$exists = DB::table('users')->where('steam_id', '=', $steam_id)->exists();
					if($exists)
					{
						$user = DB::table('users')->where('steam_id', '=', $steam_id)->first();
						
						$ch = curl_init();
						curl_setopt ($ch, CURLOPT_URL, $content['response']['players'][0]['avatarfull']);
						curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
						curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
						$avatar = curl_exec($ch);
						curl_close($ch);
				
						if(DB::table('user_profile')->where('user_id', $user->id)->exists())
						{
							DB::table('user_profile')->where('user_id', $user->id)->update(
								[
									'first_name' => strip_tags($content['response']['players'][0]['personaname']),
									'last_name' => isset($content['response']['players'][0]['realname']) ? strip_tags($content['response']['players'][0]['realname']) : '',
									'avatar' => $avatar,
									'country' => isset($content['response']['players'][0]['loccountrycode']) ? $content['response']['players'][0]['loccountrycode'] : '',
									'updated_at' => date('Y-m-d H:i:s')
								]
							);
						}
						else
						{
							$user = DB::table('users')->where('steam_id', '=', $steam_id)->first();
							
							DB::table('user_profile')->insert(
							[
								'user_id' => $user->id,
								'rank_sale_id' => 1,
								'first_name' => strip_tags($content['response']['players'][0]['personaname']),
								'last_name' => isset($content['response']['players'][0]['realname']) ? strip_tags($content['response']['players'][0]['realname']) : '',
								'avatar' => $avatar,
								'country' => isset($content['response']['players'][0]['loccountrycode']) ? $content['response']['players'][0]['loccountrycode'] : '',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
							]
						);
						}
						
						$authentication = App::make('authenticator');
						$authentication->loginById($user->id, true);
						
						Event::Fire(new App\Events\UserLoggedIn($user->id));
						
						
						$user_profile = DB::table('user_profile')->select('bio', 'paypal_email')->where('user_id', $user->id)->first();
						
						if($user_profile->bio == '')
						{
							Event::Fire(new App\Events\UserNotification('profile_bio', $user->id, 'fa fa-user', 'Your biography is empty', URL::route('dashboard.users.self')));
						}
						if($user_profile->paypal_email == '')
						{
							Event::Fire(new App\Events\UserNotification('profile_paypal', $user->id, 'fa fa-user', 'You need to set a Paypal email to sell your scripts', URL::route('dashboard.users.self')));
						}
						
					}
					else
					{
						$user_id = DB::table('users')->insertGetId(
							[
								'steam_id' => $steam_id,
								'email' => $steam_id.'@sourcemod.devsapps.com',
								'activated' => 1,
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
							]
						);
						
						$ch = curl_init();
						curl_setopt ($ch, CURLOPT_URL, $content['response']['players'][0]['avatarfull']);
						curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
						curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
						$avatar = curl_exec($ch);
						curl_close($ch);
				
						DB::table('user_profile')->insert(
							[
								'user_id' => $user_id,
								'rank_sale_id' => 1,
								'first_name' => strip_tags($content['response']['players'][0]['personaname']),
								'last_name' => isset($content['response']['players'][0]['realname']) ? strip_tags($content['response']['players'][0]['realname']) : '',
								'avatar' => $avatar,
								'country' => isset($content['response']['players'][0]['loccountrycode']) ? $content['response']['players'][0]['loccountrycode'] : '',
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
							]
						);
						
						$authentication = App::make('authenticator');
						$authentication->loginById($user_id, true);
						
						Event::Fire(new App\Events\UserLoggedIn($user_id));
						Event::Fire(new App\Events\UserNotification('profile_bio', $user_id, 'fa fa-user', 'Your biography is empty', URL::route('dashboard.users.self')));
						Event::Fire(new App\Events\UserNotification('profile_paypal', $user_id, 'fa fa-user', 'You need to set a Paypal email to sell your scripts', URL::route('dashboard.users.self')));
						
					}
					
					return Redirect::to('/');
				}
			}
			else
			{
				return Redirect::to('/');
			}
		}
	}
}
