<?php
session_start();

include 'dbconnect.php';

$id 		= $_SESSION['id'];
$queryuser 	= mysqli_query($conn,"SELECT * FROM login WHERE userid = '$id'");
$user 		= mysqli_fetch_assoc($queryuser);
//jika ada perubahan data profil pelanggan yang sedang aktif di sistem ini.
if(isset($_POST['update'])){
	$id = $_POST['id'];
	$nama = $_POST['nama'];
	$telp = $_POST['telp'];
	$alamat = $_POST['alamat'];
	$email = $_POST['email'];
	//jika ada update kata sandi (password).
	if($_POST['pass'] != ''){ 
		$pass = md5($_POST['pass']); 
		$sql = " UPDATE login set namalengkap = '$nama', notelp = '$telp', alamat = '$alamat', email = '$email', password = '$pass' where userid = '$id' ";
	}
	//jika tidak ada update kata sandi (password).
	else
	{
		$sql = " UPDATE login set namalengkap = '$nama', notelp = '$telp', alamat = '$alamat', email = '$email' where userid = '$id' ";
	}

	$aksi = mysqli_query($conn,$sql);
	//jika tidak ada kesalahan error pada saat proses perubahan profil, maka update profil telah sukses.
	if ($aksi) {
		echo "<script>
			alert('Update profile berhasil');
	        window.location.href='profile.php';
	      </script>";
	}
	//jika ada kesalahan error pada saat proses perubahan profil, maka update profil telah gagal.
	else
	{
		echo "<script>
			alert('Update profile gagal');
	        window.location.href='profile.php';
	      </script>";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<title><?=$web['nama']?> - Profile Pengguna</title>
<?php include 'layout/header.php'; ?>
<!-- //navigation -->
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="index.html"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Profile Pengguna</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- login -->
	<div class="register">
		<div class="container">
			<h2>Profile Pengguna</h2>
			<div class="login-form-grids">
				<h5>Informasi Pribadi</h5>
				<form method="post" action="">
					<input type="text" name="nama" value="<?=$user['namalengkap']?>" placeholder="Nama Lengkap" required>
					<input type="text" name="telp" value="<?=$user['notelp']?>" placeholder="Nomor Telepon" required maxlength="13">
					<input type="text" value="<?=$user['alamat']?>" name="alamat" placeholder="Alamat Lengkap" required>
				
				<h6>Informasi Login</h6>
					
					<input type="email" value="<?=$user['email']?>" name="email" placeholder="Email" required="@">
					<input type="hidden" value="<?=$user['userid']?>" name="id" >
					<input type="password" name="pass" placeholder="Password (Optional)" >
					<input type="submit" name="update" value="Update">
				</form>
			</div>
			<div class="register-home">
				<a href="index.php">Batal</a>
			</div>
		</div>
	</div>
<!-- //login -->
<!-- //footer -->

<?php include 'layout/footer.php'; ?>
</body>
</html>