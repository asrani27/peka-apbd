<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'PEKA APBD' }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">

    @stack('css')
    <link rel="stylesheet" href="/notif/dist/css/iziToast.min.css">
    <script src="/notif/dist/js/iziToast.min.js" type="text/javascript"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light"
            style="box-shadow: 0px 1px 10px silver;">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> --}}
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                {{-- <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li> --}}

                <!-- Messages Dropdown Menu -->
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="dist/img/user1-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="dist/img/user8-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="dist/img/user3-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li> --}}
                <!-- Notifications Dropdown Menu -->
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li> --}}
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->


        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="/logo/peka.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
                <span class="brand-text font-weight-light">
                    @if (Auth::user()->roles == 'superadmin')
                    BPKPAD
                    @else
                    {{Auth::user()->skpd->singkatan}}
                    @endif
                </span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        @guest

                        <li class="nav-item">
                            <a href="/" class="nav-link">
                                <i class="nav-icon fa fa-user-lock"></i>
                                <p>
                                    SIGN IN
                                </p>
                            </a>
                        </li>
                        @endguest

                        @if (Auth::user()->roles == 'superadmin')

                        <li class="nav-item">
                            <a href="/superadmin" class="nav-link {{request()->is('superadmin') ? 'active':''}}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    DASHBOARD
                                </p>
                            </a>
                        </li>
                        <li class="nav-item {{request()->is('superadmin/ikpa*') ? 'menu-is-opening menu-open':''}}">
                            <a href="#" class="nav-link {{request()->is('superadmin/ikpa*') ? 'active':''}}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    PERHITUNGAN IKPA
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/superadmin/ikpa/revisi"
                                        class="nav-link {{request()->is('superadmin/ikpa/revisi*') ? 'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Revisi DPA</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/superadmin/ikpa/deviasi"
                                        class="nav-link {{request()->is('superadmin/ikpa/deviasi*') ? 'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Deviasi DPA</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/superadmin/ikpa/penyerapan"
                                        class="nav-link {{request()->is('superadmin/ikpa/penyerapan*') ? 'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Penyerapan Anggaran</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/superadmin/ikpa/capaian"
                                        class="nav-link {{request()->is('superadmin/ikpa/capaian*') ? 'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Capaian Output</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/superadmin/penilaian"
                                class="nav-link {{request()->is('superadmin/penilaian*') ? 'active':''}}">
                                <i class="nav-icon fas fa-pen"></i>
                                <p>
                                    PENILAIAN
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/superadmin/skpd"
                                class="nav-link {{request()->is('superadmin/skpd*') ? 'active':''}}">
                                <i class="nav-icon fas fa-building"></i>
                                <p>
                                    SKPD
                                </p>
                            </a>
                        </li>
                        @else

                        <li class="nav-item">
                            <a href="/admin" class="nav-link {{request()->is('admin') ? 'active':''}}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    DASHBOARD
                                </p>
                            </a>
                        </li>
                        <li class="nav-item {{request()->is('admin/ikpa*') ? 'menu-is-opening menu-open':''}}">
                            <a href="#" class="nav-link {{request()->is('admin/ikpa*') ? 'active':''}}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    PERHITUNGAN IKPA
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/admin/ikpa/deviasi"
                                        class="nav-link {{request()->is('admin/ikpa/deviasi*') ? 'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Deviasi DPA</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/admin/ikpa/penyerapan"
                                        class="nav-link {{request()->is('admin/ikpa/penyerapan*') ? 'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Penyerapan Anggaran</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/admin/ikpa/capaian"
                                        class="nav-link {{request()->is('admin/ikpa/capaian*') ? 'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Capaian Output</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        <li class="nav-item">
                            <a href="/logout" class="nav-link" onclick="return confirm('Yakin ingin keluar?');">
                                <i class="nav-icon fas fa-arrow-right"></i>
                                <p>
                                    SIGN OUT
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <br />

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            Copyright &copy; 2025 PEKA APBD <strong>Pemerintah Kota Banjarmasin</strong>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/dist/js/adminlte.min.js"></script>

    @stack('js')
    <script>
        function hanyaAngka(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}
    </script>
    <script type="text/javascript">
        @include('layouts.notif')
    </script>
</body>

</html>