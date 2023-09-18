            <!-- START @HEADER -->
            <header id="header">

                <!-- Start header left -->
                <div class="header-left">
                    <!-- Start offcanvas left: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
                    <div class="navbar-minimize-mobile left">
                        <i class="fa fa-bars"></i>
                    </div>
                    <!--/ End offcanvas left -->

                    <!-- Start navbar header -->
                    <div class="navbar-header">

                        <!-- Start brand -->
                        <a class="navbar-brand" href="{!! URL::route('dashboard.default') !!}">
                            <img class="logo" src="/assets/images/logos/175x50.png" alt="brand logo">
                        </a><!-- /.navbar-brand -->
                        <!--/ End brand -->

                    </div><!-- /.navbar-header -->
                    <!--/ End navbar header -->

                    <!-- Start offcanvas right: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
                    <div class="navbar-minimize-mobile right">
                        <i class="fa fa-cog"></i>
                    </div>
                    <!--/ End offcanvas right -->

                    <div class="clearfix"></div>
                </div><!-- /.header-left -->
                <!--/ End header left -->

                <!-- Start header right -->
                <div class="header-right">
                    <!-- Start navbar toolbar -->
                    <div class="navbar navbar-toolbar">

                        <!-- Start left navigation -->
                        <ul class="nav navbar-nav navbar-left">

                            <!-- Start sidebar shrink -->
                            <li class="navbar-minimize">
                                <a href="javascript:void(0);" title="Minimize sidebar">
                                    <i class="fa fa-bars"></i>
                                </a>
                            </li>
                            <!--/ End sidebar shrink -->
							
							@yield('search')

                        </ul><!-- /.nav navbar-nav navbar-left -->
                        <!--/ End left navigation -->

                        <!-- Start right navigation -->
                        <ul class="nav navbar-nav navbar-right"><!-- /.nav navbar-nav navbar-right -->

							<!-- Start profile -->
							<li class="dropdown navbar-profile">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<span class="meta">
										<span class="avatar">
										@if(isset($logged_user) && $logged_user->user_profile()->count())
											<img src="{!! $logged_user->user_profile()->first()->presenter()->avatar('30') !!}" width="30" class="img-circle">
										@else
											<img src="{!! URL::asset('lol') !!}" width="30" class="img-circle">
										@endif
										</span>
										<span class="text hidden-xs hidden-sm text-muted">
											{!! isset($logged_user) ? $logged_user->user_profile()->first()->first_name  : 'First name' !!}
										</span>
										<span class="caret"></span>
									</span>
								</a>
								<!-- Start dropdown menu -->
								<ul class="dropdown-menu animated flipInX">
									<li class="dropdown-header">{{ trans('admin/header/navbar.account') }}</li>
									<li><a href="{!! URL::route('users.selfprofile.edit') !!}"><i class="fa fa-user"></i>{{ trans('admin/header/navbar.view-profile') }}</a></li>
									<li class="divider"></li>
									<li><a href="{!! URL::route('user.logout') !!}"><i class="fa fa-sign-out"></i>{{ trans('admin/header/navbar.logout') }}</a></li>
								</ul>
								<!--/ End dropdown menu -->
							</li><!-- /.dropdown navbar-profile -->
							<!--/ End profile -->

							<!-- Start settings -->
							<li class="navbar-setting pull-right">
								<a href="javascript:void(0);"><i class="fa fa-cog fa-spin"></i></a>
							</li><!-- /.navbar-setting pull-right -->
							<!--/ End settings -->

                        </ul>
                        <!--/ End right navigation -->

                    </div><!-- /.navbar-toolbar -->
                    <!--/ End navbar toolbar -->
                </div><!-- /.header-right -->
                <!--/ End header left -->

            </header> <!-- /#header -->
            <!--/ END HEADER -->