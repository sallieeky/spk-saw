
<?php 
	session_start();
	include '../dbconnect.php';
	//jika ada perubahan data kriteria.
	if(isset($_POST['edit']))
	{
		$id		= $_POST['id'];
		$bobot 	= $_POST['bobot'];
			   
		$tambahkat = mysqli_query($conn,"UPDATE kriteria set bobot = '$bobot' where kriteria_id = '$id' ");
		echo " <meta http-equiv='refresh' content='0; url= kriteria.php'/>  ";
		
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
    <title>Kriteria Penilaian - <?=$web['nama']?></title>
    <?php include 'include/header.php';?>
            
            
            <!-- page title area end -->
            <div class="main-content-inner">
               
                <!-- market value area start -->
                <div class="row mt-5 mb-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
									<h2>Daftar Kriteria Penilaian</h2>
                                </div>
                                    <div class="data-tables datatable-dark text-center">
										 <table id="dataTable3" class="display" style="width:100%"><thead class="thead-dark">
											<tr>
												<th>No.</th>
												<th>Kriteria Penilaian</th>
												<th>Bobot (%)</th>
												<th>Opsi</th>
											</tr></thead><tbody>
											<?php 
											//menampilkan seluruh data kriteria.
											$brgs=mysqli_query($conn,"SELECT * from kriteria");
											$no=1;
											while($p=mysqli_fetch_array($brgs)){
												$id = $p['kriteria_id'];

												?>
												
												<tr>
													<td><?php echo $no++ ?></td>
													<td><?php echo ucwords($p['kriteria']) ?></td>
													<td><?php echo $p['bobot'] ?></td>
													<td>
														<div class="btn-group">
															<a href="#" data-toggle="modal" data-target="#update<?=$p['kriteria_id']?>" class="btn btn-info btn-sm"><span class="fa fa-edit"></span></a>
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

	<!-- modal update -->
	<?php 
	$brgs=mysqli_query($conn,"SELECT * from kriteria");
	$no=1;
	while($p=mysqli_fetch_array($brgs)){ ?>
	<div id="update<?=$p['kriteria_id']?>" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Update Kriteria</h4>
				</div>
				<div class="modal-body">
					<form method="post">
						<div class="form-group">
							<label>Nama Kriteria</label>
							<input name="kriteria" type="text" value="<?=ucwords($p['kriteria'])?>" class="form-control" required readonly>
						</div>
						<div class="form-group">
							<label>Bobot Kriteria (%)</label>
							<input name="bobot" type="text" value="<?=$p['bobot']?>" class="form-control" required >
						</div>

					</div>
					<div class="modal-footer">
						<input name="id" type="hidden" value="<?=$p['kriteria_id']?>" class="form-control" required autofocus>
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
						<input name="edit" type="submit" class="btn btn-primary" value="Update">
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
