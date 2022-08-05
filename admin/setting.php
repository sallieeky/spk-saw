
<?php 
	session_start();
	include '../dbconnect.php';
	//jika ada perubahan data informasi tentang sistem toko ini.
	if(isset($_POST['updatedata']))
	{
		$nama 		= ucwords($_POST['nama']);
		$tagline 	= ucwords($_POST['tagline']);
		$email 		= $_POST['email'];
		$nohp 		= $_POST['nohp'];
		$ongkir 	= $_POST['ongkir'];
		$alamat 	= $_POST['alamat'];
			  
		$tambahuser = mysqli_query($conn,"UPDATE config SET nama = '$nama', alamat = '$alamat', email = '$email', nohp = '$nohp', tagline = '$tagline', ongkir = '$ongkir' where id_config = '1'  ");
		if ($tambahuser){
			echo ("<script>
			    window.alert('Berhasil merubah pengaturan website');
			    window.location.href='setting.php';
			    </script>");
		} else { 
			echo ("<script>
			    window.alert('Gagal merubah pengaturan website');
			    window.location.href='setting.php';
			    </script>");
		}
		
	};
	?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
	<link rel="icon" 
      type="image/png" 
      href="../favicon.png">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Pengaturan Website - <?=$web['nama']?></title>
    <?php include 'include/header.php';?>
            
            
            <!-- page title area end -->
            <div class="main-content-inner">
               
                <form method="post" action="">
                <div class="row mt-5 mb-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header"><h3>Pengaturan Website</h3></div>
                            <div class="card-body row">
                                <div class="col-md-6">
                                	<div class="form-group">
                                		<label>Nama Toko</label>
                                		<input type="text" name="nama" class="form-control" value="<?=$web['nama']?>" required>
                                	</div>
                                </div>
                                <div class="col-md-6">
                                	<div class="form-group">
                                		<label>Tagline Toko</label>
                                		<input type="text" name="tagline" class="form-control" value="<?=$web['tagline']?>" required>
                                	</div>
                                </div>
                                <div class="col-md-6">
                                	<div class="form-group">
                                		<label>Email Toko</label>
                                		<input type="text" name="email" class="form-control" value="<?=$web['email']?>" required>
                                	</div>
                                </div>
                                <div class="col-md-6">
                                	<div class="form-group">
                                		<label>No HP Toko</label>
                                		<input type="number" name="nohp" class="form-control" value="<?=$web['nohp']?>" required>
                                	</div>
                                </div>
                                <div class="col-md-6">
                                	<div class="form-group">
                                		<label>Biaya Ongkir</label>
                                		<input type="number" name="ongkir" class="form-control" value="<?=$web['ongkir']?>" required>
                                	</div>
                                </div>
                                <div class="col-md-6">
                                	<div class="form-group">
                                		<label>Alamat Toko</label>
                                		<input type="text" name="alamat" class="form-control" value="<?=$web['alamat']?>" required>
                                	</div>
                                </div>
						 	</div>
						 	<div class="card-footer text-center">
						 		<button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
						 	</div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
              
                
                <!-- row area start-->
            </div>
            <?php include 'include/footer.php';?>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        
        <!-- footer area end-->
    </div>
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
