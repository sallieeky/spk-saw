<?php 
	session_start();
	include '../dbconnect.php';
	//jika ada menambah data produk baru.
	if(isset($_POST["addproduct"])) {

		$namaproduk	= ucwords($_POST['namaproduk']);
		$idkategori	= $_POST['idkategori'];
		$deskripsi	= ucfirst($_POST['deskripsi']);
		$harga 		= $_POST['harga'];
		$stok 		= $_POST['stok'];
		$n_rasa 	= $_POST['n_rasa'];
		$n_porsi 	= $_POST['n_porsi'];
		$n_harga 	= $_POST['n_harga'];

		
		
		$nama_file 		= $_FILES['uploadgambar']['name'];
		$ext 			= pathinfo($nama_file, PATHINFO_EXTENSION);
		$random 		= md5($nama_file);
		$ukuran_file 	= $_FILES['uploadgambar']['size'];
		$tipe_file 		= $_FILES['uploadgambar']['type'];
		$tmp_file 		= $_FILES['uploadgambar']['tmp_name'];
		$path 			= "../images/produk/".$random.'.'.$ext;
		$pathdb 		= $random.'.'.$ext;

		// die(var_dump($_FILES));
		if($tipe_file == "image/jpeg" || $tipe_file == "image/png" || $tipe_file == "image/jpg"){
			if(move_uploaded_file($tmp_file, $path)){ 
			
			  $query = "insert into produk (idkategori, namaproduk, gambar, deskripsi, harga, stok, n_rasa,n_porsi,n_harga)
			  values('$idkategori','$namaproduk','$pathdb','$deskripsi','$harga','$stok','$n_rasa','$n_porsi','$n_harga')";
			  $sql = mysqli_query($conn, $query); // Eksekusi/ Jalankan query dari variabel $query
			  
			  if($sql){ 
				
				echo ("<script>
					    window.alert('Berhasil menambahkan produk');
					    window.location.href='produk.php';
					    </script>");
					
			  }else{
				echo ("<script>
					    window.alert('Gagal menambahkan produk');
					    window.location.href='produk.php';
					    </script>");
			  }
			}else{

			  // Jika gambar gagal diupload, Lakukan :
			  echo ("<script>
				    window.alert('Foto produk gagal diupload');
				    window.location.href='produk.php';
				    </script>");
			}
		}else{
		  // Jika tipe file yang diupload bukan JPG / JPEG / PNG, lakukan :
		  echo ("<script>
			    window.alert('Foto yang anda upload bukan gambar!');
			    window.location.href='produk.php';
			    </script>");
		}
	
	};
	if(isset($_POST["editproduct"])) {
		$namaproduk	= ucwords($_POST['namaproduk']);
		$idkategori	= $_POST['idkategori'];
		$deskripsi	= ucfirst($_POST['deskripsi']);
		$harga 		= $_POST['harga'];
		$stok 		= $_POST['stok'];
		$n_rasa 	= $_POST['n_rasa'];
		$n_porsi 	= $_POST['n_porsi'];
		$n_harga 	= $_POST['n_harga'];
		$idproduk 	= $_POST['idproduk'];
		
		$nama_file 		= $_FILES['uploadgambar']['name'];
		$ext 			= pathinfo($nama_file, PATHINFO_EXTENSION);
		$random 		= md5($nama_file);
		$ukuran_file 	= $_FILES['uploadgambar']['size'];
		$tipe_file 		= $_FILES['uploadgambar']['type'];
		$tmp_file 		= $_FILES['uploadgambar']['tmp_name'];
		$path 			= "../images/produk/".$random.'.'.$ext;
		$pathdb 		= $random.'.'.$ext;

		if(move_uploaded_file($tmp_file, $path)){ 

		  $query = " update produk set idkategori = '$idkategori', namaproduk = '$namaproduk', gambar = '$pathdb', deskripsi = '$deskripsi', stok = '$stok',harga = '$harga', n_rasa = '$n_rasa', n_porsi = '$n_porsi', n_harga = '$n_harga' where idproduk = '$idproduk' ";
		  $sql = mysqli_query($conn, $query); // Eksekusi/ Jalankan query dari variabel $query
		  
		  if($sql){ 
			
			echo ("<script>
				    window.alert('Produk berhasil diupdate');
				    window.location.href='produk.php';
				    </script>");
				
		  }else{
			// Jika Gagal, Lakukan :
			echo ("<script>
				    window.alert(''Produk gagal diupdate');
				    window.location.href='produk.php';
				    </script>");
		  }
		}else{
		  // Jika gambar gagal diupload, Lakukan :
		  $query = " update produk set idkategori = '$idkategori', namaproduk = '$namaproduk', deskripsi = '$deskripsi', stok = '$stok',harga = '$harga', n_rasa = '$n_rasa', n_porsi = '$n_porsi', n_harga = '$n_harga' where idproduk = '$idproduk' ";
		  $sql = mysqli_query($conn, $query); // Eksekusi/ Jalankan query dari variabel $query
		  if ($sql) {
		  	echo ("<script>
				    window.alert('Produk berhasil diupdate');
				    window.location.href='produk.php';
				    </script>");
		  }
		  else
		  {
		  	echo ("<script>
				    window.alert(''Produk gagal diupdate');
				    window.location.href='produk.php';
				    </script>");
		  }
		  
		}
	
	};
	if (isset($_GET['delete'])) {
		$id = $_GET['id'];
		mysqli_query($conn," DELETE from produk where idproduk = '$id' ");
		echo ("<script>
				    window.alert(''Produk berhasil dihapus');
				    window.location.href='produk.php';
				    </script>");
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
    <title>Kelola Produk - <?=$web['nama']?></title>
    <?php include 'include/header.php';?>
            
            <!-- page title area end -->
            <div class="main-content-inner">
               
                <!-- market value area start -->
                <div class="row mt-5 mb-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
									<h2>Daftar Produk</h2>
									<button style="margin-bottom:20px" data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-2">Tambah Produk</button>
                                </div>
                                    <div class="data-tables datatable-dark text-center">
										 <table id="dataTable3" class="display" style="width:100%"><thead class="thead-dark">
											<tr>
												<th width="1%">No.</th>
												<th>Gambar</th>
												<th>Nama Produk</th>
												<th>Kategori</th>
												<th>Stok</th>
												<th>Harga</th>
												<th>Opsi</th>
											</tr></thead><tbody>
											<?php 
											$brgs=mysqli_query($conn,"SELECT * from kategori k, produk p where k.idkategori=p.idkategori order by idproduk ASC");
											$no=1;
											while($p=mysqli_fetch_array($brgs)){?>
												
											<tr>
												<td><?php echo $no++ ?></td>
												<td><img src="../images/produk/<?php echo $p['gambar'] ?>" style="max-width: 150px; max-height: 100px;"></td>
												<td style="text-align:left"><?php echo $p['namaproduk'] ?></td>
												<td><?php echo $p['namakategori'] ?></td>
												<td><?php echo $p['stok'] ?></td>
												<td>Rp. <?php echo number_format($p['harga']) ?></td>
												<td>
													<div class="btn-group btn-group-sm">
														<a href="gambar.php?idproduk=<?=$p['idproduk']?>" class="btn btn-success btn-sm"><span class="fa fa-image"></span></a>
														<a href="#" data-toggle="modal" data-target="#update<?=$p['idproduk']?>" class="btn btn-info btn-sm"><span class="fa fa-edit"></span></a>
														<a onclick="return confirm('apakah anda yakin ingin menghapus data ini?')" href="produk.php?delete&&id=<?=$p['idproduk']?>" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
													</div>
													
												</td>
												
											</tr>
											<?php  } ?>
										</tbody>
										</table>
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
					<h4 class="modal-title">Tambah Produk</h4>
				</div>
				
				<div class="modal-body">
				<form action="produk.php" method="post" enctype="multipart/form-data" >
						<div class="form-group">
							<label>Nama Produk</label>
							<input name="namaproduk" type="text" class="form-control" required autofocus>
						</div>
						<div class="form-group">
							<label>Nama Kategori</label>
							<select name="idkategori" class="form-control" required>
							<option selected>Pilih Kategori</option>
							<?php
							$det=mysqli_query($conn,"select * from kategori order by namakategori ASC")or die(mysqli_error());
							while($d=mysqli_fetch_array($det)){
							?>
								<option value="<?php echo $d['idkategori'] ?>"><?php echo $d['namakategori'] ?></option>
								<?php
						}
						?>		
							</select>
							
						</div>
						<div class="form-group">
							<label>Deskripsi Produk</label>
							<textarea name="deskripsi" class="form-control" required></textarea>
						</div>
						<div class="form-group">
							<label>Harga Produk</label>
							<input name="harga" type="number" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Stok Produk</label>
							<input name="stok" min="0" type="number" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Nilai Kriteria Rasa</label>
							<input name="n_rasa" type="number" min="0" max="100" class="form-control" required placeholder="Masukan skala 0-100">
						</div>
						<div class="form-group">
							<label>Nilai Kriteria Porsi</label>
							<input name="n_porsi" type="number" min="0" max="100" class="form-control" required placeholder="Masukan skala 0-100">
						</div>
						<div class="form-group">
							<label>Nilai Kriteria Harga</label>
							<input name="n_harga" type="number" min="0" max="100" class="form-control" required placeholder="Masukan skala 0-100">
						</div>
						<div class="form-group">
							<label>Gambar Utama</label>
							<input name="uploadgambar" type="file" class="form-control" required>
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

	<!-- modal edit -->
	<?php 
	$brgs=mysqli_query($conn,"SELECT * from kategori k, produk p where k.idkategori=p.idkategori order by idproduk ASC");
	$no=1;
	while($p=mysqli_fetch_array($brgs)){ ?>
	<div id="update<?=$p['idproduk']?>" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Update Produk</h4>
				</div>
				
				<div class="modal-body">
				<form action="produk.php" method="post" enctype="multipart/form-data" >
						<div class="form-group">
							<label>Nama Produk</label>
							<input name="namaproduk" type="text" value="<?=$p['namaproduk']?>" class="form-control" required autofocus>
						</div>
						<div class="form-group">
							<label>Nama Kategori</label>
							<select name="idkategori" class="form-control">
							<option selected>Pilih Kategori</option>
							<?php
							$det=mysqli_query($conn,"select * from kategori order by namakategori ASC")or die(mysqli_error());
							while($d=mysqli_fetch_array($det)){ ?>
								<option <?php if ($d['idkategori'] == $p['idkategori']) { echo "selected"; } ?> value="<?php echo $d['idkategori'] ?>"><?php echo $d['namakategori'] ?></option>
							<?php } ?>		
							</select>
							
						</div>
						<div class="form-group">
							<label>Deskripsi</label>
							<textarea name="deskripsi" class="form-control" required><?=$p['deskripsi']?></textarea>
						</div>
						<div class="form-group">
							<label>Harga Produk</label>
							<input name="harga" type="number" value="<?=$p['harga']?>" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Stok Produk</label>
							<input name="stok" min="0" type="number" value="<?=$p['stok']?>" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Nilai Kriteria Rasa</label>
							<input name="n_rasa" type="number" value="<?=$p['n_rasa']?>" min="0" max="100" class="form-control" required placeholder="Masukan skala 0-100">
						</div>
						<div class="form-group">
							<label>Nilai Kriteria Porsi</label>
							<input name="n_porsi" type="number" min="0" value="<?=$p['n_porsi']?>" max="100" class="form-control" required placeholder="Masukan skala 0-100">
						</div>
						<div class="form-group">
							<label>Nilai Kriteria Harga</label>
							<input name="n_harga" type="number" min="0" max="100" value="<?=$p['n_harga']?>" class="form-control" required placeholder="Masukan skala 0-100">
						</div>
						<div class="form-group">
							<label>Gambar</label>
							<input name="uploadgambar" type="file" class="form-control">
						</div>

					</div>
					<div class="modal-footer">
						<input name="idproduk" type="hidden" value="<?=$p['idproduk']?>" class="form-control">
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
						<input name="editproduct" type="submit" class="btn btn-primary" value="Update">
					</div>
				</form>
			</div>
		</div>
	</div>	
	<?php } ?>
	<script>
	$(document).ready(function() {
    $('#dataTable3').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'print'
        ]
    } );
	} );
	</script>
	
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
