<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\GameModel as GameModel;

class GameController extends Controller
{
	/**
     * Route : games.list
     *
     * @return view
     */
	public function index()
	{		
		$games = GameModel::with('scripts')->get()->sortByDesc(function($game)
		{
			return $game->scripts->count();
		});
		
		return view('laravel-authentication-acl::client.games.index')->with(
			[
				'games' => $games,
			]
		);
	}
}
