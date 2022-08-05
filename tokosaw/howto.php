<?php 
session_start();
include 'dbconnect.php';
?>
<!DOCTYPE html>
<html>
<head>
<title><?=$web['nama']?> - Panduan</title>

<?php include 'layout/header.php';?>

<!-- //navigation -->
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">About</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- about -->
	<div class="about">
		<div class="container">
			<h3 class="w3_agile_header">Panduan berbelanja</h3>
			<div class="about-agileinfo w3layouts">
				<div class="col-md-2 about-wthree-grids grid-top">
				</div>
				<div class="col-md-8 about-wthree-grids grid-top">
					<ol>
						<li>Pelanggan login / daftar</li>
						<li>Pelanggan memilih produk yang akan dibeli</li>
						<li>Pelanggan melakukan checkout belanjaan</li>
						<li>Pelanggan melakukan pembayaran </li>
						<li>Admin akan memproses pesanan, serta menirimkan pesanan, dan mengupdate resi pengiriman</li>
						<li>Pelanggan yang sudah menerima pesanan bisa menyelesaikan pesanan pada menu daftar orderan</li>
					</ol>
				</div>
				<div class="col-md-2 about-wthree-grids grid-top">
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!-- //about -->
<?php include 'layout/footer.php';?>
 
</body>
</html>