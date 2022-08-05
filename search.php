<?php
session_start();
include 'dbconnect.php';

$s = $_POST['Search'];
?>
<!DOCTYPE html>
<html>
<head>
<title><?=$web['nama']?> - Pencarian</title>

<?php include 'layout/header.php';?>
		
<!-- //navigation -->
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Kategori</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!--- beverages --->
	<div class="products">
		<div class="container">
			<div class="col-md-4 products-left">
				<div class="categories">
					<h2>Categories</h2>
					<ul class="cate">
						
						
						<?php 
							$kat=mysqli_query($conn,"SELECT * from kategori order by idkategori ASC");
							while($p=mysqli_fetch_array($kat)){

								?>
							<li><a href="kategori.php?idkategori=<?php echo $p['idkategori'] ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i><?php echo $p['namakategori'] ?></a></li>
													
						<?php } ?>
							
					</ul>
				</div>																																												
			</div>
			<div class="col-md-8 products-right">
				<div class="agile_top_brands_grids">
				
				
				<?php 
					$brgs=mysqli_query($conn,"SELECT * from produk where namaproduk like '%$s%' or deskripsi like '%$s%' order by idproduk ASC");
					$x = mysqli_num_rows($brgs);
					
					if($x>0){
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
										<div class="snipcart-item block">
											<div class="snipcart-thumb">
												<a href="product.php?idproduk=<?php echo $p['idproduk'] ?>"><img src="images/produk/<?php echo $p['gambar']?>" width="200px" height="200px"></a>		
												<p><?php echo $p['namaproduk'] ?></p>
												<h4>Rp<?php echo number_format($p['hargaafter']) ?> <span>Rp<?php echo number_format($p['hargabefore']) ?></span></h4>
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
					} else {
						echo "Data tidak ditemukan, coba kata kunci lainnya";
					}
						?>
					
						<div class="clearfix"> </div>
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
<!--- beverages --->
<!-- //footer -->
<?php include 'layout/footer.php';?> 
</body>
</html>