<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Models\Front\UserAPIModel as UserAPIModel;

class APIaccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$header = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
        );
			
		if($request->key == '')
		{
			return response()->json(['code' => '400', 'message' => 'Required parameter: key'], 400, $header, JSON_PRETTY_PRINT);
		}
		
		$access = UserAPIModel::where('key', '=', $request->key)->first();

		if($access)
		{
			$permissions = $request->route()->getAction()['permissions'];
			
			if(in_array($permissions, json_decode($access->permissions)))
			{
				$request->merge(['api_user_id' => $access->user_id]);
				return $next($request);
			}
			else
			{
				return response()->json(['code' => '401', 'message' => 'Your api key is not allowed'], 401, $header, JSON_PRETTY_PRINT);
			}
			
		}
		else
		{
			return response()->json(['code' => '400', 'message' => 'Your api key is incorrect'], 400, $header, JSON_PRETTY_PRINT);
		}
		
		return response()->json(['code' => '400', 'message' => 'Something went wrong'], 400, $header, JSON_PRETTY_PRINT);
        
    }
}
