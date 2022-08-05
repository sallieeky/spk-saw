<?php include '../dbconnect.php'; 
$bulan 	= $_POST['bulan'];
$sql 	= mysqli_query($conn, "SELECT * FROM detailorder 
								JOIN cart on detailorder.orderid = cart.orderid
								JOIN produk on detailorder.idproduk = produk.idproduk
								JOIN login on cart.userid = login.userid 
								WHERE month(cart.tglorder) = '$bulan'
								AND ( cart.status = 'Selesai' OR cart.status = 'Pengiriman')
								ORDER BY tglorder ASC
								 ");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Cetak Laporan Penjualan <?=$web['nama']?></title>
	<style type="text/css">
		@charset "utf-8";
		/* CSS Document */

		#logo{
			height: 120px;
			margin-bottom: 50px;
			width: 100%;
			border-top-style: none;
			border-right-style: none;
			border-bottom-style: none;
			border-left-style: none;
		}

		#title{
			float: none;
			font-weight: bold;
			text-transform: capitalize;
			color: #000;
			margin-bottom: 4px;
			font-size: 16pt;
			text-decoration: none;
			text-align: center;
		}

		#title-tanggal{
			float: none;
			font-weight: bold;
			text-transform: capitalize;
			color: #000;
			margin-bottom: 10px;
			font-size: 10pt;
			text-decoration: none;
			text-align: center;
		}

		#isi{
			font-size: 9pt;
		}

		#isi-table{
			padding: 0 0 0 3px;
		}

		.tr-title{
			font-size: 9pt;
			font-weight: bold;
			color: #000;
			background-color: #CCC;
		}

		#footer-tanggal{
			color: #000;
			margin-top: 40px;
			margin-left: 450px;
			font-size: 10pt;
		}

		#footer-jabatan{
			color: #000;
			font-size: 10pt;
			margin-left: 450px;
			margin-bottom: 70px;
		}

		#footer-nama{
			color: #000;
			font-size: 10pt;
			margin-left: 450px;
			text-decoration: underline;
			font-weight: bold;
		}

		body {
			font-family: Arial, Helvetica, sans-serif;
			color: #000;
			text-align: center;
		}
	</style>
</head>
<body>
	<div id="title">
       	<?=strtoupper($web['nama'])?><br>LAPORAN PENJUALAN
    </div>
    <?php $bln = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"); ?>
    <div id="title-tanggal">
        Periode Bulan <?= $bln[$bulan]; ?>
    </div>
    <hr>
    <br>
    <div id="isi">
        <table width="100%" border="1" cellpadding="0" cellspacing="0">
            <thead style="background:#e8ecee">
                <tr class="tr-title">
                    <th height="20" align="center" valign="middle">NO.</th>
                    <th height="20" align="center" valign="middle">KODE ORDER</th>
                    <th height="20" align="center" valign="middle">TANGGAL</th>
                    <th height="20" align="center" valign="middle">NAMA BARANG</th>
                    <th height="20" align="center" valign="middle">QTY</th>
                    <th height="20" align="center" valign="middle">SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
            	<?php 
            	$no = 1;
            	$total = 0;
            	if (mysqli_num_rows($sql) > 0) {
	            	while ($l = mysqli_fetch_array($sql)) { ?>
	            		
	            		<tr style="height: 20px">
	            			<td><?=$no++?></td>
	            			<td><?=$l['orderid']?></td>
	            			<td><?=date('H:i:s, d-m-Y',strtotime($l['tglorder']))?></td>
	            			<td><?=$l['namaproduk']?></td>
	            			<td><?=$l['qty']?></td>
	            			<td>Rp. <?=number_format($l['qty'] * $l['harga'])?></td>
	            		</tr>

	            	<?php $total += $l['qty'] * $l['harga']; } ?>
	            	
	            <?php } else { ?>
	            	<tr style="height: 40px">
	            		<td colspan="6"> Data tidak ditemukan </td>
	            	</tr>
	            <?php } ?>
            		<tr style="height: 20px">
	            		<td colspan="5"> Total Pendapatan </td>
	            		<td> <b>Rp. <?=number_format($total)?></b> </td>
	            	</tr>
        	</tbody>
        </table>
</body>
</html>
<script type="text/javascript">
    function PrintWindow() {                    
       window.print();            
       CheckWindowState();
    }

    function CheckWindowState()    {           
        if(document.readyState=="complete") {
            window.close(); 
        } else {           
            setTimeout("CheckWindowState()", 1000)
        }
    }
    PrintWindow();
</script> 