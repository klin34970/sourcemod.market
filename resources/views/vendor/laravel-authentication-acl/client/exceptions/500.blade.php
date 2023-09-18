@section('styles')
	{!! Html::style('assets/admin/css/pages/error-page.css') !!}
@endsection

@extends('laravel-authentication-acl::client.layouts.base')

@section('title', '500')
@section('description', '500')
@section('keywords', '500')
@section('og_type', 'website')
@section('twitter_card', 'website')
@section('og_image', url('/') . '/assets/images/logos/banner.png')

@section('page', 'page-500') 
@section('content')
<!-- START @PAGE CONTENT -->
<section id="page-content">

                <!-- Start body content -->
                <div class="body-content animated fadeIn">

                    <div class="row">
                        <div class="col-md-12">

                            <!-- START @ERROR PAGE -->
                            <div class="error-wrapper">
                                <h1>500</h1>
                                <h3>Internal Server Error.</h3>
                                <h4>Sorry, something went wrong.</h4>
                                <a href="{{ URL::to('/') }}" class="btn btn-sm btn-theme">Return to Home</a>
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
