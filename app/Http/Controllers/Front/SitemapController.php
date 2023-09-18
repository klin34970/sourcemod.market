<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\ScriptModel as ScriptModel;
use App\Http\Models\Front\ForumThreadModel as ForumThreadModel;
use App, URL;

class SitemapController extends Controller
{
	 /**
     * Route : sitemap.scripts
     *
     * @return sitemap-scripts.xml
     */
	public function scripts()
	{
		$sitemap = App::make("sitemap");
		$sitemap->add(URL::to('/'), date('Y-m-d H:i:s'), '1.0', 'daily');
		
		$scripts = ScriptModel::orderBy('created_at', 'desc')->where('activated', true)->get();
		foreach($scripts as $script)
		{
			
			$images[0]['url'] = URL::to('/') . '/assets/images/scripts/'.$script->id.'/750x212.jpg';
			$images[0]['title'] = $script->title;
			$images[0]['caption'] =  $script->title;
            
			
			$sitemap->add(
				URL::route('scripts.view', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title)]), 
				$script->updated_at, 
				'1.0', 
				'daily',
				$images
			);
			
			$sitemap->add(
				URL::route('scripts.view.versions', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title)]), 
				$script->updated_at, 
				'1.0', 
				'daily',
				$images
			);
			
			$sitemap->add(
				URL::route('scripts.view.discussions', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title)]), 
				$script->updated_at, 
				'1.0', 
				'daily',
				$images
			);
			
			$sitemap->add(
				URL::route('scripts.view.issues', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title)]), 
				$script->updated_at, 
				'1.0', 
				'daily',
				$images
			);
		}
		
		$sitemap->store('xml', 'sitemap-scripts');
	}		 
	
	/**
     * Route : sitemap.scripts
     *
     * @return sitemap-threads.xml
     */
	public function threads()
	{
		$sitemap = App::make("sitemap");
		$sitemap->add(URL::to('/'), date('Y-m-d H:i:s'), '1.0', 'daily');
		
		$threads = ForumThreadModel::orderBy('created_at', 'desc')->get();
		foreach($threads as $thread)
		{
			$sitemap->add(
				URL::route('community.forum.threads', ['id' => $thread->id, 'title' => App\Http\Classes\Slug::filter($thread->title)]), 
				$thread->updated_at, 
				'1.0', 
				'daily'
			);
		}
		
		$sitemap->store('xml', 'sitemap-threads');
	}	
}
