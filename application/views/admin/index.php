<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css');?>">
    <link rel="icon" href="<?=base_url()?>/images/logo.png">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css');?>">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body>
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <p class="navbar-brand">Cloud Booking</p>
                 <p class="navbar-brand hidden">C</p>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                   <ul class="nav navbar-nav">
                    <li>
                        <a href="<?=site_url('Welcome/index')?>"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                    </li>
                    <h3 class="menu-title">Master</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children active dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bars"></i>Data</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-home"></i><a href="<?=site_url('Kamar/read')?>">Tempat </a></li>
                            <li><i class="fa fa-address-card"></i><a href="<?=site_url('Pengguna/read')?>">Pengguna</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Transaksi</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-envelope"></i><a href="<?=site_url('Transaksi/read')?>">Pending</a></li>
                            <li><i class="fa fa-envelope-open"></i><a href="<?=site_url('Transaksi/data')?>">Confirm</a></li>
                            <li><i class="fa fa-window-close"></i><a href="<?=site_url('Transaksi/rejected')?>">Reject</a></li>
                            <li><i class="fa fa-plus"></i><a href="<?=site_url('Transaksi/add')?>">Baru</a></li>
                        </ul>
                    </li>
                </ul>
            </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">
                        
                        <div class="form-inline">
                        </div>


                        <div class="dropdown for-message">
                        </div>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-user" style="font-size: 24px; margin-right: 8px;"></i>
    <img class="user-avatar rounded-circle">
</a>


                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="<?= site_url('Auth/logout')?>"><i class="fa fa-power-off"></i> Logout</a>
                        </div>
                    </div>

                    <div class="language-select dropdown" id="language-select">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown"  id="language" aria-haspopup="true" aria-expanded="true">
                            <i class="flag-icon flag-icon-us"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="language">
                            <div class="dropdown-item">
                                <span class="flag-icon flag-icon-fr"></span>
                            </div>
                            <div class="dropdown-item">
                                <i class="flag-icon flag-icon-es"></i>
                            </div>
                            <div class="dropdown-item">
                                <i class="flag-icon flag-icon-us"></i>
                            </div>
                            <div class="dropdown-item">
                                <i class="flag-icon flag-icon-it"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="alert  alert-success alert-dismissible fade show" role="alert">
            Selamat datang <b><?= $this->session->userdata('nama')?></b> anda berhasil login 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>


            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-1">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton1" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="<?=site_url('Pengguna/read')?>">Kelola</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                            <span class="count"><?=$this->db->count_all('pengguna');?></span>
                        </h4>
                        <p class="text-light">Pengguna</p>

                        <div class="chart-wrapper px-0" style="height:70px;" height="70">
                            <canvas id="widgetChart1"></canvas>
                        </div>

                    </div>

                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-2">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton2" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="<?=site_url('Kamar/read')?>">Kelola</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                            <span class="count"><?=$this->db->count_all('kamar');?></span>
                        </h4>
                        <p class="text-light">Tempat</p>

                        <div class="chart-wrapper px-0" style="height:70px;" height="70">
                            <canvas id="widgetChart2"></canvas>
                        </div>

                    </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-3">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton3" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <div class="dropdown-menu-content">
                                   <a class="dropdown-item" href="<?=site_url('Transaksi/read')?>">Kelola</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                            <span class="count"><?=$this->db->count_all('transaksi');?></span>
                        </h4>
                        <p class="text-light">Transaksi Pending</p>

                    </div>

                    <div class="chart-wrapper px-0" style="height:70px;" height="70">
                        <canvas id="widgetChart3"></canvas>
                    </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-5">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton4" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="<?=site_url('Transaksi/data')?>">Kelola</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                        <span class="count">
                            <?= $this->db->where('status', 'Confirm')->count_all_results('transaksi'); ?>
                        </span>
                        </h4>
                        <p class="text-light">Transaksi Terkonfirmasi</p>

                        <div class="chart-wrapper px-3" style="height:70px;" height="70">
                            <canvas id="widgetChart4"></canvas>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-4">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton4" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="<?=site_url('Transaksi/rejected/')?>">Kelola</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                        <span class="count">
                            <?= $this->db->where('status', 'Rejected')->count_all_results('transaksi'); ?>
                        </span>
                        </h4>
                        <p class="text-light">Transaksi Ditolak</p>

                        <div class="chart-wrapper px-3" style="height:70px;" height="70">
                            <canvas id="widgetChart4"></canvas>
                        </div>

                    </div>
                </div>
            </div>

    </div>
    <script src="<?= base_url('assets/vendors/jquery/dist/jquery.min.js');?>"></script>
    <script src="<?= base_url('assets/vendors/popper.js/dist/umd/popper.min.js');?>"></script>
    <script src="<?= base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js');?>"></script>
    <script src="<?= base_url('assets/main.js');?>"></script>
</body>
</html>