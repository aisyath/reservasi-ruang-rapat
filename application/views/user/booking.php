<!DOCTYPE html>
<html>
<head>
    <title>Pemesanan</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/core.css');?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/shortcode/shortcodes.css');?>">
    <link rel="stylesheet" href="<?= base_url('assets/style.css');?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/responsive.css');?>">
    <link rel="icon" href="<?=base_url()?>/images/logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
    <style>
        /* Tambahkan CSS sesuai kebutuhan untuk menyesuaikan penataan elemen */
        .single-form-part {
            float: left;
            width: 33.33%;
            padding: 0 15px;
        }
        .single-form-part .date-to {
            margin-bottom: 20px;
        }
        .double-form-part {
            clear: both;
            width: 100%;
            padding: 0 15px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="room-booking ptb-80">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title mb-80 text-center">
                            <h2>Pemesanan <span>Tempat</span></h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="booking-rooms-tab">
                            <ul class="nav" role="tablist">
                                <li class="active"><a href="#booking" data-toggle="tab"><span class="tab-border">1</span><span>Info Pemesanan</span></a></li>
                                <li><a href="#personal" data-toggle="tab"><span class="tab-border">2</span><span>Data Pribadi</span></a></li>
                            </ul>
                        </div>
                        <div class="service-tab-desc text-left mt-60">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="booking">
                                    <div class="booking-info-deatils">
                                        <div class="single-room-details fix">
                                            <div class="room-img">
                                                <img src="<?=base_url()?>/images/kamar/<?=$detail->gambar?>" alt="">
                                            </div>
                                            <div class="single-room-details pl-50">
                                                <h3 class="s_room_title"><?=$detail->jenis?></h3>
                                                <div class="room_price"><br>
                                                    <!-- <h4>Harga</h4><br> -->
                                                   
                                                    <p><?=$detail->detail ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="single-room-booking-form mt-50">
                                            <div class="booking_form_inner">
                                                <div class="single-form-part">
                                                    <div class="date-to mb-20">
                                                        <form action="<?=site_url('Auth/do_booking')?>" method="post">
                                                            <input type="text" readonly name="jenis" value="<?=$detail->jenis?>" class="form-control">
                                                    </div>
                                                    <div class="date-to mb-20">
                                                        <input id="tgl_in" type="date" value="Date" name="tgl_in" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="single-form-part">
                                                    <div class="date-to mb-20">
                                                        <input id="checkin" type="time" value="Time" name="jam_in" class="form-control">
                                                    </div>
                                                    <div class="date-to mb-20">
                                                        <input id="checkout" type="time" value="Time" name="jam_out" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="single-form-part">
                                                    <div class="date-to mb-20">
                                                        <input id="duration" type="text" readonly name="duration" placeholder="Estimasi Waktu" class="form-control">
                                                    </div>
                                                    <div class="date-to mb-20">
                                                        <input id="upload_ktm" type="file" value="Upload KTM" name="upload_ktm" class="form-control">
                                                    </div>
                                                </div>
                                                 <div class="date-to mb-10">
                                                    <input id="alasan_booking" type="text" placeholder="Alasan Booking" name="alasan_booking" class="form-control"> 
                                                </div>
                                                <div class="prve-next-box mt-20">
                                                <div class="back-link">
                                                    <a href="<?= site_url('Welcome')?>">Cancel</a>
                                                    </div>
                                                    <button id="pesan_sekarang" type="submit" disabled">Pesan Sekarang</button>
                                                </div>

                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="personal">
                                <div class="personal-info-details">
                                    <div class="booking-info-inner">
                                        <form action="<?=site_url('Auth/do_booking')?>" method="post">
                                            <div class="single-form-part">
                                                <div class="name mb-15">
                                                    <input type="text" placeholder="Nama Lengkap" value="<?=$this->session->userdata('nama')?>" readonly="" name="nama" class="form-control">
                                                </div>
                                            </div>
                                            <div class="single-form-part">
                                                <div class="mail mb-15">
                                                    <input type="text" placeholder="Email" value="<?=$this->session->userdata('email')?>" readonly="" name="email" class="form-control">
                                                    <i class="mdi mdi-calendar-text"></i>
                                                </div>
                                            </div>
                                            <div class="single-form-part">
                                                <div class="name mb-15">
                                                    <input type="tel" placeholder="No Telp." value="<?=$this->session->userdata('no')?>" readonly="" name="no" class="form-control">
                                                </div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>        
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/bootstrap.min.js');?>"></script>
</body>
</html>
