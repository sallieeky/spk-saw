<?php
session_start();
include 'dbconnect.php';

if(!isset($_SESSION['log'])){
	header('location:login.php');
} else {
	
};

$idorder = $_GET['id'];
	
$uid = $_SESSION['id'];
$caricart = mysqli_query($conn,"select * from cart where userid='$uid' and status='Cart'");
$fetc = mysqli_fetch_array($caricart);
$orderidd = $fetc['orderid'];
$itungtrans = mysqli_query($conn,"select count(detailid) as jumlahtrans from detailorder where orderid='$orderidd'");
$itungtrans2 = mysqli_fetch_assoc($itungtrans);
$itungtrans3 = $itungtrans2['jumlahtrans'];

$info = mysqli_query($conn,"select * from cart where orderid = '$idorder' "); 
$data = mysqli_fetch_array($info);
?>
<!DOCTYPE html>
<html>
<head>
<title><?=$web['nama']?> - Detail Order</title>
<?php include 'layout/header.php';?>
<!-- //navigation -->
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1">
				<li><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Detail Order</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- checkout -->
	<div class="checkout">
		<div class="container">
			<h2>Detail Order <?=$idorder?></h2>
			<div class="checkout-right">
				<table class="timetable_sub">
					<thead>
						<tr>
							<th>No.</th>	
							<th>Produk</th>
							<th>Nama Produk</th>
							<th>Jumlah</th>
							<th>Harga Satuan</th>
							<th width="150px">Rating</th>
						</tr>
					</thead>
					
					<?php 
						$brg=mysqli_query($conn,"SELECT * from detailorder d, produk p
												where orderid = '$idorder' 
												and d.idproduk = p.idproduk 
												order by d.idproduk ASC");
						$no=1;
						while($b=mysqli_fetch_array($brg)){
						$detail = $b['detailid'];
						$rating = mysqli_fetch_object(mysqli_query($conn," SELECT * FROM rating where rating_detailorder = '$detail' "));
					?>
					<tr class="rem1"><form method="post">
						<td class="invert"><?php echo $no++ ?></td>
						<td class="invert"><a href="product.php?idproduk=<?php echo $b['idproduk'] ?>"><img src="images/produk/<?php echo $b['gambar'] ?>" width="100px" height="100px" /></a></td>
						<td class="invert">
							<?php echo $b['namaproduk'] ?>
						</td>
						<td class="invert"><?php echo $b['qty'] ?> Pcs</td>
				
						<td class="invert">Rp. <?php echo number_format($b['harga']) ?></td>
						<td>
							<?php if ($data['status'] == 'Selesai') { ?>
							<select name="rating" id="rating" class="form-control" style="text-align:center; ">
								<option value="">-- Rating --</option>
								<?php for ($i=1; $i <= 5 ; $i++) { ?>
									<option <?=!empty($rating) && $rating->rating == $i ? 'selected':''?> value="<?=$i?>-<?=$b['detailid']?>"><?=$i?></option>
								<?php } ?>
							</select>
							<?php } ?>
						</td>
						
					</tr>
					<?php } ?>
				</table>
			</div>
			<div class="checkout-left" style="width: 100%">	
				<div style="width: 55%" class="checkout-left-basket">
					<h4>Total Harga</h4>
					<ul>
						<?php 
						$brg = mysqli_query($conn,"SELECT * from detailorder d, produk p
												where orderid = '$idorder' 
												and d.idproduk = p.idproduk 
												order by d.idproduk ASC");
						$no=1;
						$subtotal = 0;
						while($b=mysqli_fetch_array($brg)){
						$hrg = $b['harga'];
						$qtyy = $b['qty'];
						$totalharga = $hrg * $qtyy;
						$subtotal += $totalharga
						?>
						<li><?php echo $b['namaproduk']?> (x<?=$b['qty']?>)<i> <b></i> <span>Rp. <?php echo number_format($totalharga) ?></span></b></li>
						<?php } ?>
						<li>Ongkos Kirim <b></i> <span><?php echo 'Rp. '.number_format($data['ongkir']); ?></span></b></li>
						<hr/>
						<li>Grand Total<i> <b></i> <span>Rp. <?php echo number_format($subtotal + $data['ongkir']) ?></span></b></li>
					</ul>
				</div>
				<?php 
				
				?>
				<div style="padding-left: 5%; width: 45%" class="checkout-left-basket">
					<label>Alamat pengantaran</label><br>
					<?=$data['alamat_pengantaran']?><br><br>
					<label>Catatan pembelian</label><br>
					<?=$data['catatan']?><br><br>
					<?php if ($data['status'] == 'Pengiriman') { ?>

					<label>Ekspedisi Pegiriman</label><br>
					<?=$data['jenis_pengiriman']?><br><br>

					<label>Resi Pegiriman</label><br>
					<?=$data['resi']?><br><br>

					<?php } ?>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
<!-- //checkout -->
<!-- //footer -->
<?php include 'layout/footer.php';?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script>
$(function () {
    $("#rating").on("change", function () {
    var rat 	= $("#rating").val();
    	$.ajax({
		   type: "POST",
		   url: 'dbconnect.php?aksi=saverating',
		   data : { 'rating':rat },
		   success: function(data){
		    alert('Rating berhasil disimpan');
		   },
		   error: function(xhr, status, error){
		    alert(xhr);
		   }
	  	});
    });
});
</script>
</body>
</html>