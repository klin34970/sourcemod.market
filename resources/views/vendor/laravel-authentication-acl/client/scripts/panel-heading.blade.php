<!-- Start tabs heading -->
<div class="panel-heading no-padding">
	<ul class="nav nav-tabs">
		<li {{ App\Http\Classes\Menu::getActiveRoute(['scripts', '*', '*', '*', '*'], 'class=active', '', true) }}>
			<a href="{!! URL::route('scripts.view', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]) !!}">
				<i class="fa fa-file-text"></i>
				<span>{{ trans('front/scripts/view.tab-item-details') }}</span>
			</a>
		</li>
		<li {{ App\Http\Classes\Menu::getActiveRoute(['scripts', '*', '*', '*', '*', 'versions'], 'class=active') }}>
			<a href="{!! URL::route('scripts.view.versions', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]) !!}">
				<i class="fa fa-code-fork"></i>
				<span>{{ trans('front/scripts/view.tab-versions') }} ({{ count($script->versions) }})</span>
			</a>
		</li>
		<li {{ App\Http\Classes\Menu::getActiveRoute(['scripts', '*', '*', '*', '*', 'discussions'], 'class=active') }}>
			<a href="{!! URL::route('scripts.view.discussions', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]) !!}">
				<i class="fa fa-comments"></i>
				<span>{{ trans('front/scripts/view.tab-discussions') }} ({{ count($script->discussions) }})</span>
			</a>
		</li>
		<li {{ App\Http\Classes\Menu::getActiveRoute(['scripts', '*', '*', '*', '*', 'issues'], 'class=active') }}>
			<a href="{!! URL::route('scripts.view.issues', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]) !!}">
				<i class="fa fa-bug"></i>
				<span>{{ trans('front/scripts/view.tab-issues') }} ({{ count($script->issues) }})</span>
			</a>
		</li>
		@if( 
				(
				$script->price_discount == 0 
				&& $script->price == 0 
				&& $script->reports->count() < (int)config('sourcemod.market.report_scripts_stop_download')
				)
			|| 
			(isset($logged_user) && $script->user_id == $logged_user->id)
			||
			(isset($logged_user) && $logged_user->purchases()->where('script_id', $script->id)->count())
			|| 
			(isset($logged_user) && $logged_user->hasPermission(['_approver']))
		)
		<li>
			<a href="{!! URL::route('scripts.view.downloads', ['script_id' => $script->id, 'version_id' => $script->versions->first()->id]) !!}">
				<i class="fa fa-download"></i>
				<span>{{ trans('front/scripts/view.tab-downloads') }}</span>
			</a>
		</li>
		@else
			@if(
				$script->user_profile->first()->paypal_email 
				&& 
				$script->reports->count() < (int)config('sourcemod.market.report_scripts_stop_download')
			)
				@if(isset($logged_user) && !$logged_user->purchases()->where('script_id', $script->id)->count())
				<li style="background: #e9573f;">
					<a style="color: #fff;" href="{{ URL::route('purchase.scripts', ['id' => $script->id] ) }}">
						<i style="color: #fff;" class="fa fa-shopping-cart"></i>
						<span>{{ trans('front/scripts/view.tab-buy') }} {{ $script->price_discount > 0 ? number_format($script->price_discount + ($script->price_discount * $tax / 100), 2) : number_format($script->price + ($script->price * $tax / 100), 2) }}$</span>
					</a>
				</li>
				@else
				<li style="background: #e9573f;">
					<a style="color: #fff;" href="{{ URL::route('purchase.scripts', ['id' => $script->id] ) }}">
						<i style="color: #fff;" class="fa fa-shopping-cart"></i>
						<span>{{ trans('front/scripts/view.tab-buy') }} {{ $script->price_discount > 0 ? number_format($script->price_discount + ($script->price_discount * $tax / 100), 2) : number_format($script->price + ($script->price * $tax / 100), 2) }}$</span>
					</a>
				</li>
				@endif
			@endif
		@endif
		
		@if(isset($logged_user))
			
			@if($logged_user->hasPermission(['_approver']))
			<li {{ App\Http\Classes\Menu::getActiveRoute(['scripts', '*', '*', '*', '*', 'reports'], 'class=active') }}>
				<a href="{!! URL::route('scripts.view.reports', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]) !!}">
					<i class="fa fa-meh-o"></i>
					<span>{{ trans('front/scripts/view.tab-reports') }} ({{ count($script->reports) }})</span>
				</a>
			</li>
			@else
			<li {{ App\Http\Classes\Menu::getActiveRoute(['scripts', '*', '*', '*', '*', 'reports'], 'class=active') }}>
				<a href="{!! URL::route('report.scripts', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]) !!}">
					<i class="fa fa-meh-o"></i>
					<span>{{ trans('front/scripts/view.tab-reports') }}</span>
				</a>
			</li>
			@endif
			
			@if( 
					($script->price_discount == 0 && $script->price == 0)
					||
					($logged_user->purchases()->where('script_id', $script->id)->count())
					||
					($logged_user->id == $script->user_id)
				)
			<li>
				<div class="rating allowed rating-2x rating-primary text-center" style="margin: 20px 20px;">
					<span style="vertical-align: top;font-size:10px;">({{ strrev(count($script->stars)) }})</span>
					<span class="star {{ round($script->stars->avg('stars')) == 5 ? 'active' : '' }}" star="5"></span>
					<span class="star {{ round($script->stars->avg('stars')) == 4 ? 'active' : '' }}" star="4"></span>
					<span class="star {{ round($script->stars->avg('stars')) == 3 ? 'active' : '' }}" star="3"></span>
					<span class="star {{ round($script->stars->avg('stars')) == 2 ? 'active' : '' }}" star="2"></span>
					<span class="star {{ round($script->stars->avg('stars')) == 1 ? 'active' : '' }}" star="1"></span>
				</div>
			</li>
			@endif
		
		@endif
	</ul>
</div><!-- /.panel-heading -->
<!--/ End tabs heading -->