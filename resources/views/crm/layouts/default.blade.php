@extends('crm.layouts.app')

@section('body')

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col" id="position_fixed">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="{{url('/dashboard')}}" class="site_title"><i class="fa fa-home" aria-hidden="true"></i><!--img src="{{-- URL::asset('images/logo.png')--}}" alt="image" height="25" width="25"--><span>Rivera & Asociados</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="{{ URL::asset('images/img.jpg')}}" alt="image" class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Bienvenido(a)</span>
                            <h2>{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            {{--<h3>General</h3>--}}
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-home"></i> Principal <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('homedaily') }}">Pendientes del día</a></li>
                                        <li><a href="{{ route('homecalender') }}">Calendario</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-edit"></i> Correo Electrónico <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{route('inbox')}}">Bandeja de entrada</a></li>
                                        <li><a href="{{route('sendemail')}}">Enviar Correo</a></li>
                                    </ul>
                                </li>
                                @role(array('super_user','owner','cashier','collect','sells'))
                                <li><a><i class="fa fa-bar-chart-o"></i> Contabilidad <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        @role('super_user')
                                        <li><a href="{{ route('homeaccounting') }}">Movimientos</a></li>
                                        @endrole
                                        @role(array('super_user','owner','cashier'))
                                        <li><a href="{{ route('homepos') }}">Caja</a></li>
                                        @endrole
                                        @role(array('super_user','owner','collect', 'sells'))
                                        <li><a href="{{ route('duedepandants')}}">Pagos pendientes</a></li>
                                        @endrole
                                    </ul>
                                </li>
                                @endrole


                                @role(array('super_user','owner','cashier','collect','sells'))
                                <li><a><i class="fa fa-sitemap"></i> Clientes <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        @role(array('super_user','owner','cashier','collect','sells'))
                                        <li><a href="{{route('homeclient')}}">Registro de clientes</a>
                                            @endrole
                                            @role(array('super_user','owner','cashier','collect','sells'))
                                        <li><a href="{{route('listclient')}}">Lista clientes</a>
                                            @endrole
                                            @role(array('super_user','owner'))
                                        <li><a href="{{route('listuser')}}">Historico de Pagos</a>
                                            @endrole 
											@role(array('super_user','owner'))
                                        <li><a href="https://oficinavirtualsalud.humano.com.do/app/login.aspx">Interface Humano</a>
                                            @endrole

                                    </ul>
                                </li>  
                                @endrole
                              
								@role(array('super_user','owner'))
                                <li><a><i class="fa fa-user"></i> Recursos Humanos <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{route('humanresource')}}">Recursos Humanos</a></li>
                                        <li><a href="{{route('pendingtasks')}}">Tareas pendientes</a></li>
                                    </ul>
                                </li>
                                @endrole
                                @role(array('super_user','owner'))
                                <li><a><i class="fa fa-gear"></i> Configuración <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{route('banksview')}}">Bancos</a></li>
                                    </ul>
                                </li>
                                @endrole
                            </ul>
                        </div>

                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <!--a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a-->
                        

                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:void(0);" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ URL::asset('images/img.jpg')}}" alt="">{{ Auth::user()->name }}
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    
                                    <li>
										<a href="javascript:void(0);">
                                            <form id="logout-form-user-nav" action="{{ route('logout') }}" method="POST" >
												{{ csrf_field() }}
												<input type="submit" value="Log Out" class="btn btn-sm btn-primary pull-right fa fa-sign-out">
											</form>
                                        </a>
                                        
                                    </li>
                                </ul>
                            </li>

                            <!--li role="presentation" class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green">6</span>
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                    <li>
                                        <a>
                                            <span class="image"><img src="{{ URL::asset('images/img.jpg')}}" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image"><img src="{{ URL::asset('images/img.jpg')}}" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image"><img src="{{ URL::asset('images/img.jpg')}}" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image"><img src="{{ URL::asset('images/img.jpg')}}" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="text-center">
                                            <a>
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li-->
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                @yield('content')
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    <a href="{{url('/dashboard')}}">Rivera & Asociados</a>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>





    <!-- Optionally, you can add Slimscroll and FastClick plugins.
             Both of these plugins are recommended to enhance the
             user experience. Slimscroll is required when using the
             fixed layout. -->


    <script type="text/javascript" src="{{  URL::asset('/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/fastclick/lib/fastclick.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/nprogress/nprogress.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/jquery.hotkeys/jquery.hotkeys.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/google-code-prettify/src/prettify.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/Chart.js/dist/Chart.min.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/gauge.js/dist/gauge.min.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/iCheck/icheck.min.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/skycons/skycons.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/Flot/jquery.flot.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/Flot/jquery.flot.pie.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/Flot/jquery.flot.time.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/Flot/jquery.flot.stack.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/Flot/jquery.flot.resize.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/flot.curvedlines/curvedLines.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/DateJS/build/date.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/js/loadingoverlay_progress.min.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/js/loadingoverlay.min.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/js/printThis.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/js/sweetalert.min.js') }}"></script>

    <script type="text/javascript" src="{{ URL::asset('/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script type="text/javascript" src="{{  URL::asset('/js/bootstrap-datetimepicker.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/js/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/js/jquery.bpopup.min.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/js/jquery.plugin.min.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/js/jquery.maxlength.min.js') }}"></script>
    <script type="text/javascript" src="{{  URL::asset('/js/jquery.mask.js') }}"></script>

    <script type="text/javascript" src="{{  URL::asset('/build/js/custom.min.js') }}"></script>
    @yield('javascripts')
</body>
@stop
