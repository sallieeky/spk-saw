<?php
session_start();
include 'dbconnect.php';

if(!isset($_SESSION['log'])){
	header('location:login.php');
} else {
	
};
	
	$uid = $_SESSION['id'];
	$caricart = mysqli_query($conn,"select * from cart where userid='$uid' and status='Cart'");
	$fetc = mysqli_fetch_array($caricart);
	$orderidd = $fetc['orderid'];
	$itungtrans = mysqli_query($conn,"select count(orderid) as jumlahtrans from cart where userid='$uid' and status!='Cart'");
	$itungtrans2 = mysqli_fetch_assoc($itungtrans);
	$itungtrans3 = $itungtrans2['jumlahtrans'];
	
if(isset($_POST["update"])){
	$kode = $_POST['idproduknya'];
	$jumlah = $_POST['jumlah'];
	$q1 = mysqli_query($conn, "update detailorder set qty='$jumlah' where idproduk='$kode' and orderid='$orderidd'");
	if($q1){
		echo "Berhasil Update Cart
		<meta http-equiv='refresh' content='1; url= cart.php'/>";
	} else {
		echo "Gagal update cart
		<meta http-equiv='refresh' content='1; url= cart.php'/>";
	} 
} else if(isset($_POST["hapus"])){
	$kode = $_POST['idproduknya'];
	$q2 = mysqli_query($conn, "delete from detailorder where idproduk='$kode' and orderid='$orderidd'");
	if($q2){
		echo "Berhasil Hapus";
	} else {
		echo "Gagal Hapus";
	}
}

if (isset($_GET['aksi']) and $_GET['aksi'] == 'gagal') {
	$idnya = $_GET['id'];
	mysqli_query($conn, "delete from detailorder where orderid='$idnya'");
	mysqli_query($conn, "delete from cart where orderid='$idnya'");
	echo "Berhasil membatalkan pesanan
		<meta http-equiv='refresh' content='1; url= daftarorder.php'/>";
}

if (isset($_GET['aksi']) and $_GET['aksi'] == 'selesai') {
	$id = $_GET['id'];
	$listbrg 		= mysqli_query($conn,"SELECT p.idproduk, d.qty, p.stok from detailorder d, produk p where orderid = '$id' and d.idproduk = p.idproduk ");
	//update stok barang
	while ($brg = mysqli_fetch_object($listbrg)) {
		$stoknew = $brg->stok - $brg->qty;
		mysqli_query($conn," UPDATE produk SET stok = '$stoknew' where idproduk = '$brg->idproduk' ");
	}

	$updatestatus = mysqli_query($conn,"update cart set status = 'Selesai' where orderid = '$id'");
	
	if($updatestatus){
		echo "<script>
			alert('Berhasil mengubah status pesanan');
	        window.location.href='daftarorder.php';
	      </script>";
	} else {
		echo "<script>
			alert('Gagagl, Silahkan coba lagi');
	       	window.location.href='daftarorder.php';
	      </script>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Daftar Belanja - <?=$web['nama']?></title>

<?php include 'layout/header.php';?>

<!-- //navigation -->
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1">
				<li><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Daftar Order</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- checkout -->
	<div class="checkout">
		<div class="container">
			<h2>Kamu memiliki <span><?php echo $itungtrans3 ?> transaksi</span></h2>
			<div class="checkout-right">
				<table class="timetable_sub">
					<thead>
						<tr>
							<th>No.</th>	
							<th>Kode Order</th>
							<th>Tanggal Order</th>
							<th>Total</th>
							<th>Status</th>
						</tr>
					</thead>
					
					<?php 
					if ($itungtrans3 > 0) {
						$brg=mysqli_query($conn,"SELECT DISTINCT(idcart), c.orderid, tglorder, status, ongkir from cart c, detailorder d where c.userid='$uid' and d.orderid=c.orderid and status!='Cart' order by tglorder DESC");
						$no=1;
						while($b=mysqli_fetch_array($brg)){

					?>
					<tr class="rem1"><form method="post">
						<td class="invert"><?php echo $no++ ?></td>
						<td class="invert"><a href="order.php?id=<?php echo $b['orderid'] ?>"><?php echo $b['orderid'] ?></a></td>
						
						<td class="invert"><?php echo date('H:i:s, d-m-Y',strtotime($b['tglorder'])) ?></td>
						<td class="invert">
						
						Rp.
						<?php 				
						$ordid 		= $b['orderid'];
						$result1 	= mysqli_query($conn,"SELECT SUM(qty*harga) AS count FROM detailorder d, produk p where d.orderid = '$ordid' and p.idproduk=d.idproduk order by d.idproduk ASC");
						$cekrow 	= mysqli_num_rows($result1);
						$row1 = mysqli_fetch_assoc($result1);
						$count = $row1['count'];
						if($cekrow > 0){
							echo number_format($count + $b['ongkir']);
						} else {
							echo 'No data';
						}?>
						
						</td>
				
						<td class="invert">
							<?php 
							if($b['status'] == 'Waiting' ){ 
							echo ' <a href="konfirmasi.php?id='.$b['orderid'].'" class="btn btn-primary"> Konfirmasi Pembayaran </a> ';
							?>
							<a onclick="return confirm('apakah anda yakin tidak ingin meneruskan pesanan ini ?')" href="daftarorder.php?aksi=gagal&id=<?=$b['orderid']?>" class="btn btn-danger" > Batalkan </a>
							<?php
							} 
							elseif ($b['status'] == 'Pengiriman') { ?>

							 	<a onclick="return confirm('apakah anda yakin sudah menerima pesanan tersebut ?')" href="daftarorder.php?aksi=selesai&id=<?=$b['orderid']?>" class="btn btn-info btn-sm" > Selesaikan </a>
							 
							<?php }
							 else 
							{ echo $b['status']; } ?>  
						</td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="5">Data tidak ditemukan</td>
					</tr>
					<?php } ?>
					
					<!--quantity-->
						<script>
						$('.value-plus').on('click', function(){
							var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10)+1;
							divUpd.text(newVal);
						});

						$('.value-minus').on('click', function(){
							var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10)-1;
							if(newVal>=1) divUpd.text(newVal);
						});
						</script>
					<!--quantity-->
				</table>
			</div>
		</div>
	</div>
<!-- //checkout -->
<!-- //footer -->
<?php include 'layout/footer.php';?>

</body>
</html>