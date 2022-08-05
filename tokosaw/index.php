<?php
session_start();
include 'dbconnect.php';
if (!$_SESSION["login"]) {
  header("location: login.php");
}

?>

<!DOCTYPE html>
<html>
<head>
<title><?=$web['nama']?></title>

<?php include 'layout/header.php';?>
		
<!-- //navigation -->
	<!-- main-slider -->
		<ul id="demo1">
			<li>
				<img src="images/banner/1.jpg" alt="" />
			</li>
			<li>
				<img src="images/banner/2.jpg" alt="" />
			</li>
			
			<li>
				<img src="images/banner/3.jpg" alt="" />
			</li>
		</ul>
	<!-- //main-slider -->
	<!-- //top-header and slider -->
	<!-- top-brands -->
	<div class="top-brands">
		<div class="container">
		<h2>Produk Terbaru</h2>
			<div class="grid_3 grid_5">
				<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="expeditions" aria-labelledby="expeditions-tab">
							<div class="agile-tp">
								<h5>Produk Terbaru yang Kami Miliki
								<?php
								if(!isset($_SESSION['name'])){
									
								} else {
									echo 'Untukmu, '.$_SESSION['name'].'!';
								}
								?>
								</h5>
								</div>
							<div class="agile_top_brands_grids">
								<?php 
								$brgs=mysqli_query($conn,"SELECT * from produk order by idproduk ASC limit 3 ");
								$no=1;
								while($p=mysqli_fetch_array($brgs)){
								?>
								<div class="col-md-4 top_brand_left">
									<div class="hover14 column">
										<div class="agile_top_brand_left_grid">
											<div class="agile_top_brand_left_grid_pos">
												<img src="images/offer.png" alt=" " class="img-responsive" />
											</div>
											<div class="agile_top_brand_left_grid1">
												<figure>
													<div class="snipcart-item block" >
														<div class="snipcart-thumb">
															<a href="product.php?idproduk=<?php echo $p['idproduk'] ?>"><img title=" " alt=" " src="images/produk/<?php echo $p['gambar']?>" width="200px" height="200px" /></a>		
															<p><?php echo $p['namaproduk'] ?></p>
															<h4>Rp. <?php echo number_format($p['harga']) ?></h4>
														</div>
														<div class="snipcart-details top_brand_home_details">
																<fieldset>
																	<a href="product.php?idproduk=<?php echo $p['idproduk'] ?>"><input type="submit" class="button" value="Lihat Produk" /></a>
																</fieldset>
														</div>
													</div>
												</figure>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
								<div class="clearfix"> </div>
							</div>
						</div>
						
											
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="top-brands">
		<div class="container">
		<h2>Produk Rekomendasi</h2>
			<div class="grid_3 grid_5">
				<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="expeditions" aria-labelledby="expeditions-tab">
							<div class="agile-tp">
								<h5>Produk Rekomendasi yang Kami Miliki
								<?php
								if(!isset($_SESSION['name'])){
									
								} else {
									echo 'Untukmu, '.$_SESSION['name'].'!';
								}
								?>
								</h5>
								</div>
							<div class="agile_top_brands_grids">
								<?php 
								
								$brgs=mysqli_query($conn,"SELECT * from penilaian JOIN produk on penilaian.penilaian_produk = produk.idproduk order by penilaian desc limit 3 ");
								$no=1;
								while($p=mysqli_fetch_array($brgs)){
								?>
								<div class="col-md-4 top_brand_left">
									<div class="hover14 column">
										<div class="agile_top_brand_left_grid">
											<div class="agile_top_brand_left_grid_pos">
												<img src="images/offer.png" alt=" " class="img-responsive" />
											</div>
											<div class="agile_top_brand_left_grid1">
												<figure>
													<div class="snipcart-item block" >
														<div class="snipcart-thumb">
															<a href="product.php?idproduk=<?php echo $p['idproduk'] ?>"><img title=" " alt=" " src="images/produk/<?php echo $p['gambar']?>" width="200px" height="200px" /></a>		
															<p><?php echo $p['namaproduk'] ?></p>
															<h4>Rp. <?php echo number_format($p['harga']) ?></h4>
														</div>
														<div class="snipcart-details top_brand_home_details">
																<fieldset>
																	<a href="product.php?idproduk=<?php echo $p['idproduk'] ?>"><input type="submit" class="button" value="Lihat Produk" /></a>
																</fieldset>
														</div>
													</div>
												</figure>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
								<div class="clearfix"> </div>
							</div>
						</div>
						
											
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php 
	$brgsS=mysqli_query($conn,"SELECT SUM(qty) as jumlah,produk.* FROM `detailorder` 
									JOIN cart on detailorder.orderid = cart.orderid 
									JOIN produk on detailorder.idproduk = produk.idproduk
									where cart.status != 'cart' 
									GROUP BY idproduk ORDER BY SUM(qty) DESC LIMIT 3");
	if (mysqli_num_rows($brgsS) > 0) { ?>
	<div class="top-brands">
		<div class="container">
		<h2>Produk Terlaris</h2>
			<div class="grid_3 grid_5">
				<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="expeditions" aria-labelledby="expeditions-tab">
							<div class="agile-tp">
								<h5>Produk Terlaris yang Kami Miliki
								<?php
								if(!isset($_SESSION['name'])){
									
								} else {
									echo 'Untukmu, '.$_SESSION['name'].'!';
								}
								?>
								</h5>
								</div>
							<div class="agile_top_brands_grids">
								<?php 
								$no=1;
								while($p=mysqli_fetch_array($brgsS)){
								?>
								<div class="col-md-4 top_brand_left">
									<div class="hover14 column">
										<div class="agile_top_brand_left_grid">
											<div class="agile_top_brand_left_grid_pos">
												<img width="50px" src="images/best.png" alt=" " class="img-responsive" />
											</div>
											<div class="agile_top_brand_left_grid1">
												<figure>
													<div class="snipcart-item block" >
														<div class="snipcart-thumb">
															<a href="product.php?idproduk=<?php echo $p['idproduk'] ?>"><img title=" " alt=" " src="images/produk/<?php echo $p['gambar']?>" width="200px" height="200px" /></a>		
															<p><?php echo $p['namaproduk'] ?><br><small>Terjual <?=$p['jumlah']?></small></p>
															<h4>Rp. <?php echo number_format($p['harga']) ?></h4>
														</div>
														<div class="snipcart-details top_brand_home_details">
																<fieldset>
																	<a href="product.php?idproduk=<?php echo $p['idproduk'] ?>"><input type="submit" class="button" value="Lihat Produk" /></a>
																</fieldset>
														</div>
													</div>
												</figure>
											</div>
										</div>
									</div>
								</div>
								<?php
									}
								?>
								<div class="clearfix"> </div>
							</div>
						</div>
						
											
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<!-- //top-brands -->
	<?php include 'layout/footer.php';?>

</body>
</html>