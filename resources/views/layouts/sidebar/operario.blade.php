<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}
                    </a>
                </div>
            </div>
    @endif

    <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control"
                       placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i
                            class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="{{ url('clientes') }}"><i class='fa fa-building-o'></i>
                    <span>Clientes</span></a></li>
            <li class="active"><a href="{{ url('pisosHotel',[Auth::user()->hotel_id]) }}"><i
                            class='fa fa-building-o'></i> <span>Lista Habitaciones</span></a></li>
            <li class="active"><a href="{{ url('vhabitaciones') }}"><i class='fa fa-tag'></i>
                    <span>Cuadro Habitaciones</span></a></li>
            <li class="active"><a href="{{ url('registros') }}"><i class='fa fa-building-o'></i> <span>Registros</span></a>
            </li>
            <li class="active"><a href="{{ url('cajas') }}"><i class='fa fa-building-o'></i> <span>Caja Chica</span></a>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
