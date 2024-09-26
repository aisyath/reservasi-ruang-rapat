<h2>Confirm Transaksi</h2>
<p>Are you sure you want to confirm transaksi #<?=$id?>?</p>
<form action="<?=site_url('Transaksi/confirm/'.$id)?>" method="post">
    <input type="submit" value="Confirm">
</form>