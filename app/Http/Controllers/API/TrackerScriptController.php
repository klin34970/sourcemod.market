<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\ScriptTrackerModel as ScriptTrackerModel;
use App\Http\Models\Front\GameModel as GameModel;
use Response, Crypt, Curl;

class TrackerScriptController extends Controller
{
	protected $headers;
	
	protected $options;
	
	public function __construct()
	{
		$this->headers = [
			'Content-Type' => 'application/json; charset=UTF-8',
			'charset' => 'utf-8'
		];
		
		$this->options = JSON_PRETTY_PRINT;
		
	}
	
    public function sourcemod(Request $request)
	{
		$ip_sender = $request->ip();
		$sourceguard_ip = $request->get('ip');
		$sourceguard_port = $request->get('port');
		$sourceguard_game = $request->get('game');
		$sourceguard_script_id = $request->get('script_id');
		$sourceguard_version_id = $request->get('version_id');
		$sourceguard_download = $request->get('download');
		
		/* remove for prod */
		// $sourceguard_download = "eyJpdiI6Ikl1QU9ISEZqclVKMGtYZzdmWVVjZ1E9PSIsInZhbHVlIjoiRmk1VzVOdDJBWVVkelRrUEdiVDZKZz09IiwibWFjIjoiYTZjMDM3ZDdkN2Q3Njk1NGQ1Yzg1MTdjYjZhZGVhMzZkMzQwMzVjNzA1NzZkZTg0MzhiNmMwYzc1MGI0ZjJjMSJ9";
		
		
		// error_log(
			// json_encode(
				// [
					// 'decrypt' => Crypt::decrypt($sourceguard_download), 
					// 'ip_sender' => $request->ip(),
					// 'sourceguard_ip' => $request->get('ip'),
					// 'sourceguard_port' => $request->get('port'),
					// 'sourceguard_game' => $request->get('game'),
					// 'sourceguard_script_id' => $request->get('script_id'),
					// 'sourceguard_version_id' => $request->get('version_id'),
					// 'sourceguard_download' => $request->get('download'),
				// ]
			// )
		// );
		
		if(
			$sourceguard_port > 0 
			&& $sourceguard_port < 65536 
			&& $sourceguard_port != 80 
			&& $sourceguard_port != 443
			&& $sourceguard_script_id > 0
			&& $sourceguard_version_id > 0
			&& strlen(Crypt::decrypt($sourceguard_download)) > 0
		)
		{
			// $try = 0;
			// while($try <= 5)
			// {	
				// $url = 'https://sourcemod.market:8891/'.$sourceguard_game.'/'.$sourceguard_ip.'/'.$sourceguard_port.'';
				// $response = Curl::to($url)->get();
				// $server = json_decode($response);
				//dd($server);
				// if(isset($server->name))
				// {
					// break;
				// }
				//error_log(json_encode($try .':' .$sourceguard_script_id . ':' .date('I:s')));
				// $try++;
			// }
			
			$url = 'https://sourcemod.devsapps.com:10002/'.$sourceguard_game.'/'.$sourceguard_ip.'/'.$sourceguard_port.'';
			$response = Curl::to($url)->withOption('SSL_VERIFYPEER', false)->enableDebug('/var/www/vhosts/sourcemod.devsapps.com/logs/curl.log')->get();
			$server = json_decode($response);
			
			//error_log(print_r($server, true));
			
			if(isset($server->name))
			{
				$game = GameModel::select('id')->where('game_server_query_type', '=', $sourceguard_game)->first();
				ScriptTrackerModel::updateOrCreate(
					[
						'ip' => $sourceguard_ip,
						'port' => $sourceguard_port,
						'script_id' => $sourceguard_script_id,
					],
					[
						'game_id' => $game->id,
						'script_id' => $sourceguard_script_id,
						'script_version_id' => $sourceguard_version_id,
						'purchaser_id' => Crypt::decrypt($sourceguard_download),
						'hostname' => $server->name,
						'ip' => $sourceguard_ip,
						'port' => $sourceguard_port,
						'last_activity' => date('Y-m-d H:i:s')
					]
				);
			}
			
		}
	}    
	
	
	public function garrysmod(Request $request)
	{
		$ip_sender = $request->ip();
		$infos = explode(':', $request->get('ip'));
		$sourceguard_ip = $infos[0];
		$sourceguard_port = $infos[1];
		$sourceguard_game = $request->get('game');
		$sourceguard_script_id = $request->get('script_id');
		$sourceguard_version_id = $request->get('version_id');
		$sourceguard_download = $request->get('download');
		
		/* remove for prod */
		// $sourceguard_download = "eyJpdiI6Ikl1QU9ISEZqclVKMGtYZzdmWVVjZ1E9PSIsInZhbHVlIjoiRmk1VzVOdDJBWVVkelRrUEdiVDZKZz09IiwibWFjIjoiYTZjMDM3ZDdkN2Q3Njk1NGQ1Yzg1MTdjYjZhZGVhMzZkMzQwMzVjNzA1NzZkZTg0MzhiNmMwYzc1MGI0ZjJjMSJ9";
		//error_log(json_encode(Crypt::decrypt($sourceguard_download) > 0));
		
		//error_log(json_encode($ip_sender));
		
		if(
			$sourceguard_port > 0 
			&& $sourceguard_port < 65536 
			&& $sourceguard_port != 80 
			&& $sourceguard_port != 443
			&& $sourceguard_script_id > 0
			&& $sourceguard_version_id > 0
			&& strlen(Crypt::decrypt($sourceguard_download)) > 0
		)
		{
			$try = 0;
			while($try <= 60)
			{	
				
				$url = 'https://sourcemod.devsapps.com:10002/'.$sourceguard_game.'/'.$ip_sender.'/'.$sourceguard_port.'';
				$response = Curl::to($url)->get();
				$server = json_decode($response);
				if(isset($server->name))
				{
					break;
				}
				$try++;
			}
			
			
			if(isset($server->name))
			{
				$game = GameModel::select('id')->where('game_server_query_type', '=', $sourceguard_game)->first();
				ScriptTrackerModel::updateOrCreate(
					[
						'ip' => $ip_sender,
						'port' => $sourceguard_port,
						'script_id' => $sourceguard_script_id,
					],
					[
						'game_id' => $game->id,
						'script_id' => $sourceguard_script_id,
						'script_version_id' => $sourceguard_version_id,
						'purchaser_id' => Crypt::decrypt($sourceguard_download),
						'hostname' => $server->name,
						'ip' => $ip_sender,
						'port' => $sourceguard_port,
						'last_activity' => date('Y-m-d H:i:s')
					]
				);
			}
			
		}
	}
}
