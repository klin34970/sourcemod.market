@section('styles')
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/dataTables.bootstrap.css') !!}
	{!! Html::style('assets/global/plugins/bower_components/datatables/css/datatables.responsive.css') !!}
@stop

@extends('laravel-authentication-acl::client.layouts.base')


@section('title', 'Scripts')
@section('description', 'Are you a content creator who wants to publish his work? Sourcemod.Market is the best solution for you! ')
@section('keywords', 'script, content creator, sourcemod, gmod, css, csgo, plugin, minecraft, market, gta, half life')

@section('og_type', 'website')
@section('twitter_card', 'summary')
@section('og_image', url('/') . '/assets/images/logos/banner.png')



@section('page', 'page-sourceguard-servers')		
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start body content -->
	<div class="body-content animated fadeIn" style="background-color: #e9eaed;">
			<div class="panel">
				<div class="panel-heading">
					<form class="form-horizontal" method="GET" style="padding-top: 8px!important;">
						<div class="form-group no-margin no-padding has-feedback">
							<div class="col-md-6">
								<div class="input-group">
									<input name="search" class="form-control" type="text" value="{{ Request::has('search') ? Request::get('search') : '' }}">
									<span class="input-group-btn">
										<button type="submit" class="btn btn-theme"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="input-group" style="width: 100%;">
								<span class="input-group-addon bg-theme"><i class="fa fa-gamepad"></i></span>
								{!! Form::select('game_id', ['' => 'All'] + App\Http\Models\Front\ScriptModel::_getGamesList(), Request::has('game_id') ? Request::get('game_id') : '', ['class' => 'form-control', 'autocomplete' => 'off', 'onchange' => 'this.form.submit()']) !!}
								</div>
							</div>				
						</div>
					</form>
				</div><!-- /.panel-heading -->
				<div class="panel-body"><!-- /.panel-body -->
					
					<table id="datatable-dom" class="table table-theme">
						<thead>
						<tr>
							<th data-hide="phone, tablet">{{ trans('front/sourceguard/servers/list.table-head-game') }}</th>
							<th data-class="expand">{{ trans('front/sourceguard/servers/list.table-head-title') }}</th>
							<th data-hide="phone, tablet">{{ trans('front/sourceguard/servers/list.table-head-ip-port') }}</th>
							<th data-hide="phone, tablet">{{ trans('front/sourceguard/servers/list.table-head-script') }}</th>
							<th data-hide="phone, tablet">{{ trans('front/sourceguard/servers/list.table-head-version') }}</th>
							<th data-hide="phone, tablet">{{ trans('front/sourceguard/servers/list.table-head-updated') }}</th>
						</tr>
						</thead>
						<tbody>
							@foreach($scripts as $script)
							<tr>
								<td>
									<a href="{{ URL::route('games.scripts.list', ['id' => $script->game->id, 'title' => App\Http\Classes\Slug::filter($script->game->title)]) }}">
										{{ $script->game->title }}
									</a>
								</td>
								<td>
									{{ $script->hostname }}
								</td>
								<td>
									 <a href="{{$script->game->game_hook}}{{ $script->ip }}:{{ $script->port }}">{{ $script->ip }}:{{ $script->port }}</a>
								</td>
								<td>

									<a href="{!! URL::route('scripts.view', ['id' => $script->script_id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->script->category->title), 'title' => App\Http\Classes\Slug::filter($script->script->title) ]) !!}">
										{{ $script->script->title }}
									</a>
								</td>
								<td>
									{{ $script->versions()->first()->name }}
								</td>
								<td>
									<span class="badge badge-success">{{ $script->last_activity->diffForHumans() }}</span>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>					
					
				</div><!-- /.panel -->
				<div class="panel-footer">
					<div class="text-center">
					{{ $scripts->appends(['search' => Request::get('search'), 'game_id' => Request::get('game_id')])->links() }}
					</div>
				</div>
			</div>
	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')	
	{!! Html::script('assets/global/plugins/bower_components/datatables/js/jquery.dataTables.min.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/datatables/js/dataTables.bootstrap.js') !!}
	{!! Html::script('assets/global/plugins/bower_components/datatables/js/datatables.responsive.js') !!}
	{!! Html::script('assets/admin/js/pages/blankon.sourceguard.servers.list.js') !!}
    <script>
        $(".delete").click(function(){
            return confirm('{!! trans("front/dashboard/scripts/list.confirm-delete") !!}');
        });
		BlankonTable.init(
							'{!! trans("js/datatable.trans-menu") !!}', 
							'{!! trans("js/datatable.trans-record") !!}', 
							'{!! trans("js/datatable.trans-info") !!}', 
							'{!! trans("js/datatable.trans-info-empty") !!}', 
							'{!! trans("js/datatable.trans-info-filtered") !!}', 
							'{!! trans("js/datatable.trans-search") !!}', 
							'{!! trans("js/datatable.trans-previous") !!}', 
							'{!! trans("js/datatable.trans-next") !!}'
						);
    </script>
@stop