<?php
session_start();
include 'dbconnect.php';

if(!isset($_SESSION['log'])){
	header('location:login.php');
} else {
	
};
	$uid = $_SESSION['id'];
	$caricart = mysqli_query($conn,"select * from cart where userid = '$uid' and status='Cart'");
	$fetc = mysqli_fetch_array($caricart);
	$orderidd = $fetc['orderid'];
	$itungtrans = mysqli_query($conn,"select count(detailid) as jumlahtrans from detailorder where orderid='$orderidd'");
	$itungtrans2 = mysqli_fetch_assoc($itungtrans);
	$itungtrans3 = $itungtrans2['jumlahtrans'];
	
if(isset($_POST["checkout"])){
	$alamat 	= $_POST['alamat'];
	$catatan 	= $_POST['catatan'];
	$ongkir 	= $web['ongkir'];
	$q3 = mysqli_query($conn, "update cart set alamat_pengantaran = '$alamat', catatan = '$catatan',ongkir = '$ongkir', status='Waiting' where orderid='$orderidd'");
	if($q3){
		echo "Berhasil Check Out
		<meta http-equiv='refresh' content='1; url= daftarorder.php'/>";
	} else {
		echo "Gagal Check Out
		<meta http-equiv='refresh' content='1; url= checkout.php'/>";
	}
} else {
	
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Checkout - <?=$web['nama']?></title>

<?php include 'layout/header.php';?>

<!-- //navigation -->
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1">
				<li><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Checkout</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- checkout -->
	<div class="checkout">
		<div class="container">
			<h1>Konfirmasi Pemesanan</h1><br>
			<div class="checkout-right">
				<table class="timetable_sub">
					<thead>
						<tr>
							<th>No.</th>	
							<th>Produk</th>
							<th>Nama Produk</th>
							<th>Jumlah</th>
							<th>Sub Total</th>
						</tr>
					</thead>
					
					<?php 
						$brg=mysqli_query($conn,"SELECT * from detailorder d, produk p
												where orderid = '$orderidd' 
												and d.idproduk = p.idproduk 
												order by d.idproduk ASC");
						$no=1;
						while($b=mysqli_fetch_array($brg)){

					?>
					<form action="" method="post">
					<tr class="rem1">
						<td class="invert"><?php echo $no++ ?></td>
						<td class="invert"><a href="product.php?idproduk=<?php echo $b['idproduk'] ?>"><img src="images/produk/<?php echo $b['gambar'] ?>" width="100px" height="100px" /></a></td>
						<td class="invert">
							<?php echo $b['namaproduk'] ?>
						</td>
						<td class="invert">
							 <div class="quantity"> 
								<div class="quantity-select">                     
									<h4><?php echo $b['qty'] ?></h4>
								</div>
							</div>
						</td>
				
						<td class="invert">Rp<?php echo number_format($b['harga']*$b['qty']) ?></td>
						
								<input type="hidden" name="idproduknya" value="<?php echo $b['idproduk'] ?>" \>
							
							</div>
							<script>$(document).ready(function(c) {
								$('.close1').on('click', function(c){
									$('.rem1').fadeOut('slow', function(c){
										$('.rem1').remove();
									});
									});	  
								});
						   </script>
						
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
			<?php if (mysqli_num_rows($brg) > 0) { ?>
			<div class="checkout-left" style="width: 100%">	
				<div style="width: 55%" class="checkout-left-basket">
					<h4>Total Harga</h4>
					<ul>
						<?php 
						$brg = mysqli_query($conn,"SELECT * from detailorder d, produk p
												where orderid = '$orderidd' 
												and d.idproduk = p.idproduk 
												order by d.idproduk ASC");
						$no=1;
						$subtotal = 0;
						while($b=mysqli_fetch_array($brg)){
						$ongkir = $web['ongkir'];
						$hrg = $b['harga'];
						$qtyy = $b['qty'];
						$totalharga = $hrg * $qtyy;
						$subtotal += $totalharga
						?>
						<li><?php echo $b['namaproduk']?> (x<?=$b['qty']?>)<i> <b></i> <span>Rp. <?php echo number_format($totalharga) ?></span></b></li>
						<?php } 
						$total = $subtotal + $ongkir;
						?>
						<li >Ongkos Kirim <b></i> <span>Rp. <?php echo number_format($ongkir) ?></span></b></li>

						<li style="border-top: 0.5px solid grey; font-weight: bold">Grand Total<i> <b></i> <span>Rp. <?php echo number_format($total) ?></span></b></li>
					</ul>
				</div>
				<div style="padding-left: 5%; width: 45%" class="checkout-left-basket">
					<label>Alamat pengantaran</label>
					<textarea class="form-control" style="height: 100px" required="" name="alamat" placeholder="Masukan alamat pengantaran"></textarea><br>
					<label>Catatan pembelian</label>
					<textarea class="form-control" style="height: 100px"  name="catatan" placeholder="Masukan catatan bila ada, misalkan jenis pengiriman JNE,JNT,dll. jika tidak dilampirkan maka kami akan kirim dengan kurir random"></textarea>
				</div>
				<div class="clearfix"> </div>
			</div>
			<?php } ?>
        <hr>
        <p>
        	Setelah anda melakukan checkout pada halaman ini, Selanjutnya ada diharuskan membayar pesanan sejumlah total harga yang tertera dan silahkan lakukan konfirmasi pembayaran dengan mengupload bukti pembayaran pada halaman pemesanan. Jika anda setuju, maka anda bisa menekan tombol chekout dibawah ini. Terima kasih
        </p>
      
		<br>
		
		<center><input type="submit" class=" btn btn-success" name="checkout" value="I Agree and Check Out" \></center>
		</form>
	  
	  </center>
		</div>
	</div>
<!-- //checkout -->
<!-- //footer -->
<?php include 'layout/footer.php'; ?>
</body>
</html>