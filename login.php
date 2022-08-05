<?php
session_start();
//jika tidak ada aktivitas atau session.
if(!isset($_SESSION['log'])){
	
} 
//jika ada aktivitas atau session.
else {
	header('location:index.php');
};

include 'dbconnect.php';
date_default_timezone_set("Asia/Bangkok");
$timenow = date("j-F-Y-h:i:s A");
	//jika ada aktivitas login dari pelanggan, maka melakukan validasi data untuk cek pelanggan yang terdaftar di dalam sistem.
	if(isset($_POST['login']))
	{
	$email 		= mysqli_real_escape_string($conn,$_POST['email']);
	$pass 		= mysqli_real_escape_string($conn,$_POST['pass']); 
	$pw 		= md5($pass);
	$queryuser 	= mysqli_query($conn,"SELECT * FROM login WHERE email='$email' and password = '$pw' ");
	$cariuser 	= mysqli_fetch_assoc($queryuser);
		//jika email & password pelanggan ditemukan di sistem. maka menampung data ke dalam $_SESSION.
		if( mysqli_num_rows($queryuser) > 0 ) {
			$_SESSION['id'] 	= $cariuser['userid'];
			$_SESSION['role'] 	= $cariuser['role'];
			$_SESSION['alamat'] = $cariuser['alamat'];
			$_SESSION['notelp'] = $cariuser['notelp'];
			$_SESSION['name'] 	= $cariuser['namalengkap'];
			$_SESSION['log'] 	= "Logged";

			//jika Role pengguna itu admin, maka beralih ke bagian admin.
			if ($cariuser['role'] == 'Admin') {
				header('location:admin');
			}

			//Jika Role pengguna selain admin, maka beralih ke halaman index.
			else
			{
				header('location:index.php');
			}
		//jika email atau password pelanggan tidak sesuai atau tidak ditemukan di dalam sistem.
		} else {
			echo 'Username atau password salah';
			header("location:login.php");
		}		
	}

?>

<!DOCTYPE html>
<html>
<head>
<title><?=$web['nama']?> - Masuk</title>
<?php include 'layout/header.php'; ?>
<!-- //navigation -->
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="index.html"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Halaman Login</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- login -->
	<div class="login">
		<div class="container">
			<h2>Masuk</h2>
		
			<div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
				<form method="post">
					<input type="text" name="email" placeholder="Email" required>
					<input type="password" name="pass" placeholder="Password" required>
					<input type="submit" name="login" value="Masuk">
				</form>
			</div>
			<h4>Belum terdaftar?</h4>
			<p><a href="registered.php">Daftar Sekarang</a></p>
		</div>
	</div>
<!-- //login -->
<!-- //footer -->

<?php include 'layout/footer.php'; ?>
</body>
</html>