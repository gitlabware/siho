<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('/img/user-ico.ico')}}" class="img-circle" alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}
                    </a>
                </div>
            </div>
    @endif


        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li class=""><a href="{{ url('clientes') }}"><i class='fa fa-user-secret'></i> <span>Clientes</span></a></li>
            <li class=""><a href="{{ url('grupos') }}"><i class='fa fa-group'></i> <span>Grupos</span></a></li>
            <li class=""><a href="{{ url('pisosHotel',[Auth::user()->hotel_id]) }}"><i class='fa fa-building-o'></i>
                    <span>Lista Habitaciones</span></a></li>
            <li class=""><a href="{{ url('vhabitaciones') }}"><i class='fa fa-cubes'></i> <span>Cuadro Habitaciones</span></a>
            </li>
            <li class=""><a href="{{ url('registros') }}"><i class='fa fa-database'></i> <span>Registros</span></a>
            </li>
            <li class=""><a href="{{ url('cajas') }}"><i class='fa fa-money'></i> <span>Caja Chica</span></a></li>
            <li class=""><a href="{{ url('categorias') }}"><i class='fa fa-flag-o'></i>
                    <span>Categorias Habitacion</span></a></li>
            <li class=""><a href="{{ url('actividads') }}"><i class='fa fa-bell'></i> <span>Actividades</span></a>
            </li>
            <li class=" treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>REPORTES</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="{{ url('pasajeros_reporte') }}"><i class="fa fa-circle-o"></i> <span>Reporte de Pasajeros</span></a>
                    </li>
                    <li class="active"><a href="{{ url('reporte_pagos') }}"><i class='fa fa-circle-o'></i> <span>Reporte de Cajas</span></a>
                    </li>
                    <li class="active"><a href="{{ url('repo_pago_regis') }}"><i class='fa fa-circle-o'></i> <span>Reporte de Pagos</span></a>
                    </li>
                    <li class="active"><a href="{{ url('reporte_registros') }}"><i class='fa fa-circle-o'></i> <span>Reporte de Registros</span></a>
                    </li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
