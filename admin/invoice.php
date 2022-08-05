<?php 
include '../dbconnect.php';
$orderids = $_GET['id'];
//menampilkan data invoice yang berdasarkan ID Order.
$liatcust = mysqli_query($conn,"select * from login l, cart c where orderid='$orderids' and l.userid=c.userid");
$list = mysqli_fetch_assoc($liatcust);
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice <?=$orderids?></title>
    
    <style> 
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 0px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 35px;
        line-height: 0px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 0px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
        text-align:center;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
        text-align:center;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;

    }
    
    .invoice-box table tr.total {
        border-top: 2px solid #eee;
        font-weight: bold;

    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="5">
                    <table>
                        <tr>
                            <td >
                                <h1 style="font-weight: bold"><?=strtoupper($web['nama'])?></h1>
                                <?=$web['alamat']?><br>
                                <?=$web['nohp']?> - <?=$web['email']?>
                            </td>
                            
                            <td>
                                Invoice : <b><?=$list['orderid']?></b><br>
                                Created : <b><?=date('M, d Y')?></b><br>
                                Due : <b><?=date('M, d Y',strtotime($list['tglorder'])) ?></b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="5">
                    <table>
                        <tr>
                            <td colspan="2">
                                <font style="font-size: 16px; font-weight: bold">Informasi Pelanggan :</font><br>
                                <font style="font-size: 16px;">
                                    Pelanggan : <?=$list['namalengkap']?><br>
                                    No Hp : <?=$list['notelp']?><br>
                                    Email : <?=$list['email']?><br>
                                </font>
                                <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td> No </td>
                <td> Nama Item </td>
                <td> Harga </td>
                <td> Qty </td>
                <td> Subtotal </td>
            </tr>
            
            <?php 
            $total=0; $no=1;
            //menampilkan data detail produk yang berdasarkan ID Order. 
            $brgs=mysqli_query($conn,"SELECT * from detailorder d, produk p
                                                where orderid = '$orderids' 
                                                and d.idproduk = p.idproduk 
                                                order by d.idproduk ASC");
            while($p = mysqli_fetch_array($brgs)){ 
            $total = $p['qty']*$p['harga'];
            ?>

            <tr class="item" >
                <td><?php echo $no++ ?></td>
                    <td><?php echo $p['namaproduk'] ?></td>
                    <td><?php echo $p['qty'] ?></td>
                    <td style="text-align:right">Rp. <?php echo number_format($p['harga']) ?></td>
                    <td style="text-align:right">Rp. <?php echo number_format($total) ?></td>
                </tr>
            </tr>
            <?php $akhir += $total; } ?>

            <tr class="total" >
                <td colspan="4" style="text-align: right;"><b>Ongkos Kirim</b></td>
                <td style="text-align: right;"> 
                    Rp. <?=number_format($list['ongkir'])?>
                </td>
            </tr>
            <tr class="total" >
                <td colspan="4" style="text-align: right;"><b>Grand Total</b></td>
                <td style="text-align: right;"> 
                    Rp. <?=number_format($akhir + $list['ongkir'])?>
                </td>
            </tr>
            
        </table>
        <br><br>
        <tr>
            <font  style="margin-left: 40px;"><?=$web['nama']?>, <?=date('d/m/Y')?></font>
            <br><br><br><br>
            <font  style="margin-left: 70px;"><?=$author?></font>
        </tr>
    </div>
</body>
</html>

<script type="text/javascript">
    // function PrintWindow() {                    
    //    window.print();            
    //    CheckWindowState();
    // }

    // function CheckWindowState()    {           
    //     if(document.readyState=="complete") {
    //         window.close(); 
    //     } else {           
    //         setTimeout("CheckWindowState()", 1000)
    //     }
    // }
    // PrintWindow();
</script>