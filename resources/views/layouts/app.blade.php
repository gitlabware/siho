<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
    @include('layouts.partials.htmlheader')
@show

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="skin-blue sidebar-mini">
<div class="wrapper">

@include('layouts.partials.mainheader')
@if (! Auth::guest())
    @if(Auth::user()->rol == 'Super Administrador')
        @include('layouts.sidebar.superadmin')
    @elseif(Auth::user()->rol == 'Administrador')
        @include('layouts.sidebar.administrador')
    @else
        @include('layouts.sidebar.operario')
    @endif
@endif

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

    @include('layouts.partials.contentheader')

    <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('main-content')
            @yield('content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    @include('layouts.partials.controlsidebar')

    @include('layouts.partials.footer')

    @include('layouts.partials.modal')

</div><!-- ./wrapper -->

@section('scripts')
    @include('layouts.partials.scripts')
@show
@stack('scriptsextras')
</body>
</html>