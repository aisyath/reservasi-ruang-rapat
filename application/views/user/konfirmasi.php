<!DOCTYPE html>
<html>
<head>
    <title>Pemesanan</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/core.css');?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/shortcode/shortcodes.css');?>">
    <link rel="stylesheet" href="<?= base_url('assets/style.css');?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/responsive.css');?>">
    <link rel="icon" href="<?= base_url('images/logo.png'); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script language="javascript">
        $(document).ready(function () {
            $("#txtCheckin").datepicker({
                minDate: 0,
                dateFormat: "dd-M-yy",
                onSelect: function (date) {
                    var date2 = $('#txtCheckin').datepicker('getDate');
                    date2.setDate(date2.getDate());
                    $('#txtCheckout').datepicker('setDate', date2);
                    $('#txtCheckout').datepicker('option', 'minDate', date2);
                }
            });
            $('#txtCheckout').datepicker({
                minDate: 0,
                dateFormat: "dd-M-yy",
                onClose: function () {
                    var dt1 = $('#txtCheckin').datepicker('getDate');
                    console.log(dt1);
                    var dt2 = $('#txtCheckout').datepicker('getDate');
                    if (dt2 <= dt1) {
                        var minDate = $('#txtCheckout').datepicker('option', 'minDate');
                        $('#txtCheckout').datepicker('setDate', minDate);
                    }
                }
            });

            // Activate the "Status Pemesanan" tab on page load
            $('a[href="#payment"]').tab('show');

            // Set timer for reminder message
            setTimeout(function() {
                alert("Reminder: Jika 15 menit setelah waktu cek in tempat tidak ditempati maka itu diluar tanggung jawab kami.");
            }, 15 * 60 * 1000); // 15 minutes in milliseconds
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="room-booking ptb-80">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title mb-80 text-center">
                            <h2>Status <span>Pemesanan</span></h2>
                            <div class="toast">
                                <div class="toast-body">
                                    <p><?= $this->session->flashdata('msg'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="booking-rooms-tab">
                            <ul class="nav" role="tablist">
                                <li class="active"><a href="#payment" data-toggle="tab"><span class="tab-border">1</span><span>Status Pemesanan</span></a></li>
                                <li><a href="#daftar" data-toggle="tab"><span class="tab-border">2</span><span>Daftar Antrian</span></a></li>
                            </ul>
                        </div>
                        <div class="service-tab-desc text-left mt-60">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="payment">
                                    <div class="booking-payment">
                                        <div class="payment-table table-responsive text-center" style="width: 100%;">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Tempat</th>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Jam</th>
                                                        <th scope="col">Estimasi Waktu</th>
                                                        <th scope="col">Nama</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Foto KTM</th>
                                                        <th scope="col">Alasan Booking</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    // Memanggil metode mark_expired di Transaksi_model untuk menandai pemesanan yang kadaluarsa
                                                    $this->load->model('Transaksi_model');
                                                    $this->Transaksi_model->mark_expired();

                                                    $nama = $this->session->userdata('nama'); // Assuming the user's name is stored in session with key 'nama'
                                                    $this->db->select('transaksi.*, kamar.harga');
                                                    $this->db->from('transaksi');
                                                    $this->db->join('kamar', 'transaksi.jenis = kamar.jenis');
                                                    $this->db->where('transaksi.nama', $nama);
                                                    $this->db->where('transaksi.status !=', 'expired'); // Exclude expired bookings
                                                    $query = $this->db->get();
                                                    $trans = $query->result();
                                                ?>
                                                <?php if ($trans): ?>
                                                    <?php foreach ($trans as $t): ?>
                                                        <tr>
                                                            <td><?= $t->jenis ?></td>
                                                            <td><?= $t->tgl_in ?></td>
                                                            <td><?= $t->jam_in ?> - <?= $t->jam_out ?></td>
                                                            <td><?= $t->duration ?></td>
                                                            <td><?= $t->nama ?></td>
                                                            <td><?= $t->email ?></td>
                                                            <td><?= $t->upload_ktm ?></td>
                                                            <td><?= $t->alasan_booking ?></td>
                                                            <td>
                                                                <?php if (isset($t->status)): ?>
                                                                    <?php
                                                                        $statusClass = $t->status == 'proses' ? 'btn-warning' :
                                                                                        ($t->status == 'konfirmasi' ? 'btn-info' :
                                                                                        ($t->status == 'selesai' ? 'btn-success' :
                                                                                        ($t->status == 'batal' ? 'btn-danger' : 'btn-secondary')));
                                                                    ?>
                                                                    <a href="<?= site_url('Auth/konfirmasi') ?>" class="btn <?= $statusClass ?>"><?= ucfirst($t->status) ?></a>
                                                                <?php else: ?>
                                                                    <span class="btn btn-secondary">Pending</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="10">Belum ada data transaksi.</td>
                                                    </tr>
                                                <?php endif; ?>
                                                </tbody>
                                            </table>
                                            <div class="text-right">
                                                <a href="<?= site_url('Welcome/index') ?>" class="btn btn-primary">Kembali ke Beranda</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="daftar">
                                    <div class="booking-payment">
                                        <div class="payment-table table-responsive text-center" style="width: 100%;">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Tempat</th>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Jam</th>
                                                        <th scope="col">Estimasi Waktu</th>
                                                        <th scope="col">Nama</th>
                                                        <th scope="col">Alasan Booking</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    // Memanggil metode mark_expired di Transaksi_model untuk menandai pemesanan yang kadaluarsa
                                                    $this->Transaksi_model->mark_expired();

                                                    $nama = $this->session->userdata('nama'); // Assuming the user's name is stored in session with key 'nama'
                                                    $this->db->select('transaksi.*, kamar.harga');
                                                    $this->db->from('transaksi');
                                                    $this->db->join('kamar', 'transaksi.jenis = kamar.jenis');
                                                    $this->db->where('transaksi.status', 'Confirm');
                                                    $this->db->where('transaksi.status !=', 'expired'); // Exclude expired bookings
                                                    $this->db->order_by('transaksi.tgl_in', 'ASC');
                                                    $query = $this->db->get();
                                                    $trans = $query->result();
                                                ?>
                                                <?php if ($trans): ?>
                                                    <?php foreach ($trans as $a): ?>
                                                        <tr>
                                                            <td><?= $a->jenis ?></td>
                                                            <td><?= $a->tgl_in ?></td>
                                                            <td><?= $a->jam_in ?> - <?= $a->jam_out ?></td>
                                                            <td><?= $a->duration ?></td>
                                                            <td><?= $a->nama ?></td>
                                                            <td><?= $a->alasan_booking ?></td>
                                                            <td>
                                                                <?php if (isset($a->status)): ?>
                                                                    <?php
                                                                        $statusClass = $a->status == 'proses' ? 'btn-warning' :
                                                                                        ($a->status == 'konfirmasi' ? 'btn-info' :
                                                                                        ($a->status == 'selesai' ? 'btn-success' :
                                                                                        ($a->status == 'batal' ? 'btn-danger' : 'btn-secondary')));
                                                                    ?>
                                                                    <a href="<?= site_url('Auth/konfirmasi') ?>" class="btn <?= $statusClass ?>"><?= ucfirst($a->status) ?></a>
                                                                <?php else: ?>
                                                                    <span class="btn btn-secondary">Pending</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="7">Belum ada data antrian.</td>
                                                    </tr>
                                                <?php endif; ?>
                                                </tbody>
                                            </table>
                                            <div class="text-right">
                                                <a href="<?= site_url('Welcome/index') ?>" class="btn btn-primary">Kembali ke Beranda</a>
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
    </div>
    <script src="<?= base_url('assets/js/bootstrap.min.js');?>"></script>
</body>
</html>
