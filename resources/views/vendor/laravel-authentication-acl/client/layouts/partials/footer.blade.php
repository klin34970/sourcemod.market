<footer class="footer-content">

	<div>
	
		<div class="row">

			<div class="col-md-2 col-sm-6 col-xs-12">
				<div class="panel panel-theme rounded shadow">
					<div class="panel-body text-center bg-theme">
						<p class="h4 no-margin text-strong">{{ App\Http\Classes\Number::changeFormat($total_views) }} {{ trans('front/footer/footer.views') }}</p>
					</div><!-- /.panel-body -->
				</div><!-- /.panel -->
			</div>
			
			<div class="col-md-2 col-sm-6 col-xs-12">
				<div class="panel panel-theme rounded shadow">
					<div class="panel-body text-center bg-theme">
						<p class="h4 no-margin text-strong">{{ App\Http\Classes\Number::changeFormat($total_downloads) }} {{ trans('front/footer/footer.downloads') }}</p>
					</div><!-- /.panel-body -->
				</div><!-- /.panel -->
			</div>
			
			<div class="col-md-2 col-sm-6 col-xs-12">
				<div class="panel panel-theme rounded shadow">
					<div class="panel-body text-center bg-theme">
						<p class="h4 no-margin text-strong">{{ $total_jobs}} {{ trans('front/footer/footer.jobs') }}</p>
					</div><!-- /.panel-body -->
				</div><!-- /.panel -->
			</div>
			
			<div class="col-md-2 col-sm-6 col-xs-12">
				<div class="panel panel-theme rounded shadow">
					<div class="panel-body text-center bg-theme">
						<p class="h4 no-margin text-strong">{{ $total_scripts}} {{ trans('front/footer/footer.scripts') }}</p>
					</div><!-- /.panel-body -->
				</div><!-- /.panel -->
			</div>
			
			<div class="col-md-2 col-sm-6 col-xs-12">
				<div class="panel panel-theme rounded shadow">
					<div class="panel-body text-center bg-theme">
						<p class="h4 no-margin text-strong">{{ $total_users}} {{ trans('front/footer/footer.users') }}</p>
					</div><!-- /.panel-body -->
				</div><!-- /.panel -->
			</div>
			
			<div class="col-md-2 col-sm-6 col-xs-12">
				<div class="panel panel-theme rounded shadow">
					<div class="panel-body text-center bg-theme">
						<p class="h4 no-margin text-strong"><span id="counter_online">{{ $total_users_online }}&nbsp;</span> online users</p>
					</div><!-- /.panel-body -->
				</div><!-- /.panel -->
			</div>
	
		</div>
		
		<div class="line no-margin"></div>
		
		<div class="row">
		
			<div class="col-md-6">
				<div>
					<a href="{{URL::to('/') }}/sitemap.xml">Sitemap</a>
					|
					<a href="{{URL::route('about.terms') }}">Terms and Conditions</a>
					|
					<a href="{{URL::route('about.policy') }}">Privacy Policy</a>
					|
					<a href="{{URL::route('help.contact') }}">Contact</a>
					|
					<span>2016 - 2017 @ <a target="_blank" href="https://www.devsapps.com">DevsApps</a> SIRET 53164474800026</span>
				</div>
			</div>
			
			
			<div class="col-md-6">

			</div>
		
		</div>
		
	</div>
</footer>