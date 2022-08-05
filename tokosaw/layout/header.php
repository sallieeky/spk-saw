
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Falenda Flora, Ruben Agung Santoso" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- <link href="https://www.w3schools.com/w3css/4/w3.css" rel="stylesheet" type="text/css" media="all" /> -->
<style>
.mySlides {display:none;}
</style>
<!-- font-awesome icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<!-- js -->
<script src="js/jquery-1.11.1.min.js"></script>
<!-- //js -->
<link href='//fonts.googleapis.com/css?family=Raleway:400,100,100italic,200,200italic,300,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script> 
<script type="text/javascript" src=""></script> 
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<!-- start-smoth-scrolling -->
</head>
	
<body>
<!-- header -->
	<div class="agileits_header">
		<div class="container">
			<div class="w3l_offers">
				<p><?=strtoupper($web['tagline'])?></p>
			</div>
			<div class="agile-login">
				<ul>
				<?php
				if(!isset($_SESSION['log'])){
					echo '
					<li><a href="registered.php"> Daftar</a></li>
					<li><a href="login.php">Masuk</a></li>
					';
				} else {
					
					if($_SESSION['role']=='Member'){
					echo '
					<li style="color:white">Halo, '.$_SESSION["name"].'
					<li><a href="logout.php">Keluar?</a></li>
					';
					} else {
					echo '
					<li style="color:white">Halo, '.$_SESSION["name"].'
					<li><a href="admin">Admin Panel</a></li>
					<li><a href="logout.php">Keluar?</a></li>
					';
					};
				}
				?>
					
				</ul>
			</div>
			<div class="product_list_header">  
				<?php if($_SESSION['log'] == 'Logged' and $_SESSION['role'] == 'Member'){ ?>
					<a href="cart.php"><button class="w3view-cart" type="submit" name="submit" value=""><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button>
					 </a>
				<?php } ?>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>

	<div class="logo_products">
		<div class="container">
		<div class="w3ls_logo_products_left1">
				<ul class="phone_email">
					<li><i class="fa fa-phone" aria-hidden="true"></i>Hubungi Kami : <?=$web['nohp']?></li>
				</ul>
			</div>
			<div class="w3ls_logo_products_left">
				<h1><a href="index.php"><?=strtoupper($web['nama'])?></a></h1>
			</div>
		<div class="w3l_search">
			<form action="kategori.php" method="get">
				<input type="search" name="key" placeholder="Cari produk..." value="<?=isset($_GET['key'])?$_GET['key']:''?>">
				<input type="hidden" name="idkategori" value="all">
				<button type="submit" class="btn btn-default search" aria-label="Left Align">
					<i class="fa fa-search" aria-hidden="true"> </i>
				</button>
				<div class="clearfix"></div>
			</form>
		</div>
			
			<div class="clearfix"> </div>
		</div>
	</div>
<!-- //header -->
<!-- navigation -->
	<div class="navigation-agileits">
		<div class="container">
			<nav class="navbar navbar-default">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header nav_2">
					<button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div> 
				<div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
					<ul class="nav navbar-nav">
						<li class="active"><a href="index.php" class="act">Home</a></li>
						<li class="active"><a href="about.php" class="act">Tentang Kami</a></li>
						<li class="active"><a href="howto.php" class="act">Cara Order</a></li>	
						<?php if (isset($_GET['idkategori'])) { ?>
						<li class="active"><a href="kategori.php?idkategori=all" class="act">Produk</a></li>	
						<?php } ?>
						<?php if (!isset($_GET['idkategori'])) { ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Kategori Produk<b class="caret"></b></a>
							<ul class="dropdown-menu multi-column columns-3">
								<div class="row">
									<div class="multi-gd-img">
										<ul class="multi-column-dropdown">
											<li><a href="kategori.php?idkategori=all">Semua Kategori</a></li>
											<?php 
											$kat=mysqli_query($conn,"SELECT * from kategori order by idkategori ASC");
											while($p=mysqli_fetch_array($kat)){  ?>
											<li><a href="kategori.php?idkategori=<?php echo $p['idkategori'] ?>"><?php echo $p['namakategori'] ?></a></li>
																	
											<?php } ?>
										</ul>
									</div>	
									
								</div>
							</ul>
						</li>
						
						<?php } ?>
						<?php
						if($_SESSION['log'] == 'Logged' and $_SESSION['role'] == 'Member'){ ?>
							
							

							<li>
								<a href="!#" class="dropdown-toggle"id="about-us" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Profile <span class="caret"></span></a>
								<ul class="dropdown-menu" aria-labelledby="about-us">
								<li><a href="daftarorder.php">Daftar Order</a></li>
								<li><a href="profile.php">Profile</a></li>
								</ul>
							</li>
							<li><a href="cart.php">Keranjang Saya</a></li>
						<?php } ?>
					</ul>
				</div>
				</nav>
			</div>
		</div>
		