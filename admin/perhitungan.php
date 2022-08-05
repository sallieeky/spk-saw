<?php 
	session_start();
	include '../dbconnect.php';
			
	
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
	<link rel="icon" 
      type="image/png" 
      href="../favicon.png">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Perhitungan SAW - <?=$web['nama']?></title>
    <?php include 'include/header.php';?>
            
            <!-- page title area end -->
            <div class="main-content-inner">
               
                <!-- market value area start -->
                <div class="row mt-5 mb-5">
                    <div class="col-12">

                        <div class="card">
                        	<div class="card-header">
									<h5>Nilai Kriteria</h5>
                                </div>
                            <div class="card-body">
                                
                                    <div class="data-tables datatable-dark text-center">
										 <table id="" class="display" style="width:100%">
										 	<thead class="thead-dark">
												<tr>
													<th width="1%">No.</th>
													<th>Nama Produk</th>
													<th>Nilai Rasa</th>
													<th>Nilai Penjualan</th>
													<th>Nilai Harga</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											//menampilkan data perhitungan pada suatu penilaian produk.
											$brgs=mysqli_query($conn,"SELECT * from penilaian JOIN produk on penilaian.penilaian_produk = produk.idproduk order by idproduk ASC");
											$no=1;
											while($p=mysqli_fetch_object($brgs)){
												$list 		= mysqli_fetch_object(
																mysqli_query($conn, " SELECT sum(qty) as penjualan 
																						FROM detailorder 
																						JOIN cart on detailorder.orderid = cart.orderid
																						WHERE cart.status != 'waiting' 
																						AND detailorder.idproduk = '$p->idproduk' " ));

												$rating		= mysqli_fetch_object(
																mysqli_query($conn, " SELECT sum(rating) / count(idproduk) as rasa 
																						FROM rating 
																						JOIN detailorder on detailorder.detailid = rating.rating_detailorder
																						WHERE detailorder.idproduk = '$p->idproduk' " ));
											?>
												
											<tr>
												<td><?php echo $no++ ?></td>
												<td style="text-align:left"><?php echo $p->namaproduk ?></td>
												<td><?php echo empty($rating->rasa)?0:number_format($rating->rasa,) ?></td>
												<td><?php echo empty($list->penjualan)?0:$list->penjualan ?></td>
												<td><?php echo $p->harga?></td>
												
											</tr>
											<?php  } ?>
										</tbody>
										</table>
                                    </div>
								 </div>
                            </div>
                        </div>

                        <div class="col-12">

                        <div class="card">
                        	<div class="card-header">
									<h5>Nilai Normalisasi</h5>
                                </div>
                            <div class="card-body">
                                
                                    <div class="data-tables datatable-dark text-center">
										 <table id="" class="display" style="width:100%">
										 	<thead class="thead-dark">
												<tr>
													<th width="1%">No.</th>
													<th>Nama Produk</th>
													<th>Nilai Rasa</th>
													<th>Nilai Penjualan</th>
													<th>Nilai Harga</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											//menampilkan hasil normalisasi penilaian data produk.
											$brgs=mysqli_query($conn,"SELECT *, SUBSTRING_INDEX(penilaian_trs, '-', 1) as trs, 
																				SUBSTRING_INDEX(penilaian_harga, '-', 1) as harga, 
																				SUBSTRING_INDEX(penilaian_rasa, '-', 1) as rasa
																		from penilaian JOIN produk on penilaian.penilaian_produk = produk.idproduk order by idproduk ASC");
											$no=1;
											while($p=mysqli_fetch_object($brgs)){ ?>
												
											<tr>
												<td><?php echo $no++ ?></td>
												<td style="text-align:left"><?php echo $p->namaproduk ?></td>
												<td><?php echo $p->rasa?></td>
												<td><?php echo $p->trs?></td>
												<td><?php echo $p->harga?></td>
												
											</tr>
											<?php  } ?>
										</tbody>
										</table>
                                    </div>
								 </div>
                            </div>
                        </div>

                        <div class="col-12">

                        <div class="card">
                        	<div class="card-header">
									<h5>Nilai Akhir</h5>
                                </div>
                            <div class="card-body">
                                
                                    <div class="data-tables datatable-dark text-center">
										 <table id="" class="display" style="width:100%">
										 	<thead class="thead-dark">
												<tr>
													<th width="1%">No.</th>
													<th>Nama Produk</th>
													<th>Nilai Rasa</th>
													<th>Nilai Penjualan</th>
													<th>Nilai Harga</th>
													<th>Nilai Akhir</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											//menampilkan nilai akhir pada penilaian suatu produk.
											$brgs=mysqli_query($conn,"SELECT *, SUBSTRING_INDEX(penilaian_trs, '-', -1) as trs, 
																				SUBSTRING_INDEX(penilaian_harga, '-', -1) as harga, 
																				SUBSTRING_INDEX(penilaian_rasa, '-', -1) as rasa
																		from penilaian JOIN produk on penilaian.penilaian_produk = produk.idproduk order by penilaian desc");
											$no=1;
											while($p=mysqli_fetch_object($brgs)){ ?>
												
											<tr>
												<td><?php echo $no++ ?></td>
												<td style="text-align:left"><?php echo $p->namaproduk ?></td>
												<td><?php echo $p->rasa?></td>
												<td><?php echo $p->trs?></td>
												<td><?php echo $p->harga?></td>
												<td><?php echo $p->penilaian?></td>
												
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
