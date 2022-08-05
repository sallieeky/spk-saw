<?php
session_start();
if(!isset($_SESSION['log'])){
	header('location:login.php');
} else {
	
};

$idorder = $_GET['id'];

include 'dbconnect.php';

if(isset($_POST['confirm']))
	{
		
		$userid 		= $_SESSION['id'];
		$veriforderid 	= mysqli_query($conn,"select * from cart where orderid='$idorder'");
		$fetch 			= mysqli_fetch_array($veriforderid);
		$liat 			= mysqli_num_rows($veriforderid);
		
		//cek apakah transaksi dengan kode order tsb ada atau tidak
		if( $fetch>0 ){

			$nama 		= $_POST['nama'];
			$metode 	= $_POST['metode'];
			$tanggal 	= $_POST['tanggal'];

			$namaFile 	= $_FILES['berkas']['name']; //nama file yang diupload
			$temp 		= $_FILES['berkas']['tmp_name']; //nama sementara

			$dirUpload 	= "./images/bukti/"; // tentukan lokasi file akan dipindahkan
			$terupload 	= move_uploaded_file($temp, $dirUpload.$namaFile); //proses upload file

			if (!$terupload) {
			    echo "<script>
						alert('Ops bukti gagal diuoload, silahkan ulangi lagi');
				        window.location.href='konfirmasi.php?id=".$idorder."';
				      </script>";
			}
				  
			$kon = mysqli_query($conn,"insert into konfirmasi (orderid, userid, payment, namarekening, tglbayar, bukti) 
			values('$idorder','$userid','$metode','$nama','$tanggal','$namaFile')");
			if ($kon){
			
				$up = mysqli_query($conn,"update cart set status = 'Confirmed' where orderid='$idorder'");
				echo "<script>
						alert('Terima kasih telah melakukan konfirmasi, team kami akan melakukan verifikasi.');
				        window.location.href='daftarorder.php';
				      </script>";
			} else { 
					echo "<script>
						alert('Ops ada kesalahan, silahkan ulangi lagi');
				        window.location.href='konfirmasi.php';
				      </script>";
			}
		} else {
			echo "<script>
				alert('Ops kode order tidak ditemukan, silahkan ulangi lagi');
		        window.location.href='konfirmasi.php';
		      </script>";
		}
		
		
	};

?>

<!DOCTYPE html>
<html>
<head>
<title><?=$web['nama']?> - Konfirmasi Pembayaran</title>

<?php include 'layout/header.php'; ?>
		
<!-- //navigation -->
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Konfirmasi</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- register -->
	<div class="register">
		<div class="container">
			<h2>Konfirmasi</h2>

			<div class="login-form-grids">

				
				<div class="panel-group" id="accordion">
				  <div class="panel panel-default">
				    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
				        Daftar Bank Pembayaran</a>
				      </h4>
				    </div>
				    <div id="collapse1" class="panel-collapse collapse">
				      	<div class="panel-body">
					      	<ol style="padding-left:15px">
					      		<?php $sql = mysqli_query($conn,"select * from pembayaran");
					      		while ($s = mysqli_fetch_object($sql)) { ?>
					      	    <li><?=$s->metode?> ( <?=$s->norek?> ) a.n <?=$s->an?></li>
					      		<?php } ?>
					      	</ol>
				  		</div>
				    </div>
				  </div>
				</div>
				<hr>
				<form method="post" enctype="multipart/form-data">
				<h3>Kode Order</h3>
				<br>
				<strong>
					<input type="text" name="orderid" value="<?php echo $idorder ?>" disabled>
				</strong>
				<!------>
				<h6>Informasi Pembayaran</h6>
				<input type="text" name="nama" placeholder="Nama Pemilik Rekening / Sumber Dana" required>
				<!------>	
				<h6>Rekening Tujuan</h6>
				<select name="metode" class="form-control">	
					<option value="" selected="" disabled="">--Pilih Rekening Tujuan--</option>
					<?php $metode = mysqli_query($conn,"select * from pembayaran");
					while($a=mysqli_fetch_array($metode)){ ?>
						<option value="<?php echo $a['metode'] ?>"><?php echo $a['metode'] ?> | <?php echo $a['norek'] ?></option>
					<?php }; ?>
					
				</select>
				<!------>	
				<h6>Tanggal Bayar</h6>
				<input type="date" class="form-control" name="tanggal">
				<!------>
				<h6>Bukti Pembayaran</h6>
				<input type="file" class="form-control" name="berkas">
				<!------>
				<input type="submit" name="confirm" value="Kirim">
				</form>
			</div>
			<div class="register-home">
				
				<a href="daftarorder.php">Batal</a>
			</div>
		</div>
	</div>


<!-- //register -->
<!-- //footer -->
<?php include 'layout/footer.php'; ?> 
</body>
</html>