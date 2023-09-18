@if(!$jobs->isEmpty())
<div>
	<div class="clearfix" style="margin-top:20px;">
	</div>
	<div id="grid-container" class="cbp">
		@foreach($jobs as $job)
		<div class="cbp-item" itemscope itemtype="http://schema.org/SomeProducts" itemid="#{{$job->id}}">
			<div class="content">
				<a itemprop="url" href="{!! URL::route('jobs.view', ['id' => $job->id, 'game' => App\Http\Classes\Slug::filter($job->game->title), 'title' => App\Http\Classes\Slug::filter($job->title) ]) !!}" class="cbp-l-grid-blog-title"><span itemprop="name">{{ $job->title }}</span></a>
				<div class="cbp-l-grid-blog-user"><i class="margin-right-5 fa fa-user"></i> <a href="{{ URL::route('users.view', ['id' => $job->user_id]) }}">{{ $job->user_profile->first()->first_name}}</a></div>
				<div class="cbp-l-grid-blog-game"><i class="margin-right-5 fa fa-gamepad"></i> {{ $job->game->title }} </div>
			</div>
			<div>
				<div>
					<span style="vertical-align: top;font-size:10px;"> ({{ $job->view }})</span>
					<a href="{!! URL::route('jobs.view', ['id' => $job->id, 'game' => App\Http\Classes\Slug::filter($job->game->title), 'title' => App\Http\Classes\Slug::filter($job->title) ]) !!}"><i class="margin-left-5 fa fa-eye"></i></a>
					<span>|</span>
					
					<span style="vertical-align: top;font-size:10px;"> ({{ count($job->discussions) }})</span>
						<a href="{!! URL::route('jobs.view.discussions', ['id' => $job->id, 'game' => App\Http\Classes\Slug::filter($job->game->title), 'title' => App\Http\Classes\Slug::filter($job->title) ]) !!}"><i class="margin-left-5 fa fa-comment"></i></a>
				</div>
				<div class="pull-right">
					@if($job->price == 0)
						<span class="badge badge-success">Free</span>
					@else
						<span class="badge badge-success">
						<i class="margin-right-5 fa fa-dollar"></i>
							{{ number_format($job->price, 2) }}
						</span>
					@endif
					@if($job->finished)
						<span class="badge badge-danger">Job is done</span>
					@elseif($job->appliers()->where('choosen', true)->exists())
						<span class="badge badge-primary">Job in progress</span>
					@endif
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		@endforeach
	</div>

</div>
@endif

