@if(!$scripts->isEmpty())
<div>
	<div class="clearfix" style="margin-top:20px;">
	</div>
	<div id="grid-container" class="cbp">
		@foreach($scripts as $script)
		<div class="cbp-item" itemscope itemtype="http://schema.org/SomeProducts" itemid="#{{$script->id}}">
			<a href="{!! URL::route('scripts.view', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]) !!}" class="cbp-caption">
				<div class="cbp-caption-defaultWrap">
					<img itemprop="image" src="/assets/images/scripts/{{ $script->id }}/340x96.jpg" alt="{{ $script->name }}">
				</div>
				<div class="cbp-caption-activeWrap">
					<div class="cbp-l-caption-alignCenter">
						<div class="cbp-l-caption-body">
							<div class="cbp-l-caption-text">VIEW SCRIPT</div>
						</div>
					</div>
				</div>
			</a>
			@if($script->type & 4)
				<div class="ribbon-wrapper top-left">
					<div style="opacity: 0.9;" class="ribbon ribbon-warning ribbon-shadow">PACK</div>
				</div>
			@endif
			<div class="content">
				<a itemprop="url" href="{!! URL::route('scripts.view', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]) !!}" class="cbp-l-grid-blog-title"><span itemprop="name">{{ $script->title }}</span></a>
				@if($script->dlc_id > 0)
				<div class="ribbon-wrapper">
					<div style="opacity: 0.9;" class="ribbon ribbon-danger ribbon-shadow">DLC</div>
				</div>	
				@endif
				<div class="cbp-l-grid-blog-user"><i class="fa fa-user"></i> <a href="{{ URL::route('users.view', ['id' => $script->user_id]) }}">{{ isset($script->user_profile->first()->first_name) ? $script->user_profile->first()->first_name : ''}}</a></div>
				<div class="cbp-l-grid-blog-game"><i class="fa fa-gamepad"></i> <a href="{{ URL::route('games.scripts.list', ['id' => $script->game->id, 'title' => App\Http\Classes\Slug::filter($script->game->title)]) }}">{{ $script->game->title }} </a></div>
				<div class="cbp-l-grid-blog-category"><i class="fa fa-folder"></i> {{ $script->category->title }}</div>
				<div class="cbp-l-grid-blog-category"><i class="fa fa-code-fork"></i> {{ $script->versions->first()->name }} | {{ $script->versions->first()->created_at->diffForHumans() }}</div>
			</div>
			<div>
				<div>
						<span style="vertical-align: top;font-size:10px;"> ({{ count($script->versions) }})</span>
						<a href="{!! URL::route('scripts.view.versions', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]) !!}"><i class="fa fa-code-fork"></i></a>
						<span>|</span>
						
						<span style="vertical-align: top;font-size:10px;"> ({{ App\Http\Classes\Number::changeFormat($script->view) }})</span>
						<a href="{!! URL::route('scripts.view', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]) !!}"><i class="fa fa-eye"></i></a>
						<span>|</span>
						
						<span style="vertical-align: top;font-size:10px;"> ({{ count($script->discussions) }})</span>
						<a href="{!! URL::route('scripts.view.discussions', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]) !!}"><i class="fa fa-comment"></i></a>
				</div>
				<div class="rating rating-theme">	
					<span style="vertical-align: top;font-size:10px;">({{ strrev(count($script->stars)) }})</span>
					<span class="star {{ ceil($script->stars->avg('stars')) == 5 ? 'active' : '' }}"></span>
					<span class="star {{ ceil($script->stars->avg('stars')) == 4 ? 'active' : '' }}"></span>
					<span class="star {{ ceil($script->stars->avg('stars')) == 3 ? 'active' : '' }}"></span>
					<span class="star {{ ceil($script->stars->avg('stars')) == 2 ? 'active' : '' }}"></span>
					<span class="star {{ ceil($script->stars->avg('stars')) == 1 ? 'active' : '' }}"></span>
				</div>
				<div class="pull-right">
				
					@if($script->price_discount > 0)
						<span class="badge badge-success">
							<i class="fa fa-dollar"></i>
							{{ number_format($script->price_discount + ($script->price_discount * $tax / 100), 2) }}
						</span>
					@endif
					
					@if($script->price == 0)
						<span class="badge badge-success">Free</span>
					@else
						@if($script->price_discount > 0)
						<span class="badge badge-danger">
						<i class="fa fa-dollar"></i>
							<s>{{ number_format($script->price + ($script->price * $tax / 100), 2) }}</s>
						</span>
						@else
						<span class="badge badge-success">
						<i class="fa fa-dollar"></i>
							{{ number_format($script->price + ($script->price * $tax / 100), 2) }}
						</span>
						@endif
						
						@if($tax > 0)
						<span class="badge badge-warning">
							VAT: {{$tax}}%
						</span>
						@endif
						
					@endif
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		@endforeach
	</div>

</div>
@endif