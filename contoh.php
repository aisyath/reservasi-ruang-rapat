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
                            <h2>Konfirmasi <span>Pemesanan</span></h2>
                            <div class="toast">
                                <div class="toast-body">
                                   <p><?=$this->session->flashdata('msg');?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="booking-rooms-tab">
                            <ul class="nav" role="tablist">
                                <li class="active"><a href="#done" data-toggle="tab"><span class="tab-border">1</span><span>Konfirmasi</span></a></li>
                                <li><a href="#payment" data-toggle="tab"><span class="tab-border">2</span><span>Status Pemesanan</span></a></li>
                            </ul>
                        </div>
                        <div class="service-tab-desc text-left mt-60">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="done">
                                    <div class="booking-done">
                                        <div class="booking-done-table table-responsive text-center" style="width: 100%;">
                                            <div class="text-right"><a href="<?= site_url('Welcome/index')?>" class="btn btn-primary">Kembali ke Beranda</a></div><br><br>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Kamar</th>
                                                        <th>Tanggal</th>
                                                        <th>Nama</th>
                                                        <th>Email</th>
                                                        <th>No Telepon</th>
                                                        <th>Jenis</th>
                                                        <th>Harga</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $nama = $this->session->userdata('nama'); // Assuming the user's name is stored in session with key 'nama'
                                                        $this->db->select('transaksi.*, kamar.harga');
                                                        $this->db->from('transaksi');
                                                        $this->db->join('kamar', 'transaksi.jenis = kamar.jenis');
                                                        $this->db->where('transaksi.nama', $nama);
                                                        $query = $this->db->get();
                                                        $trans = $query->result();
                                                    ?>
                                                    <?php if ($trans): ?>
                                                        <?php foreach ($trans as $t): ?>
                                                            <tr>
                                                                <td>1 Kamar</td>
                                                                <td><?=$t->tgl_in?> - <?=$t->tgl_out?></td>
                                                                <td><?=$t->nama?></td>
                                                                <td><?=$t->email?></td>
                                                                <td><?=$t->no?></td>
                                                                <td><?=$t->jenis?></td>
                                                                <td><?=$t->harga?></td>
                                                                <td><?=$t->harga?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="8">Belum ada data transaksi.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="payment">
                                    <div class="booking-payment">
                                        <div class="payment">
                                            <div class="payment-table table-responsive text-center" style="width: 100%;">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Kamar</th>
                                                            <th>Tanggal</th>
                                                            <th>Nama</th>
                                                            <th>Email</th>
                                                            <th>No Telepon</th>
                                                            <th>Jenis</th>
                                                            <th>Harga</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if ($trans): ?>
                                                            <?php foreach ($trans as $t): ?>
                                                                <tr>
                                                                    <td>1 Kamar</td>
                                                                    <td><?=$t->tgl_in?> - <?=$t->tgl_out?></td>
                                                                    <td><?=$t->nama?></td>
                                                                    <td><?=$t->email?></td>
                                                                    <td><?=$t->no?></td>
                                                                    <td><?=$t->jenis?></td>
                                                                    <td><?=$t->harga?></td>
                                                                    <td>
                                                                        <?php
                                                                            $statusClass = $t->status == 'proses' ? 'btn-warning' :
                                                                                        ($t->status == 'konfirmasi' ? 'btn-info' :
                                                                                        ($t->status == 'selesai' ? 'btn-success' :
                                                                                        ($t->status == 'batal' ? 'btn-danger' : 'btn-secondary')));
                                                                        ?>
                                                                        <a href="<?=site_url('Auth/konfirmasi')?>" class="btn <?=$statusClass?>"><?=ucfirst($t->status)?></a>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="8">Belum ada data transaksi.</td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                                <div class="text-right"><a href="<?= site_url('Welcome/index')?>" class="btn btn-primary">Kembali ke Beranda</a></div>
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
</body>
</html>
