<?php
session_start();
include 'dbconnect.php';

//jika tidak ada session pengguna atau member di dalam sistem cart, maka lakukan login terlebih dahulu.
if(!isset($_SESSION['log'])){
	header('location:login.php');

} 
//jika ada session pengguna atau member di dalam sistem cart, maka tampil halaman cart..
else {
	
};
	
	$uid = $_SESSION['id'];
	$caricart = mysqli_query($conn,"select * from cart where userid='$uid' and status='Cart'");
	$fetc = mysqli_fetch_array($caricart);
	$orderidd = $fetc['orderid'];
	$itungtrans = mysqli_query($conn,"select count(detailid) as jumlahtrans from detailorder where orderid='$orderidd'");
	$itungtrans2 = mysqli_fetch_assoc($itungtrans);
	$itungtrans3 = $itungtrans2['jumlahtrans'];
	
//jika pengguna ada perubahan pesanan produk di cart yang berdasarkan kode detail cart.	
if(isset($_POST["update"])){
	$kode 	= $_POST['idcart'];
	$jumlah = $_POST['jumlah'];
	$q1 = mysqli_query($conn, "UPDATE detailorder set qty = '$jumlah' where detailid ='$kode' ");

	//jika proses perubahan pesanan produk tanpa kendala, maka muncul kata "Berhasil Update Cart" sebagai bukti bahwa perubahan data tersebut sukses.
	if($q1){
		echo "Berhasil Update Cart
		<meta http-equiv='refresh' content='1; url= cart.php'/>";
	} 
	//jika ada kesalahan pada saat proses perubahan pesanan produk, maka muncul kata "Gagal Update Cart" sebagai bukti bahwa perubahan data tersebut gagal.
	else {
		echo "Gagal update cart
		<meta http-equiv='refresh' content='1; url= cart.php'/>";
	}

//jika pengguna ada menghapus data pesanan produk yang berdasarkan kode detail cart. 
} else if(isset($_POST["hapus"])){
	$kode = $_POST['idcart'];
	$q2 = mysqli_query($conn, "DELETE from detailorder where detailid ='$kode' ");

	//Jika proses penghapusan data cart tanpa kendala, maka muncul kata "Berhasil Hapus" sebagai bukti bahwa penghapusan data tersebut sukses.
	if($q2){
		echo "Berhasil Hapus
		<meta http-equiv='refresh' content='1; url= cart.php'/>";
	//Jika ada kesalahan pada saat penghapusan data cart, maka muncul kata "Gagal Hapus" sebagai bukti bahwa perubahan data tersebut gagal.	
	} else {
		echo "Gagal Hapus
		<meta http-equiv='refresh' content='1; url= cart.php'/>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Keranjang Belanja - <?=$web['nama']?></title>

<?php include 'layout/header.php';?>

<!-- //navigation -->
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1">
				<li><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Keranjang Belanja</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- checkout -->
	<div class="checkout">
		<div class="container">
			<h2>Dalam keranjangmu ada : <span><?php echo $itungtrans3 ?> barang</span></h2>
			<div class="checkout-right">
				<table class="timetable_sub">
					<thead>
						<tr>
							<th>No.</th>	
							<th>Produk</th>
							<th>Nama Produk</th>
							<th>Jumlah</th>
							<th>Harga Satuan</th>
							<th>Opsi</th>
						</tr>
					</thead>
					
					<?php 
					//Menampilkan seluruh data cart yang berdasarkan kode Order (orderid).
					$brg=mysqli_query($conn,"SELECT * from detailorder d, produk p
												where orderid = '$orderidd' 
												and d.idproduk = p.idproduk 
												order by d.idproduk ASC");
					$no=1;
					if (mysqli_num_rows($brg) > 0) {
						while($b=mysqli_fetch_array($brg)){ ?>

					<tr class="rem1"><form method="post">
						<td class="invert"><?php echo $no++ ?></td>
						<td class="invert"><a href="product.php?idproduk=<?php echo $b['idproduk'] ?>"><img src="images/produk/<?php echo $b['gambar'] ?>" width="100px" height="100px" /></a></td>
						<td class="invert">
							<?php echo $b['namaproduk'] ?>
						</td>
						<td class="invert">
							 <div class="quantity"> 
								<div class="quantity-select">                     
									<input type="number" style="text-align: center;" name="jumlah" min="1" max="<?php echo $b['stok'] ?>" class="form-control" height="50px" value="<?php echo $b['qty'] ?>" \>
								</div>
							</div>
						</td>
				
						<td class="invert">Rp<?php echo number_format($b['harga'] * $b['qty']) ?></td>
						<td class="invert">
							<div class="rem">
							
								<input type="submit" name="update" class="btn btn-info btn-sm" value="Update" \>
								<input type="hidden" name="idcart" value="<?php echo $b['detailid'] ?>" \>
								<input style="background-color: red; border-color: red;" type="submit" name="hapus" class="btn btn-danger btn-sm" value="Hapus" \>
							</form>
							</div>
							<script>$(document).ready(function(c) {
								$('.close1').on('click', function(c){
									$('.rem1').fadeOut('slow', function(c){
										$('.rem1').remove();
									});
									});	  
								});
						   </script>
						</td>
					</tr>
						<?php } ?>
					<?php } else { ?>
						<tr style="text-align: center;">
							<td colspan="6">Data tidak ditemukan</td>
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
			<?php 
			//jika pengguna ada belanja produk, maka bisa menekan tombol "Continue Shopping" untuk belanja lagi atau "Checkout" untuk memasuki ke halaman Checkout.
			if (mysqli_num_rows($brg) > 0) { ?>
			<div style="margin-top: 3%" class="checkout-right-basket">
					<a href="index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Continue Shopping</a>
					<a href="checkout.php"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>Checkout</a>
				</div>
			<?php } ?>
		</div>
	</div>
<!-- //checkout -->
<!-- //footer -->
<?php include 'layout/footer.php';?>

</body>
</html>