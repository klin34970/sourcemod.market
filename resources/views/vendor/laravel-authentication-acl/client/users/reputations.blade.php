@extends('laravel-authentication-acl::client.layouts.base')

@section('title', $user->user_profile()->first()->first_name)
@section('description', $user->user_profile()->first()->first_name)
@section('keywords', str_replace(' ', ', ', $user->user_profile()->first()->first_name))
@section('og_type', 'website')
@section('twitter_card', 'website')
@section('og_image', url('/') . '/assets/images/logos/banner.png')

@section('page', 'page-users-reputations') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

	<!-- Start page header -->
	<div class="header-content">
		<h2><i class="fa fa-user"></i> {{ $user->user_profile()->first()->first_name }}</h2>
	</div><!-- /.header-content -->
	<!--/ End page header -->

	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row" id="blog-single">

			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			
			<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
				
				<div class="panel panel-tab rounded shadow">
				
					@include('laravel-authentication-acl::client.users.panel-heading')

					<!-- Start tabs content -->
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1">
								<div class="panel panel-default panel-blog rounded shadow">
									<div class="panel-body">
									@if(isset($reputations_p))
									<table class="table">
									<thead>
                                        <tr>
                                            <th>{{ trans('front/users/view.table-user') }}</th>
                                            <th>{{ trans('front/users/view.table-script') }}</th>
                                            <th>{{ trans('front/users/view.table-reputation') }}</th>
                                        </tr>
                                    </thead>
										<tbody>
											@foreach($reputations_p as $reputation)
												<tr>
													<td>
														<a href="{{ URL::route('users.view', ['id' => $reputation->user_id]) }}">
															{{ $reputation->user_profile->first()->first_name }}
														</a>
													</td>
													<td>
														<a href="{{ URL::route('scripts.view', ['id' => $reputation->script->id , 'game' => App\Http\Classes\Slug::filter($reputation->script->game->title), 'category' => App\Http\Classes\Slug::filter($reputation->script->category->title), 'title' => App\Http\Classes\Slug::filter($reputation->script->title)]) }}">
															{{ $reputation->script->title }}
														</a>
													</td>
													<td>+{{ $reputation->stars }}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
									
									{{ $reputations_p->links() }}
									@endif
									</div><!-- panel-body -->
								</div><!-- panel-blog -->
							</div>
						</div>
					</div><!-- /.panel-body -->
					<!--/ End tabs content -->
				</div><!-- /.panel -->
				
			</div>

			@include('laravel-authentication-acl::client.users.sidebar-right')

		</div><!-- row -->

	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection