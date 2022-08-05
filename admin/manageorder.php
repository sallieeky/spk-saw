<?php 
	session_start();
	include '../dbconnect.php';
	date_default_timezone_set("Asia/Bangkok");
	?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
	<link rel="icon" 
      type="image/png" 
      href="../favicon.png">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Kelola Pesanan - <?=$web['nama']?></title>
    <?php include 'include/header.php';?>
			
            
            <!-- page title area end -->
            <div class="main-content-inner">
               
                <!-- market value area start -->
                <div class="row mt-5 mb-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
									<h2>Daftar Pesanan</h2>
								</div>
                                    <div class="data-tables datatable-dark text-center">
										 <table id="dataTable3" class="display" style="width:100%">
										 	<thead class="thead-dark">
												<tr>
													<th>No</th>
													<th>ID Pesanan</th>
													<th>Nama Customer</th>
													<th>Tanggal Order</th>
													<th>Total</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
											<?php 
                                            //menampilkan seluruh data order.
											$brgs=mysqli_query($conn,"SELECT * from cart c, login l where c.userid=l.userid and status!='Cart'  order by idcart DESC");
											$no=1;
											while($p=mysqli_fetch_array($brgs)){
											$orderids = $p['orderid'];
												?>
												
												<tr>
													<td><?php echo $no++ ?></td>
													<td><strong><a href="order.php?orderid=<?php echo $p['orderid'] ?>">#<?php echo $p['orderid'] ?></a></strong></td>
													<td><?php echo $p['namalengkap'] ?></td>
													<td><?php echo date('H:i:s d-m-Y',strtotime($p['tglorder'])) ?></td>
													<td>Rp. <?php 
												
												$result1 = mysqli_query($conn,"SELECT SUM(d.qty*p.harga) AS count FROM detailorder d, produk p where orderid='$orderids' and p.idproduk=d.idproduk order by d.idproduk ASC");
												$cekrow = mysqli_num_rows($result1);
												$row1 = mysqli_fetch_assoc($result1);
												$count = $row1['count'] + $p['ongkir'];
												if($cekrow > 0){
													echo number_format($count);
													} else {
														echo 'No data';
													}?></td>
													<td><?php echo $p['status'];  ?> </td>
												</tr>		
												<?php } ?>
											</tbody>
										</table>
                                    </div>
									<!-- <a href="datapesanan.php" target="_blank" class="btn btn-info">Export Data</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <?php include 'include/footer.php';?>
        <!-- footer area end-->
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
