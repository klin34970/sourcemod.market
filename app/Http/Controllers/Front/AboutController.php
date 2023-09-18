<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function terms()
	{
		return view('laravel-authentication-acl::client.about.terms');
	}
	public function policy()
	{
		return view('laravel-authentication-acl::client.about.policy');
	}
}
