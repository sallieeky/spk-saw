<?php 
session_start();
include '../dbconnect.php';
$orderids = $_GET['orderid'];
$liatcust = mysqli_query($conn,"select * from login l, cart c where orderid='$orderids' and l.userid=c.userid");
$checkdb  = mysqli_fetch_array($liatcust);
date_default_timezone_set("Asia/Bangkok");

//jika ada pemesanan baru dari pelanggan suatu produk.
if($_POST['submit']) 
{
	$id 	= $_POST['id'];
	$jenis 	= $_POST['jenis'];
	$resi 	= $_POST['resi'];
	$updatestatus = mysqli_query($conn,"update cart set status = 'Pengiriman', jenis_pengiriman = '$jenis',resi = '$resi' where orderid = '$orderids'");
	
	if($updatestatus){
		echo "<script>
			alert('Berhasil mengubah status pesanan');
	        window.location.href='manageorder.php';
	      </script>";
	} else {
		echo "<script>
			alert('Gagagl, Silahkan coba lagi');
	        window.location.href='order.php?orderid=<?=$id?>';
	      </script>";
	}
	
}

//jika pesanan produk telah selesai (diterima oleh pelanggan).
if($_GET['aksi'] == 'selesai')
{
	$id = $_GET['orderid'];

	$listbrg 		= mysqli_query($conn,"SELECT p.idproduk, d.qty, p.stok from detailorder d, produk p where orderid = '$orderids' and d.idproduk = p.idproduk ");
	//update stok barang
	while ($brg = mysqli_fetch_object($listbrg)) {
		$stoknew = $brg->stok - $brg->qty;
		mysqli_query($conn," UPDATE produk SET stok = '$stoknew' where idproduk = '$brg->idproduk' ");
	}

	$updatestatus 	= mysqli_query($conn,"update cart set status = 'Selesai' where orderid = '$orderids'");
	
	if($updatestatus){
		echo "<script>
			alert('Berhasil mengubah status pesanan');
	        window.location.href='manageorder.php';
	      </script>";
	} else {
		echo "<script>
			alert('Gagagl, Silahkan coba lagi');
	        window.location.href='order.php?orderid=<?=$id?>';
	      </script>";
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
    <title><?=$web['nama']?> - Pesanan <?php echo $checkdb['namalengkap']; ?></title>
    <?php include 'include/header.php'; ?>
			
			
            <!-- page title area end -->
            <div class="main-content-inner">
                <!-- market value area start -->
                <div class="row mt-5 mb-5">
                    <div class="col-md-8">
                        <div class="card">
                        	<div class="card-header">
								<h3>Detail Order</h3>
							</div>
                            <div class="card-body">
                                <h5>Informasi Pesanan : </h5><br>
                                <p>
                                	Kode Order : <b><?php echo $checkdb['orderid']; ?></b><br>
                                	Nama Pelanggan : <b><?php echo $checkdb['namalengkap']; ?></b><br>
                                	Waktu order : <b><?php echo date('d M Y H:i',strtotime($checkdb['tglorder'])); ?></b><br>
                                	Catatan Pelanggan: <b><?php echo $checkdb['catatan']; ?></b><br>
                                	
                                	Alamat Pengantaran : <b><?php echo $checkdb['alamat_pengantaran']; ?></b><br>
                                	Status Pesanan : <b><?php echo $checkdb['status']; ?></b><br>
                                	<?php if ($checkdb['status'] == 'Pengiriman') { ?>
									Ekspedisi Pegiriman : <b><?php echo $checkdb['jenis_pengiriman']; ?></b><br>
									Resi Pegiriman : <b><?php echo $checkdb['resi']; ?></b><br>

									<?php } ?>
                                </p>
								<hr>
								<h5>Daftar Item Pesanan : </h5><br>
							   	<div class="data-tables datatable-dark">
									<table id="" class="table display" style="width:100%">
										<thead class="thead-dark">
										<tr>
											<th>No</th>
											<th>Produk</th>
											<th>Jumlah</th>
											<th>Harga</th>
											<th>Subtotal</th>
										</tr>
										</thead>
										<tbody>
											<?php
											//menampilkan seluruh data detail produk terhadap order dari pelanggan. 
											$brgs = mysqli_query($conn,"SELECT * from detailorder d, produk p
												where orderid = '$orderids' 
												and d.idproduk = p.idproduk 
												order by d.idproduk ASC");
											$no=1;
											$akhir = 0;
											while($p=mysqli_fetch_array($brgs)){
												$total = $p['qty']*$p['harga'];
												
												$result = mysqli_query($conn,"SELECT SUM(d.qty*p.harga) AS count FROM detailorder d, produk p where orderid = '$orderids' and d.idproduk=p.idproduk order by d.idproduk ASC");
												$row = mysqli_fetch_assoc($result);
												$cekrow = mysqli_num_rows($result);
												$count = $row['count'];
												?>
												<tr>
													<td><?php echo $no++ ?></td>
													<td><?php echo $p['namaproduk'] ?></td>
													<td><?php echo $p['qty'] ?></td>
													<td style="text-align:right">Rp. <?php echo number_format($p['harga']) ?></td>
													<td style="text-align:right">Rp. <?php echo number_format($total) ?></td>
												</tr>
											<?php $akhir += $total; } ?>
										</tbody>
										<tfoot>
											<tr>
												<th colspan="4" style="text-align:right">Ongkos Kirim :</th>
												<th style="text-align:right">Rp. <?php echo number_format($checkdb['ongkir']) ?></th>
											</tr>
											<tr>
												<th colspan="4" style="text-align:right">Grand Total :</th>
												<th style="text-align:right">Rp. <?php echo number_format($akhir + $checkdb['ongkir']) ?></th>
											</tr>
										</tfoot>
									</table>
								</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                        	<div class="card-header">
								<h3>Pembayaran</h3>
							</div>
                            <div class="card-body">
                                <h5>Informasi Pembayaran : </h5><br>
                                <?php 
                                $ambilinfo 	= mysqli_query($conn,"select * from konfirmasi where orderid = '$orderids' order by idkonfirmasi desc limit 1 ");
                                if ($ambilinfo) {
                                $data 		= mysqli_fetch_assoc($ambilinfo);
								?>
                                <p>
                                	Bank Tujuan : <b><?php echo $data['payment']; ?></b><br>
                                	Pemilik Rekening : <b><?php echo $data['namarekening']; ?></b><br>
                                	Tanggal Pembayaran : <b><?php echo $data['tglbayar']; ?></b><br>
                                	Bukti Pembayaran : <br><br><center><a target="_blank" href="../images/bukti/<?=$data['bukti']?>"><img width="200px" src="../images/bukti/<?=$data['bukti']?>"></a></center>
                                </p>
                            	<?php } else { ?>
                            	<p style="text-align: center;">Pembayaran belum dilakukan</p>
                            	<?php }  ?>
                            </div>
                            <div class="card-footer">
                            	<?php if ($checkdb['status'] == 'Confirmed') { ?>
                            		<a data-toggle="modal" data-target="#exampleModal" href="#" class="btn btn-primary btn-xs" >Kirim Pesanan</a>
                            		<a target="_blank" href="invoice.php?id=<?=$orderids?>" class="btn btn-info btn-xs" >Cetak Invoice</a>
                            	<?php } elseif ($checkdb['status'] == 'Pengiriman') { ?>
                            		<a onclick="return confirm('apakah anda yakin ingin menyelesaikan pesanan ini?')" href="order.php?aksi=selesai&&orderid=<?php echo $checkdb['orderid'] ?>" class="btn btn-primary btn-xs" >Selesaiakan Pesanan</a>
                            		<a target="_blank" href="invoice.php?id=<?=$orderids?>" class="btn btn-info btn-xs" >Cetak Invoice</a>
                            	<?php } elseif ($checkdb['status'] == 'Waiting') { ?>
                            		<a data-toggle="modal" data-target="#ongkir" href="#" class="btn btn-info btn-xs" >Konfirmasi Ongkos Kirim</a>
                            	<?php }  ?>
                            	
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
	
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Detail Pengiriman</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form method="post" action="order.php?orderid=<?=$checkdb['orderid']?>">
	      <div class="modal-body">
	        <div class="form-group">
	        	<label>Jenis Expedisi Pengiriman</label>
	        	<input type="text" name="jenis" class="form-control" required="" placeholder="ex: JNE, JNT, dll">
	        </div>
	        <div class="form-group">
	        	<label>No Resi</label>
	        	<input type="text" name="resi" class="form-control" required="">
	        </div>
	      </div>
	      <div class="modal-footer">
	      	<input type="hidden" name="id" value="<?=$checkdb['orderid']?>" class="form-control" required="">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <input type="submit" name="submit" class="btn btn-primary" value="Simpan">
	      </div>
	      </form>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="ongkir" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Ongkos Kirim</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form method="post" action="order.php?orderid=<?=$checkdb['orderid']?>">
	      <div class="modal-body">
	        <div class="form-group">
	        	<label>Ongkos Kirim</label>
	        	<input type="number" name="jmlongkir" class="form-control" required="">
	        </div>
	      </div>
	      <div class="modal-footer">
	      	<input type="hidden" name="id" value="<?=$checkdb['orderid']?>" class="form-control" required="">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <input type="submit" name="ongkir" class="btn btn-primary" value="Simpan">
	      </div>
	      </form>
	    </div>
	  </div>
	</div>
	
	<script type="text/javascript">
		$(document).ready(function() {
    $('#dataTable3').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'print'
        ]
    } );
	} );
	$(document).ready(function() {
    $('#dataTable2').DataTable( {
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
	 <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
	
	
</body>

</html>
