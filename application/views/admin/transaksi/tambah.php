<!DOCTYPE html>
<html>
<head>
    <title>Tambah Transaksi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css');?>">
    <link rel="icon" href="<?=base_url()?>/images/logo.png">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css');?>">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script language="javascript">
        $(document).ready(function () {
            function validateForm() {
                var tglIn = $('#tgl_in').val();
                var jamIn = $('#checkin').val();
                var jamOut = $('#checkout').val();
                var uploadKtm = $('#upload_ktm').val();
                var alasanBooking = $('#alasan_booking').val();

                if (tglIn && jamIn && jamOut && uploadKtm && alasanBooking) {
                    $('#pesan_sekarang').prop('disabled', false);
                } else {
                    $('#pesan_sekarang').prop('disabled', true);
                }
            }

            $("#tgl_in, #checkin, #checkout, #upload_ktm, #alasan_booking").on('change', validateForm);

            function calculateDuration() {
                var jamIn = $('#checkin').val();
                var jamOut = $('#checkout').val();
                if (jamIn && jamOut) {
                    var timeIn = new Date("01/01/2000 " + jamIn);
                    var timeOut = new Date("01/01/2000 " + jamOut);
                    var diff = (timeOut - timeIn) / (1000 * 60); // Difference in minutes
                    if (diff < 0) {
                        diff += 24 * 60; // Handle overnight case
                    }
                    var hours = Math.floor(diff / 60);
                    var minutes = diff % 60;

                    // Menghitung total menit
                    var totalMinutes = hours * 60 + minutes;

                    // Validasi rentang waktu
                    if (totalMinutes < 60 || totalMinutes > 180) {
                        alert("Estimasi waktu minimal 1 jam dan maksimal 3 jam.");
                        $('#checkin, #checkout').val('');
                        $('#duration').val('');
                    } else {
                        // Konversi total menit ke jam dan menit
                        var durationHours = Math.floor(totalMinutes / 60);
                        var durationMinutes = totalMinutes % 60;

                        $('#duration').val(durationHours + " jam " + durationMinutes + " menit");
                    }

                }
                validateForm();
            }

            $('#checkin, #checkout').on('change', calculateDuration);

            $('#pesan_sekarang').on('click', function(event) {
                var tglIn = $('#tgl_in').val();
                var jamIn = $('#checkin').val();
                var jamOut = $('#checkout').val();
                if (!tglIn || !jamIn || !jamOut) {
                    alert("Silakan tentukan tanggal dan waktu pemesanan.");
                    event.preventDefault(); // Mencegah pengiriman formulir jika data tidak lengkap
                }
            });

            // Initial form validation
            validateForm();

            // Set minimum date to today for tgl_in
            var today = new Date().toISOString().split('T')[0];
            $('#tgl_in').attr('min', today);

            // Disable past time for checkin and limit booking to one hour before
            function disablePastTime() {
                var tglIn = $('#tgl_in').val();
                var checkin = $('#checkin');
                if (tglIn) {
                    var currentTime = new Date();
                    var selectedDate = new Date(tglIn);

                    if (selectedDate.toDateString() === currentTime.toDateString()) {
                        // If selected date is today, set the minimum time for checkin
                        var minCheckinTime = new Date(currentTime.getTime() + 60 * 60 * 1000);
                        var hours = String(minCheckinTime.getHours()).padStart(2, '0');
                        var minutes = String(minCheckinTime.getMinutes()).padStart(2, '0');
                        checkin.attr('min', hours + ':' + minutes);
                    } else {
                        checkin.removeAttr('min');
                    }
                } else {
                    checkin.removeAttr('min');
                }
            }

            $('#tgl_in').on('change', function () {
                disablePastTime();
                $('#checkin').val('');
            });

            function validateTime() {
                var checkin = $('#checkin').val();
                var tglIn = $('#tgl_in').val();
                var currentTime = new Date();
                var selectedDate = new Date(tglIn);
                var minCheckinTime = new Date(currentTime.getTime() + 60 * 60 * 1000);

                if (tglIn && checkin && selectedDate.toDateString() === currentTime.toDateString()) {
                    var selectedTime = new Date("01/01/2000 " + checkin);
                    var minTime = new Date("01/01/2000 " + minCheckinTime.toTimeString().substr(0, 5));

                    if (selectedTime < minTime) {
                        alert("Waktu check-in tidak boleh kurang dari satu jam dari sekarang.");
                        $('#checkin').val('');
                    }
                }
            }

            $('#checkin').on('change', validateTime);

            disablePastTime();
        });
    </script>
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
                        <div class="form-inline"></div>
                        <div class="dropdown for-message"></div>
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
                        <h1>Tambah Transaksi</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="<?=site_url('Welcome/index')?>">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

       <!--  -->
       <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                        <form action="<?=site_url('Transaksi/tambah')?>" method="post" novalidate="novalidate">
                                            <input type="hidden" name="status" value="Confirm">
                                                <div class="form-group has-success">
                                                    <label for="cc-name" class="control-label mb-1">Nama Lengkap</label>
                                                    <input id="cc-name" name="nama" type="text" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="cc-number" class="control-label mb-1">Email</label>
                                                    <input id="cc-number" name="email" type="tel" class="form-control" >
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="cc-exp" class="control-label mb-1">Password</label>
                                                            <input id="cc-exp" name="no" type="tel" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="cc-exp" class="control-label mb-1">Tempat Booking</label>
                                                            <select id="cc-exp" name="jenis" class="form-control ">
                                                                <?php foreach ($result as $kmr) { ?>
                                                                    <option><?= $kmr->jenis ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="cc-exp" class="control-label mb-1">Tanggal</label>
                                                            <input id="tgl_in" type="date" value="Date" name="tgl_in" class="form-control">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="cc-exp" class="control-label mb-1">Jam Mulai</label>
                                                            <input id="checkin" type="time" value="Time" name="jam_in" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="cc-exp" class="control-label mb-1">Jam Akhir</label>
                                                            <input id="checkout" type="time" value="Time" name="jam_out" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="cc-exp" class="control-label mb-1">Estimasi Waktu</label>
                                                            <input id="duration" type="text" readonly name="duration" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="cc-exp" class="control-label mb-1">Upload KTM</label>
                                                            <input id="upload_ktm" type="file" value="Upload KTM" name="upload_ktm" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="form-group">
                                                            <label for="cc-exp" class="control-label mb-1">Alasan Booking</label>
                                                            <input id="alasan_booking" type="text" name="alasan_booking" class="form-control"> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                     <input name="simpan" id="payment-button" type="submit" class="btn btn-lg btn-info btn-block" value="Simpan">
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- .card -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/vendors/popper.js/dist/umd/popper.min.js');?>"></script>
    <script src="<?= base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js');?>"></script>
    <script src="<?= base_url('assets/main.js');?>"></script>
</body>
</html>

