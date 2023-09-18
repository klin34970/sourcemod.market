<!-- Start tabs heading -->
<div class="panel-heading no-padding">
	<ul class="nav nav-tabs">
		<li {{ App\Http\Classes\Menu::getActiveRoute(['jobs', '*', '*', '*'], 'class=active', '', true) }}>
			<a href="{!! URL::route('jobs.view', ['id' => $job->id, 'game' => App\Http\Classes\Slug::filter($job->game->title), 'title' => App\Http\Classes\Slug::filter($job->title) ]) !!}">
				<i class="fa fa-file-text"></i>
				<span>{{ trans('front/jobs/view.tab-item-details') }}</span>
			</a>
		</li>
		<li {{ App\Http\Classes\Menu::getActiveRoute(['jobs', '*', '*', '*', 'discussions'], 'class=active') }}>
			<a href="{!! URL::route('jobs.view.discussions', ['id' => $job->id, 'game' => App\Http\Classes\Slug::filter($job->game->title), 'title' => App\Http\Classes\Slug::filter($job->title) ]) !!}">
				<i class="fa fa-comments"></i>
				<span>{{ trans('front/jobs/view.tab-discussions') }} ({{ count($job->discussions) }})</span>
			</a>
		</li>
		<li {{ App\Http\Classes\Menu::getActiveRoute(['jobs', '*', '*', '*', 'appliers'], 'class=active') }}>
			<a href="{!! URL::route('jobs.view.appliers', ['id' => $job->id, 'game' => App\Http\Classes\Slug::filter($job->game->title), 'title' => App\Http\Classes\Slug::filter($job->title) ]) !!}">
				<i class="fa fa-suitcase"></i>
				<span>{{ trans('front/jobs/view.tab-appliers') }} ({{ count($job->appliers) }})</span>
			</a>
		</li>			
	</ul>
</div><!-- /.panel-heading -->
<!--/ End tabs heading -->