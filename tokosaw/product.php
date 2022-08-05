<?php
session_start();
include 'dbconnect.php';

$idproduk = $_GET['idproduk'];

if(isset($_POST['addprod'])){
	if(!isset($_SESSION['log']))
		{	
			header('location:login.php');
		} else {
				$ui 	= $_SESSION['id'];
				$cek 	= mysqli_query($conn,"select * from cart where userid = '$ui' and status='Cart'");
				$liat 	= mysqli_num_rows($cek);
				$f 		= mysqli_fetch_array($cek);
				$orid 	= $f['orderid'];
				
				if($liat>0){
							
							//cek barang serupa
							$cekbrg 	= mysqli_query($conn,"SELECT * FROM detailorder WHERE idproduk = '$idproduk' AND orderid = '$orid' ");
							$liatlg 	= mysqli_num_rows($cekbrg);
							$brpbanyak 	= mysqli_fetch_array($cekbrg);
							$jmlh 		= $brpbanyak['qty'];
							
							//kalo ternyata barangnya ud ada
							if($liatlg>0){
								$i=1;
								$baru = $jmlh + $i;
								
								$updateaja = mysqli_query($conn,"UPDATE detailorder set qty = '$baru' where orderid = '$orid' and idproduk = '$idproduk'");
								
								if($updateaja){
									echo ("<script>
										    window.alert('Berhasil menambahkan barang ke keranjang');
										    window.location.href='product.php?idproduk=".$idproduk."';
										    </script>");
									} else {
										echo ("<script>
										    window.alert('Gagal menambahkan barang ke keranjang');
										    window.location.href='product.php?idproduk=".$idproduk."';
										    </script>");
								}
								
							} else {
							
							$tambahdata = mysqli_query($conn,"INSERT into detailorder 
																(orderid,idproduk,qty) 
																values
																('$orid','$idproduk','1')");
							if ($tambahdata){
							echo ("<script>
								    window.alert('Berhasil menambahkan barang ke keranjang');
								    window.location.href='product.php?idproduk=".$idproduk."';
								    </script>");
							} else { 
								
								echo ("<script>
									    window.alert('Gagal menambahkan barang ke keranjang');
									    window.location.href='product.php?idproduk=".$idproduk."';
									    </script>");
							}
							};
				} else {
					
						//kalo belom ada order id nya
						// fungsi untuk membuat kode transaksi
			            $query_id = mysqli_query($conn, "SELECT RIGHT(orderid,7) as kode FROM cart
			                                                ORDER BY orderid DESC LIMIT 1")
			                                                or die('Ada kesalahan pada query tampil kode_transaksi : '.mysqli_error($conn));

			            $count = mysqli_num_rows($query_id);

			            if ($count <> 0) {
			                // mengambil data kode transaksi
			                $data_id = mysqli_fetch_assoc($query_id);
			                $kode    = $data_id['kode']+1;
			            } else {
			                $kode = 1;
			            }

			            // buat kode_transaksi
			            $tahun          = date("Y");
			            $buat_id        = str_pad($kode, 7, "0", STR_PAD_LEFT);
			            $kode_transaksi = "OR-$tahun-$buat_id";

						//$oi = crypt(rand(22,999),time());
						
						$bikincart = mysqli_query($conn,"insert into cart (orderid, userid) values('$kode_transaksi','$ui')");
						
						if($bikincart){
							$tambahuser = mysqli_query($conn,"INSERT into detailorder 
																(orderid,idproduk,qty) 
																values
																('$kode_transaksi','$idproduk','1')");
							if ($tambahuser){
								echo ("<script>
							    window.alert('Berhasil menambahkan barang ke keranjang');
							    window.location.href='product.php?idproduk=".$idproduk."';
							    </script>");
							} else { 
								mysqli_query($conn,"DELETE FROM cart where orderid = '$kode_transaksi' ");
								echo ("<script>
							    window.alert('Gagal menambahkan barang ke keranjang');
							    window.location.href='product.php?idproduk=".$idproduk."';
							    </script>");
							}
						} else {
							echo ("<script>
						    window.alert('Sistem error, Silahkan coba lagi');
						    window.location.href='product.php?idproduk=".$idproduk."';
						    </script>");
						}
				}
		}
};
?>

<!DOCTYPE html>
<html>
<head>
<title>Produk - <?=$web['nama']?></title>

<?php include 'layout/header.php';?>
		
<!-- //navigation -->
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active"><?php 
				$p = mysqli_fetch_array(mysqli_query($conn,"Select * from produk where idproduk='$idproduk'"));
				echo $p['namaproduk'];
				?></li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
	<div class="products">
		<div class="container">
			<div class="agileinfo_single">
				
				<div class="col-md-4 agileinfo_single_left">

					<img class="mySlides" src="images/produk/<?php echo $p['gambar']?>" style="width:100%">
						<?php 
						$gambar = mysqli_query($conn," SELECT * FROM gambar where produk = '$idproduk' ");
					  	while ($g = mysqli_fetch_array($gambar)) { ?>
					  		<img class="mySlides" src="images/produk/<?php echo $g['gambar']?>" style="width:100%">
					  	<?php } ?>
					  	<br>
					  	<center>
					  		<button class="btn btn-primary" onclick="plusDivs(-1)">&#10094;</button>
					  		<button class="btn btn-primary" onclick="plusDivs(1)">&#10095;</button>
					  	</center>

				</div>
				<div class="col-md-8 agileinfo_single_right">
				<h2><?php echo $p['namaproduk'] ?></h2>
				<div class="w3agile_description">
					<h4>Stok :</h4>
					<p><?php echo $p['stok'] ?></p>
				</div>
				<div class="w3agile_description">
					<h4>Deskripsi :</h4>
					<p><?php echo $p['deskripsi'] ?></p>
				</div>
					
					<div class="snipcart-item block">
						<div class="snipcart-thumb agileinfo_single_right_snipcart">
							<h4 class="m-sing">Rp. <?php echo number_format($p['harga'])?></h4>
						</div>
						<form action="#" method="post" onsubmit="check()">
						<div class="snipcart-details agileinfo_single_right_details">
							
							<input type="hidden" name="idprod" value="<?php echo $idproduk ?>">
							<input type="submit" name="addprod" value="Add to cart" class="button">
								
							
						</div>
						</form>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>

<!-- //footer -->
<?php include 'layout/footer.php';?>
</body>
</html>