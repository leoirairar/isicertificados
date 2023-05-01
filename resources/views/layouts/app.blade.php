<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <base href="{{ url('/') }}/">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/v4-shims.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-4-hover-navbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Chart.css') }}" rel="stylesheet">
    <link href="{{ asset('css/general.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fullcalendar/core/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fullcalendar/daygrid/main.css') }}" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="{{ asset('dashboard/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('dashboard/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('dashboard/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('dashboard/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('dashboard/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('dashboard/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('dashboard/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">

    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

</head>

<body>
    <div id="app" class="">
        <div class="page-wrapper">
            <!-- HEADER MOBILE-->
            <header class="header-mobile d-block d-lg-none">
                <div class="header-mobile__bar">
                    <div class="container-fluid">
                        <div class="header-mobile-inner">
                            <a class="logo" href="index.html">
                                <img src="images/logo.jpg" alt="CoolAdmin" />
                            </a>
                            <button class="hamburger hamburger--slider" type="button">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
        </div>
        @include('layouts.sidebar')
        <div class="page-container">
            <header class="header-desktop">
                <div class="logo" style="display: inline-block;">
                    <a href="{{ url('/') }}">
                        <img src="images/logo.jpg" alt="Logo ISI" style="max-width: 80px;margin-left: 100px;" />
                    </a>
                </div>
                @auth
                    @if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
                        <ul class="header-menu">
                            <li><a class="dropdown-item" href="{{ url('/EnrolledEmployees') }}">Usuarios preinscritos</a>
                            </li>
                            {{-- <li><a class="dropdown-item" href="{{ url('/ministryDocument') }}">Ministerio</a></li> --}}
                            <li><a class="dropdown-item" href="{{ url('/enrollmentHistory') }}">Inscripción personal</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ url('/getCertificates') }}">Consultar Certificados</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ url('/getEmployeeCertificates') }}">Consultar
                                    certificados por cedula</a></li>
                            <li><a class="dropdown-item" href="{{ url('/showUserByIdentification') }}">Consultar Empleado
                                    por cedula</a></li>
                        </ul>
                    @endif
                @endauth
                <div class="section__content section__content--p30" style="text-align:right;">
                    @guest
                        @if (Route::currentRouteName() == 'login')
                            <a class="btn mr-2" style="background-color: darkorange; color: white"
                                href="{{ route('getInsertCompanyView') }}">{{ __('Registrar Empresa') }}</a>
                            <a class="btn mr-2" style="background-color: darkorange; color: white"
                                href="{{ route('getAttendaceCertificateView') }}">{{ __('Descargar certificado de asistencia') }}</a>
                        @else
                            <a class="btn mr-2" style="background-color: darkorange; color: white"
                                href="{{ route('login') }}">{{ __('Regresar') }}</a>
                        @endif
                    @else
                        <div class="noti-wrap">
                            <div class="noti__item js-item-menu">
                                <i class="fas fa-bell"></i>
                                <span class="quantity" id="notifyQuantity"></span>
                                <div class="notifi-dropdown js-dropdown">
                                    <div id="notificationsContent">
                                        <div class="notifi__title" id="notifytitle">
                                        </div>
                                        <div class="container" id="notifyContent">

                                        </div>
                                    </div>
                                    <div class="notifi__footer">
                                        <a href="{{ url('/notifications') }}">Todas las notificaciones</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                {{ __('Cerrar sesión') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            <a id="navbarDropdown" class="dropdown-item" href="">Cambiar contraseña</a>
                        </div>
                    @endguest
                </div>
            </header>
            <div class="main-content">
                @auth()
                    <div style="display: flex;justify-content: center;">
                        <div class="card border-primary mb-3" style="max-width:100%;">
                            <div class="card-body text-primary">
      <p class="card-text">Hemos realizado una actualizacion en la aplicacion y es necesario que
                                    hagas click sobre el boton para
                                    agregar la ARL y el empleador o representante legal para los nuevos certificados <button
                                        type="button" class="btn btn-primary btn-sm"><a style="color:white"
                                            href="{{ url('editCompany/' . Auth::user()->load('companyAdministrator')->companyAdministrator[0]->company_id) }}"
                                            class="alert-link">Editar Empresa</a></button> .</p>
                            </div>
                        </div>
                    </div>
                @endauth
                @yield('content')
            </div>
        </div>

    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment-with-locales.min.js"></script>
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/app/general.js') }}"></script>
    <script src="{{ asset('js/locales/bootstrap-datepicker.es.min.js') }}"></script>

    <!-- Vendor JS       -->
    <script src="{{ asset('dashboard/slick/slick.min.js') }}"></script>
    <script src="{{ asset('dashboard/wow/wow.min.js') }}"></script>
    <script src="{{ asset('dashboard/animsition/animsition.min.js') }}"></script>
    <script src="{{ asset('dashboard/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ asset('dashboard/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('dashboard/counter-up/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('dashboard/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('dashboard/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    {{-- <script src="{{ asset('dashboard/chartjs/Chart.bundle.min.js') }}"></script> --}}
    <script src="{{ asset('dashboard/select2/select2.min.js') }}"></script>

    <!-- Main JS-->
    <script src="{{ asset('js/main.js') }}"></script>


</body>

</html>
