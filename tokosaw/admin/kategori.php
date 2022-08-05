
<?php 
	session_start();
	include '../dbconnect.php';
		
	if(isset($_POST['addcategory']))
	{
		$namakategori = $_POST['namakategori'];
			   
		$tambahkat = mysqli_query($conn,"insert into kategori (namakategori) values ('$namakategori')");
		if ($tambahkat){
		echo "
		<meta http-equiv='refresh' content='0; url= kategori.php'/>  ";
		} else { echo "
		 <meta http-equiv='refresh' content='0; url= kategori.php'/> ";
		}
		
	};
	if(isset($_POST['editcategory']))
	{
		$idkategori		= $_POST['idkategori'];
		$namakategori 	= $_POST['namakategori'];
			   
		$tambahkat = mysqli_query($conn,"UPDATE kategori set namakategori = '$namakategori' where idkategori = '$idkategori' ");
		echo " <meta http-equiv='refresh' content='0; url= kategori.php'/>  ";
		
	};
	if (isset($_GET['delete'])) {
		$id = $_GET['id'];
		$sql = mysqli_query($conn," SELECT * FROM produk where idkategori = '$id' ");
		if (mysqli_num_rows($sql) > 0) {
			echo "<script>
					alert('Tidak dapat menghapus kategori yang sudah memiliki produk');
			        window.location.href='kategori.php';
			      </script>";
		}
		else
		{
			mysqli_query($conn," DELETE from kategori where idkategori = '$id' ");
			echo "<script>
					alert('delete berhasil');
			        window.location.href='kategori.php';
			      </script>";
		}
		//echo "<br><meta http-equiv='refresh' content='0; URL=produk.php'> Delete success";
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
    <title>Kelola Kategori - <?=$web['nama']?></title>
    <?php include 'include/header.php';?>
            
            
            <!-- page title area end -->
            <div class="main-content-inner">
               
                <!-- market value area start -->
                <div class="row mt-5 mb-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
									<h2>Daftar Kategori</h2>
									<button style="margin-bottom:20px" data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-2">Tambah Kategori</button>
                                </div>
                                    <div class="data-tables datatable-dark text-center">
										 <table id="dataTable3" class="display" style="width:100%"><thead class="thead-dark">
											<tr>
												<th>No.</th>
												<th>Nama Kategori</th>
												<th>Jumlah Produk</th>
												<th>Opsi</th>
											</tr></thead><tbody>
											<?php 
											$brgs=mysqli_query($conn,"SELECT * from kategori order by idkategori ASC");
											$no=1;
											while($p=mysqli_fetch_array($brgs)){
												$id = $p['idkategori'];

												?>
												
												<tr>
													<td><?php echo $no++ ?></td>
													<td><?php echo $p['namakategori'] ?></td>
													<td><?php 
												
														$result1 = mysqli_query($conn,"SELECT Count(idproduk) AS count FROM produk p, kategori k where p.idkategori=k.idkategori and k.idkategori='$id' order by idproduk ASC");
														$cekrow = mysqli_num_rows($result1);
														$row1 = mysqli_fetch_assoc($result1);
														$count = $row1['count'];
														if($cekrow > 0){
														echo number_format($count);
														} else {
															echo 'No data';
														}
													?></td>
													<td>
														<div class="btn-group">
															<a href="#" data-toggle="modal" data-target="#update<?=$p['idkategori']?>" class="btn btn-info btn-sm"><span class="fa fa-edit"></span></a>
															<a onclick="return confirm('apakah anda yakin ingin menghapus data ini?')" href="kategori.php?delete&&id=<?=$p['idkategori']?>" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
														</div>
													</td>
													
												</tr>		
												
												<?php 
											}
											
											?>
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
					<h4 class="modal-title">Tambah Kategori</h4>
				</div>
				<div class="modal-body">
					<form method="post">
						<div class="form-group">
							<label>Nama Kategori</label>
							<input name="namakategori" type="text" class="form-control" required autofocus>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
						<input name="addcategory" type="submit" class="btn btn-primary" value="Tambah">
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal update -->
	<?php 
	$brgs=mysqli_query($conn,"SELECT * from kategori order by idkategori ASC");
	$no=1;
	while($p=mysqli_fetch_array($brgs)){ ?>
	<div id="update<?=$p['idkategori']?>" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Update Kategori</h4>
				</div>
				<div class="modal-body">
					<form method="post">
						<div class="form-group">
							<label>Nama Kategori</label>
							<input name="namakategori" type="text" value="<?=$p['namakategori']?>" class="form-control" required autofocus>
						</div>

					</div>
					<div class="modal-footer">
						<input name="idkategori" type="hidden" value="<?=$p['idkategori']?>" class="form-control" required autofocus>
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
						<input name="editcategory" type="submit" class="btn btn-primary" value="Update">
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
