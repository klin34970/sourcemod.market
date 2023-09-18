<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\FaqModel as FaqModel;
use App\Http\Models\Front\FaqCategoryModel as FaqCategoryModel;

class HelpController extends Controller
{
    public function contact()
	{
		return view('laravel-authentication-acl::client.help.contact');
	}
	
	public function faq()
	{
		$faq = FaqModel::all();
		$faq_categories = FaqCategoryModel::all();
		return view('laravel-authentication-acl::client.help.faq')->with(
			[
				'faq' => $faq,
				'faq_categories' => $faq_categories
				
			]
		);
	}
}
