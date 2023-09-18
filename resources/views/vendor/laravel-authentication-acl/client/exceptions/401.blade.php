@section('styles')
	{!! Html::style('assets/admin/css/pages/error-page.css') !!}
@endsection

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', '404')
@section('description', '404')
@section('keywords', '404')
@section('og_type', 'website')
@section('twitter_card', 'website')
@section('og_image', url('/') . '/assets/images/logos/banner.png')

@section('page', 'page-404') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

                <!-- Start body content -->
                <div class="body-content animated fadeIn">

                    <div class="row">
                        <div class="col-md-12">

                            <!-- START @ERROR PAGE -->
                            <div class="error-wrapper">
                                <h1>401!</h1>
                                <h3>Forbidden: Access is denied.</h3>
                                <h4>You do not have permission to view this directory or page using the creditials that you supplied.</h4>
                            </div>
                            <!--/ END ERROR PAGE -->

                        </div>
                    </div><!-- /.row -->

                </div><!-- /.body-content -->
                <!--/ End body content -->


	@include('laravel-authentication-acl::client.layouts.partials.footer')

</section><!-- /#page-content -->
<!--/ END PAGE CONTENT -->
@endsection
