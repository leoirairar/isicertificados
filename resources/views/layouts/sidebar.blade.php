<aside class="menu-sidebar d-none d-lg-block">
    <div class="menu-sidebar__content js-scrollbar1">

<nav class="navbar-sidebar">
        <div class="container-fluid">
        @if (Auth::user())             
            <ul class="list-unstyled navbar__list">
                <li>
                <a class="" href="{{ url('/') }}">
                        <i class="fas fa-home"></i>Inicio</a>
                </li>
                   @if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
                <li class="has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-tachometer-alt"></i>Administración</a>
                    <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                        <li><a class="dropdown-item" href="{{ url('/EnrolledEmployees') }}">Aprobar Usuarios preinscritos</a></li>
                        <li><a class="dropdown-item" href="{{ url('/attendance') }}">Registrar asistencia</a></li>
                        <li><a class="dropdown-item" href="{{ url('/getViewCourseFinalization') }}">Finalizar Curso</a></li>
                        <!-- <li><a class="dropdown-item" href="{{ url('/company') }}">Registrar facturas</a></li> -->
                        <li><a class="dropdown-item" href="{{ url('/rescheduleEmployees') }}">Reprogramar empleados</a></li>
                        <li><a class="dropdown-item" href="{{ url('/showUserByIdentification') }}">Buscar empleado por cedula</a></li>
                        <li><a class="dropdown-item" href="{{ url('/billsStatus') }}">Consultar estados de pago</a></li>
                          
                    </ul>
                </li>
                    @endif
                    @if (Auth::user()->role == 'S' || Auth::user()->role == 'M' || Auth::user()->role == 'A')
                <li class="has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-briefcase"></i>Empresa</a>
                    <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                        <li><a class="dropdown-item" href="{{ url('/getCompanies') }}">Editar Empresa</a></li>
                        <li><a class="dropdown-item" href="{{ url('/employee') }}">Crear Empleado</a></li>
                        <li><a class="dropdown-item" href="{{ url('/getCourseAssignment') }}">Preinscribir a Curso</a></li>
                        <li><a class="dropdown-item" href="{{ url('/preEnrolledEmployeesView') }}">Ver empleados pre inscritos</a></li>
                        <li><a class="dropdown-item" href="{{ url('/enrolledEmployessView') }}">Ver empleados inscritos</a></li>
                        <li><a class="dropdown-item" href="{{ url('/getCertificates') }}">Consultar certificados</a></li>
                        <li><a class="dropdown-item" href="{{ url('/getEmployeeCertificates') }}">Consultar certificados por cedula</a></li>
                    </ul>
                </li>
                @endif
                @if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
                <li class="has-sub">
                    <a class="js-arrow" href="#">
                    <i class="fas fa-certificate"></i>Ministerio</a>
                    <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                        <li><a class="dropdown-item" href="{{ url('/getCertificates') }}">Consultar Certificados</a></li>
                        <li><a class="dropdown-item" href="{{ url('/ministryDocument') }}">Doc Ministerio</a></li>
                        <li><a class="dropdown-item" href="{{ url('/enrollmentHistory') }}">Históricos de Inscripción</a></li>
                        <li><a class="dropdown-item" href="{{ url('/statistics') }}">Estadísticas</a></li>

                    </ul>
                </li>
                @endif

                @if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
                <li class="has-sub">
                    <a class="js-arrow" href="#">  <i class="fas  fa-folder-open"></i>Registro</a>
                    <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                        <li><a class="dropdown-item" href="{{ url('/upload') }}">Exel</a></li>
                    </ul>
                </li>
                @endif
                @if (Auth::user()->role == 'A')
                <li class="has-sub">
                    <a class="js-arrow" href="#">  <i class="fas  fa-folder-open"></i>Registro</a>

                    <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                        <li><a class="dropdown-item" href="{{ url('/upload') }}">Exel</a></li>
                    </ul>
                </li>
                @endif
                @if (Auth::user()->role == 'S' || Auth::user()->role == 'M')
                <li class="has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-cogs"></i>Configuración</a>
                    <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                        <li><a class="dropdown-item" href="{{ url('/getDocumentType') }}">Tipos Documentos</a></li>
                        <li><a class="dropdown-item" href="{{ url('/getCourses') }}">Cursos</a></li>
                        <li><a class="dropdown-item" href="{{ url('/courseProgramming') }}">Programar Cursos</a></li>
                        <li><a class="dropdown-item" href="{{ url('/getCourseProgramming') }}">Consultar Cursos Programados</a></li>
                        <li><a class="dropdown-item" href="{{ url('/getCompanies') }}">Empresas</a></li>
                        <li><a class="dropdown-item" href="{{ url('/getCompanyAdministrator') }}">Admin Empresa</a></li>
                        <li><a class="dropdown-item" href="{{ url('/getEmployee') }}">Empleados</a></li>
                        <li><a class="dropdown-item" href="{{ url('/getInstructor') }}">Instructores</a></li>
                        <li><a class="dropdown-item" href="{{ url('/getAdministrator') }}">Usuario ISI</a></li>
                        <li><a class="dropdown-item" href="{{ url('/banners') }}">Subir banner</a></li>
                        <li><a class="dropdown-item" href="{{ url('/showtHistorical') }}">Constancias</a></li>
                    </ul>
                </li>
                @endif
                @if (Auth::user()->role == 'A')
                <li class="has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-cogs"></i>Configuración</a>
                    <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                        <li><a class="dropdown-item" href="{{ url('/getEmployee') }}">Empleados</a></li>
                    </ul>
                </li>
                @endif
            </ul>
            @endif
</aside>