<?php 
	session_start();
	include '../dbconnect.php';
	$idproduk = $_GET['idproduk'];
	//jika ada tambah data produk baru.
	if(isset($_POST["addproduct"])) {

		$idproduk 		= $_GET['idproduk'];		
		
		$nama_file 		= $_FILES['uploadgambar']['name'];
		$ext 			= pathinfo($nama_file, PATHINFO_EXTENSION);
		$random 		= md5($nama_file);
		$ukuran_file 	= $_FILES['uploadgambar']['size'];
		$tipe_file 		= $_FILES['uploadgambar']['type'];
		$tmp_file 		= $_FILES['uploadgambar']['tmp_name'];
		$path 			= "../images/produk/".$random.'.'.$ext;
		$pathdb 		= $random.'.'.$ext;

		//jika ekstensi file itu "image/jpeg" atau "image/png", maka bisa upload file gambar produk.
		if($tipe_file == "image/jpeg" || $tipe_file == "image/png"){
			if(move_uploaded_file($tmp_file, $path)){ 
			  $sql = mysqli_query($conn, " INSERT INTO gambar VALUES (null,'$idproduk','$pathdb') ");
			  //jika tidak ada kesalahan pada proses penambahan produk.
			  if($sql){ 
				
				echo ("<script>
					    window.alert('Berhasil menambahkan gambar produk');
					    window.location.href='gambar.php?idproduk=".$idproduk."';
					    </script>");
					
			  }
			 //jika ada kesalahan atau error pada proses penambahan produk. 
			  else{
				echo ("<script>
					    window.alert('Gagal menambahkan gambar produk');
					    window.location.href='gambar.php?idproduk=".$idproduk."';
					    </script>");
			  }
			}else{

			  // Jika gambar gagal diupload, Lakukan :
			  echo ("<script>
				    window.alert('Foto produk gagal diupload');
				    window.location.href='gambar.php?idproduk=".$idproduk."';
				    </script>");
			}
		}else{
		  // Jika tipe file yang diupload bukan JPG / JPEG / PNG, lakukan :
		  echo ("<script>
			    window.alert('Foto yang anda upload bukan gambar!');
			    window.location.href='gambar.php?idproduk=".$idproduk."';
			    </script>");
		}
	
	};
	//jika ada penghaspusan data produk.
	if (isset($_GET['delete'])) {
		$id = $_GET['id'];
		$idproduk = $_GET['idproduk'];
		mysqli_query($conn," DELETE from gambar where idgambar = '$id' ");
		echo "<br><meta http-equiv='refresh' content='0; URL=gambar.php?idproduk=".$idproduk."'> Delete success";
	}
	?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
	<link rel="icon" 
      type="image/png" 
      href="../favicon.png">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Gambar Produk - <?=$web['nama']?></title>
    <?php include 'include/header.php';?>
            
            <!-- page title area end -->
            <div class="main-content-inner">
               
                <!-- market value area start -->
                <div class="row mt-5 mb-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
									<h2>Daftar Gambar Produk</h2>
									<button style="margin-bottom:20px" data-toggle="modal" data-target="#myModal" class="btn btn-info ">Tambah Gambar Produk</button>
                                </div>
                                <hr>
                                <div class="row">
                                	<?php
									//menampilkan seluruh data produk. 
									$brgs=mysqli_query($conn,"SELECT * from gambar WHERE produk = '$idproduk' order by idgambar ASC");
									$no=1;
									while($p=mysqli_fetch_array($brgs)){?>
                                	<div class="col-md-2">
                                		<center><img src="../images/produk/<?php echo $p['gambar'] ?>" style="max-width: 150px; max-height: 100px;"></center>
                                		<br><br>
                                		<a onclick="return confirm('apakah anda yakin ingin menghapus gambar ini?')" href="gambar.php?delete&&id=<?=$p['idgambar']?>&idproduk=<?=$idproduk?>" class="btn btn-danger btn-sm btn-block"><span class="fa fa-trash"></span> Delete</a>
                                	</div>
                                	<?php  } ?>
                                </div>
								 </div>
                            </div>
                        </div>
                    </div>
                </div>
              
                
                <!-- row area start-->
            </div>
             <?php include 'include/footer.php';?>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
       
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
	
	<!-- modal input -->
	<div id="myModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Tambah Gambar Produk</h4>
				</div>
				
				<div class="modal-body">
				<form action="gambar.php?idproduk=<?=$_GET['idproduk']?>" method="post" enctype="multipart/form-data" >
						<div class="form-group">
							<label>Gambar</label>
							<input name="uploadgambar" type="file" class="form-control">
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
						<input name="addproduct" type="submit" class="btn btn-primary" value="Tambah">
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!-- jquery latest version -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
		<!-- Start datatable js -->
	 <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <!-- all line chart activation -->
    <script src="assets/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="assets/js/pie-chart.js"></script>
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
	
</body>
</html>
