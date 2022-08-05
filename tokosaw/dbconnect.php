<?php 
//set time zone +7
date_default_timezone_set("Asia/Bangkok");
error_reporting(0);
// isi nama host, username mysql, dan password mysql anda
$conn = mysqli_connect("localhost","root","","tokosaw");

if(!$conn){
	echo "Gagal berkomunikasi dengan database";
	die();
}


//mengambil informasi toko di table config
$sqlweb = mysqli_query($conn,"SELECT * FROM config ");
$web 	= mysqli_fetch_assoc($sqlweb);
$author = 'Andy Kurnia';
$kampus = 'Politeknik Negeri Balikpapan';



saw();

if (isset($_GET['aksi'])) {
	if ($_GET['aksi'] == 'saverating') {
		$x 		= $_POST['rating'];

		$ex 	= explode('-', $x);
		$rating	= $ex[0];
		$detail = $ex[1];
		$waktu 	= date('Y-m-d H:i:s');

		$cek 	= mysqli_query($conn," SELECT * FROM rating where rating_detailorder = '$detail' ");
		if (mysqli_num_rows($cek) <= 0) {
			mysqli_query($conn," INSERT INTO rating (rating_id,rating_detailorder,rating,rating_waktu) VALUES ('','$detail','$rating','$waktu') ");
		}
		else
		{
			mysqli_query($conn," UPDATE rating SET rating = '$rating' where rating_detailorder = '$detail' ");
		}

		echo "oke";
	}
	


}
function saw()
{
	$conn = mysqli_connect("localhost","root","","tokosaw");
	$sql_penjualan 	= mysqli_fetch_object(mysqli_query($conn," SELECT * FROM kriteria where kriteria = 'penjualan' "));
	$sql_rasa 		= mysqli_fetch_object(mysqli_query($conn," SELECT * FROM kriteria where kriteria = 'rasa' "));
	$sql_harga 		= mysqli_fetch_object(mysqli_query($conn," SELECT * FROM kriteria where kriteria = 'harga' "));

	$b_penjualan 	= $sql_penjualan->bobot/100;
	$b_rasa 		= $sql_rasa->bobot/100;
	$b_harga 		= $sql_harga->bobot/100;

	mysqli_query($conn,"TRUNCATE penilaian ");
	$brg = mysqli_query($conn," SELECT * FROM produk order by idproduk ");
	while ($row = mysqli_fetch_object($brg)) {

		$nilai_akhir = 0;
		$akhir_harga = 0;
		$akhir_rasa  = 0;
		$akhir_jual  = 0;
		$n_harga 	 = 0;
		$n_jual 	 = 0;
		$n_rasa	 	 = 0;

		//mendapatkan jumlah rating yang diberikan pembeli
		$rating		= mysqli_fetch_object(mysqli_query($conn, " SELECT sum(rating) / count(idproduk) as rasa FROM rating 
											JOIN detailorder on detailorder.detailid = rating.rating_detailorder
											WHERE detailorder.idproduk = '$row->idproduk' " ));

		$rating_max	= mysqli_fetch_object(mysqli_query($conn, " SELECT sum(rating) / count(idproduk) as rasa FROM rating 
											JOIN detailorder on detailorder.detailid = rating.rating_detailorder
											GROUP BY detailorder.idproduk ORDER BY rasa desc limit 1" ));

		//mendapatkan data jumlah penjualan
		$list 		= mysqli_fetch_object(mysqli_query($conn, " SELECT sum(qty) as penjualan FROM detailorder 
											JOIN cart on detailorder.orderid = cart.orderid
											WHERE cart.status != 'waiting' 
											AND detailorder.idproduk = '$row->idproduk' " ));

		$list_max	= mysqli_fetch_object(mysqli_query($conn, " SELECT sum(qty) as penjualan FROM detailorder 
											JOIN cart on detailorder.orderid = cart.orderid
											WHERE cart.status != 'waiting'
                                            GROUP BY detailorder.idproduk ORDER BY penjualan desc LIMIT 1 " ));

		$harga_max 	= mysqli_fetch_object(mysqli_query($conn, " SELECT MIN(harga) as harga_max FROM detailorder 
											JOIN produk on detailorder.idproduk = produk.idproduk
                                            JOIN cart on detailorder.orderid = cart.orderid
											WHERE cart.status != 'waiting'
                                            ORDER BY harga_max desc  " ));

		$n_harga 	= $row->harga;
		$n_jual 	= isset($list->penjualan)?$list->penjualan:0;
		$n_rasa		= isset($rating->rasa)?number_format($rating->rasa,2):0;


		$normalisasi_harga 	= $harga_max->harga_max/$row->harga;
		$normalisasi_jual 	= isset($list->penjualan)?$list->penjualan/$list_max->penjualan:0;
		$normalisasi_rasa	= isset($rating->rasa)?$rating->rasa/$rating_max->rasa:0;

		$bobot_harga 	= number_format($normalisasi_harga*$b_harga,2);
		$bobot_jual 	= isset($list->penjualan)?number_format($normalisasi_jual*$b_penjualan,2):0;
		$bobot_rasa		= isset($rating->rasa)?number_format($normalisasi_rasa*$b_rasa,2):0;


		$db_harga	= number_format($normalisasi_harga,2).'-'.$bobot_harga;
		$db_jual	= number_format($normalisasi_jual,2).'-'.$bobot_jual;
		$db_rasa	= number_format($normalisasi_rasa,2).'-'.$bobot_rasa;

		$db_akhir 	= number_format($bobot_harga + $bobot_jual + $bobot_rasa,2);
		$wkt 		= date('Y-m-d H:i:s');

		
		mysqli_query($conn," INSERT INTO penilaian 
							(penilaian_id,penilaian_produk,penilaian_trs,penilaian_harga,penilaian_rasa,penilaian,penilaian_waktu)
							VALUES 
							('','$row->idproduk','$db_jual','$db_harga','$db_rasa','$db_akhir','$wkt') ");
	}
}
?>