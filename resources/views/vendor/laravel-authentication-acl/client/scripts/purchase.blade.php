@extends('laravel-authentication-acl::client.layouts.base')

@section('title', trans('front/scripts/purchase.title') . $script->title)
@section('description', $script->title)
@section('keywords', $script->tags)

@section('page', 'page-purchase-scripts') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">
	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-invoice rounded">
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-theme">
								<thead>
								<tr>
									<th>{{ trans('front/scripts/purchase.table-product') }}</th>
									<th>{{ trans('front/scripts/purchase.table-price') }}</th>
									<th>{{ trans('front/scripts/purchase.table-discount') }}</th>
									<th>{{ trans('front/scripts/purchase.table-tax') }}</th>
									<th>{{ trans('front/scripts/purchase.table-total') }}</th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td>
										<div class="product-name">
										<a href="{!! URL::route('scripts.view', ['id' => $script->id, 'game' => App\Http\Classes\Slug::filter($script->game->title), 'category' => App\Http\Classes\Slug::filter($script->category->title), 'title' => App\Http\Classes\Slug::filter($script->title) ]) !!}">{{ $script->title }}</a>
										</div>
									</td>
									<td>{{ number_format($script->price, 2) }} $</td>
									<td>{!! $script->price_discount > 0 ?  number_format($script->price - $script->price_discount, 2).' $' : '<i class="fa fa-close"></i>' !!}</td>
									@if(isset($tax->tax_normal))
										<td>TAX {{ $tax->country_code }} ({{ $tax->tax_normal }}%)</td>
									@else
										<td>NO TAX</td>
									@endif
									<td>
										@if(isset($tax->tax_normal))
											{{ $script->price_discount > 0 ?  number_format($script->price_discount + ($script->price_discount * $tax->tax_normal / 100), 2) : number_format($script->price + ($script->price * $tax->tax_normal / 100), 2) }} $
										@else
											{{ $script->price_discount > 0 ?  number_format($script->price_discount, 2) : number_format($script->price, 2) }} $
										@endif
									</td>
								</tr>
								</tbody>

							</table>
						</div><!-- /.table-responsive -->
					</div><!-- /.panel-body -->
					<div class="panel-footer">
						<div>
							<div class="form-group">
								<div class="ckbox ckbox-theme">
									<input id="terms" type="checkbox" onclick="checkTerms(this)">
									<label for="terms">{!! trans('front/scripts/purchase.terms') !!}</label>
								</div>
							</div>
						</div>
						<div class="pull-right">
							<a id="process" disabled="disabled" type="submit" class="btn btn-success pull-right rounded"><i class="fa fa-fw fa-arrow-right"></i> {{ trans('front/scripts/purchase.button-payment') }}</a>
						</div>
						<div class="clearfix"></div>
					</div><!-- /.panel-footer -->
				</div><!-- /.panel-invoice -->
			</div>
		</div><!-- /.row -->
	
	</div><!-- /.body-content -->
	<!--/ End body content -->
	
	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection

@section('scripts')
	<script>
		function checkTerms(elem)
		{
			var i = $(elem);
			var o = $('#process');
			if(i.is(':checked'))
			{
				o.attr('disabled', false);
				o.attr('href', '{!! $url !!}');
				
			}
			else
			{
				o.attr('disabled', true);
				o.removeAttr('href');
			}
		}
	</script>

@endsection