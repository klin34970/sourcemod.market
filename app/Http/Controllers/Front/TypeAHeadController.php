<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\ScriptModel as ScriptModel;
use \LaravelAcl\Authentication\Models\User as User;
use File, Storage, App, URL;

class TypeAHeadController extends Controller
{
	
	 /**
     * Route : typeahead.typeahead
     *
     * @return typeahead.json
     */
    public function typeahead()
	{
		$file = 'assets/typeahead/typeahead.json';
		
		$scripts = ScriptModel::where('activated', '=', true)->orderBy('id', 'desc')->get();
		
		$typeahead = array();
		$typeahead2 = array();
		foreach($scripts as $script)
		{
			$typeahead['value'] = $script->title;
			$typeahead['name'] = $script->game->title . ' - '. $script->title;
			$typeahead['description'] = (isset($script->user->user_profile()->first()->first_name) ? $script->user->user_profile()->first()->first_name : '');
			$typeahead['icon'] = 'code-fork';
			$typeahead['color'] = 'success';
			$tokens = preg_replace('/[^a-zA-Z0-9\s]/', '', $script->title);
			$tokens = explode(' ', $tokens);
			$typeahead['tokens'] = array_values(array_filter($tokens));
			$typeahead['tokens'][] = (isset($script->user->user_profile()->first()->first_name) ? $script->user->user_profile()->first()->first_name : '');
			$typeahead['url'] = URL::route('scripts.view', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title)]);
			
			$typeahead2[] = $typeahead;
		}
		
		$users = User::orderBy('id', 'desc')->get();

		foreach($users as $user)
		{
			
			$typeahead['value'] = (isset($user->user_profile()->first()->first_name) ? $user->user_profile()->first()->first_name : $user->steam_id);
			$typeahead['name'] = (isset($user->user_profile()->first()->first_name) ? $user->user_profile()->first()->first_name : $user->steam_id);
			$typeahead['description'] = htmlentities(strip_tags($user->user_profile()->first()->bio));
			$typeahead['icon'] = 'users';
			$typeahead['color'] = 'success';
			$tokens = preg_replace('/[^a-zA-Z0-9\s]/', '', (isset($user->user_profile()->first()->first_name) ? $user->user_profile()->first()->first_name : $user->steam_id));
			$tokens = explode(' ', $tokens);
			$typeahead['tokens'] = array_values(array_filter($tokens));
			$typeahead['tokens'][] = (isset($user->user_profile()->first()->first_name) ? $user->user_profile()->first()->first_name : '');
			$typeahead['url'] = URL::route('users.view', ['id' => $user->id]);
			
			$typeahead2[] = $typeahead;
		}
		
		//dd($typeahead2);
		Storage::disk('public')->put($file, json_encode($typeahead2));
	}    
}
