@section('styles')

@stop

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', 'API scripts')
@section('page', 'page-dashboard-scripts-api-key-edit') 

@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">


	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row">
			<div class="col-md-12">
				@if (count($errors) > 0)
					<div class="alert alert-danger">
						<ul>
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				
				<div class="panel rounded shadow">
					<div class="panel-body">


						<div class="panel rounded shadow">
							<div class="panel-body">
								<div class="col-sm-12">
									<div class="input-group mb-15">
										<span class="input-group-addon bg-success">GET</span>
										<input disabled="disabled" class="typing form-control no-border-left" type="text" value="api/scripts/v1/list?key=*****">
									</div>
								</div>
								<div class="col-sm-12">
									<code class="hljs clojure">
										<div class=""></div><pre class=""><code class="hljs nimrod"><div class="">{</div><div class="">&nbsp; &nbsp; <span class="hljs-string">"status"</span>: <span class="hljs-string">"success"</span>,</div><div class="">&nbsp; &nbsp; <span class="hljs-string">"scripts"</span>: [</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; {</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-string">"id"</span>: <span class="hljs-number">1</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-string">"user_id"</span>: <span class="hljs-number">1</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-string">"type"</span>: <span class="hljs-number">1</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-string">"dlc_id"</span>: <span class="hljs-number">0</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-string">"title"</span>: <span class="hljs-string">"AFK MANAGER"</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-string">"description"</span>: <span class="hljs-string">"..."</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-string">"game_id"</span>: <span class="hljs-number">1</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-string">"category_id"</span>: <span class="hljs-number">6</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-string">"price"</span>: <span class="hljs-number">0</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-string">"price_discount"</span>: <span class="hljs-number">0</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-string">"view"</span>: <span class="hljs-number">202</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-string">"activated"</span>: <span class="hljs-number">1</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-string">"reason_id"</span>: <span class="hljs-number">2</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-string">"tags"</span>: <span class="hljs-string">"afk,manager,kick,ban,player,rothgar"</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-string">"created_at"</span>: <span class="hljs-string">"2016-07-18 15:04:31"</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-string">"updated_at"</span>: <span class="hljs-string">"2016-08-20 19:00:55"</span></div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; },</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-meta">{...}</span></div><div class="">&nbsp; &nbsp; ]</div><div class="">}</div></code></pre><div class=""></div>
									</code>
								</div>
							</div>
						</div>
						
						<div class="panel rounded shadow">
							<div class="panel-body">
								<div class="col-sm-12">
									<div class="input-group mb-15">
										<span class="input-group-addon bg-success">GET</span>
										<input disabled="disabled" class="typing form-control no-border-left" type="text" value="api/scripts/v1/{id}?key=*****">
									</div>
								</div>
								
								<div class="col-sm-12">
									<code class="hljs clojure">
										<div class=""></div><pre class=""><code class="hljs json"><div class="">{</div><div class="">&nbsp; &nbsp; <span class="hljs-attr">"status"</span>: <span class="hljs-string">"success"</span>,</div><div class="">&nbsp; &nbsp; <span class="hljs-attr">"scripts"</span>: [</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; {</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-attr">"id"</span>: <span class="hljs-number">33</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-attr">"user_id"</span>: <span class="hljs-number">1</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-attr">"type"</span>: <span class="hljs-number">4</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-attr">"dlc_id"</span>: <span class="hljs-number">0</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-attr">"title"</span>: <span class="hljs-string">"Skins packages"</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-attr">"description"</span>: <span class="hljs-string">"..."</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-attr">"game_id"</span>: <span class="hljs-number">1</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-attr">"category_id"</span>: <span class="hljs-number">7</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-attr">"price"</span>: <span class="hljs-number">0</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-attr">"price_discount"</span>: <span class="hljs-number">0</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-attr">"view"</span>: <span class="hljs-number">1142</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-attr">"activated"</span>: <span class="hljs-number">1</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-attr">"reason_id"</span>: <span class="hljs-number">2</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-attr">"tags"</span>: <span class="hljs-string">"skin,csgo,dr. api,skins"</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-attr">"created_at"</span>: <span class="hljs-string">"2016-07-29 20:56:58"</span>,</div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="hljs-attr">"updated_at"</span>: <span class="hljs-string">"2016-08-20 21:55:09"</span></div><div class="">&nbsp; &nbsp; &nbsp; &nbsp; }</div><div class="">&nbsp; &nbsp; ]</div><div class="">}</div></code></pre><div class=""></div>
									</code>
								</div>
							</div>
						</div>


					</div><!-- /.panel-body -->
				</div>				
				
				
			</div><!-- /.col-md-12 -->
		</div><!-- /.row -->

	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')	

@stop