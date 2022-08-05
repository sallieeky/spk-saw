<?php 
session_start();
include 'dbconnect.php';
?>
<!DOCTYPE html>
<html>
<head>
<title><?=$web['nama']?> - Tentang Kami</title>

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
			<h3 class="w3_agile_header">Tentang Kami</h3>
			<div class="about-agileinfo w3layouts">
				<div class="col-md-12 about-wthree-grids grid-top">
					<h4><?=$web['nama']?> </h4>
					<p class="top" style="text-align: justify;">Adalah Aplikasi Toko kripik dan Kue Kering Online Berbasis Web yang dibangun oleh <?=$author?> yang digunakan untuk sebagai salah satu syarat menempuh Pendidikan di <?=$kampus?>. Aplikasi ini dibangun menggunakan Bahasa Pemrograman PHP dan database MySQL, dan untuk tampilan frontend menggunakan template MarketPlace W3Layouts.</p>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!-- //about -->
<?php include 'layout/footer.php';?>
 
</body>
</html>