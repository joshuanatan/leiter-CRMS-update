<? header("Content-Type: application/vnd.ms-word");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Report.doc");
?>
<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <title>Print Order Confirmation</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/print/css/laporan.css')?>"/>
    <link href="<?php echo base_url().'assets/print/css/style.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/print/css/font-awesome.css'?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url().'assets/print/css/4-col-portfolio.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/print/css/dataTables.bootstrap.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/print/css/jquery.dataTables.min.css'?>" rel="stylesheet">
    <style type="text/css">
        @media screen {
            div#footer_wrapper {
            }
          }

          @media print {
            tfoot { visibility: hidden; }

            div#footer_wrapper {
              margin: 0px 2px 0px 7px;
              position: fixed;
              bottom: 0;
              height: 80px;

            }

            div#footer_content {
              color: green;
            }

            tr.vendorListHeading {
                -webkit-print-color-adjust: exact; 
            }

            th.totalTab {
                -webkit-print-color-adjust: exact; 
            }

          }
    </style>
</head>
<body>
    <?php
        function tgl_indo($tanggal){
            $bulan = array (
                1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
            $pecahkan = explode('-', $tanggal);
            
            // variabel pecahkan 0 = tanggal
            // variabel pecahkan 1 = bulan
            // variabel pecahkan 2 = tahun
         
            return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
        }
    ?>
<div id="laporan" class="container" style="padding-left: 50px;padding-right: 50px;">


<div class="row">
<table border="0" align="center" style="width:900px; border:none;margin-top:5px;margin-bottom:0px;align-content: flex-start;">
    <tr>
        <img width="150px" src="<?php echo base_url().'assets/print/img/leiter.jpg'?>" alt="gambar" class="bg" /> 
    </tr>                   
</table>
</div>

<div class="row">
<div class="col-lg-12" style="padding-bottom:20px;padding-top: 20px;">
    <table border="0" align="left" style="font-size: 14px;border: none; text-align: left;padding-left: 20px;width: 900px;margin-left: 15px;">
        <?php
            /*foreach ($order->result_array() as $a) {
                $id=$a['order_id'];
                $no=$a['order_no'];
                $order_date=$a['order_date'];
                $cname=$a['customer_name'];
                $caddress=$a['c_inv_address'];
                $contact=$a['contact_name'];*/
            ?>
        <!--<tr>
            <td colspan="3"><?php echo 'Tangerang, '.date("d F Y", strtotime($podate)); ?></td>
        </tr>-->
        <tr>
            <td style="width: 300px;padding-left: 3px;" valign="top">
                <b><?php //echo $cname; ?></b><br>
                <?php //echo str_replace("\n", "<br/>", $caddress); ?><br>
                Up : <?php //echo $contact; ?>
            </td> 
            <td style="width: 600px;text-align: right;" valign="top">
                <?php //echo tgl_indo(date('Y-m-d')); ?>
            </td>  
        </tr>
   
        <?php
           // }
        ?>            
    </table>
</div>
</div>

<div class="row">
<table border="0" align="center" style=" border:none;margin-top:10px;margin-bottom:0px;font-family: Meiryo;width: 900px;">
    <tr>
        <th style="font-size: 25px;text-align: center;padding-top: 30px;"><u>Order Konfirmasi</u></th>
    </tr>
    <tr>
        <td style="font-size: 20px;text-align: center;" valign="top"><?php //echo $no; ?></td>
    </tr>                     
</table>
</div>


<div class="row">
<div class="col-lg-12" style="padding-bottom:40px;padding-top: 20px;">
    <table border="0" align="left" style="font-size: 14px;border: none; text-align: left;width: 900px;margin-left: 15px;">
        <?php
            /*foreach ($order->result_array() as $a) {
                $id=$a['order_id'];
                $no=$a['order_po_nomor'];*/
            ?>
        <!--<tr>
            <td colspan="3"><?php // echo 'Tangerang, '.date("d F Y", strtotime($podate)); ?></td>
        </tr>-->
        <tr>
            <td style="padding-right: 80px;width: 200px;">Salesman</td>
            <td style="padding-right: 5px;">: </td> 
            <td style="">Robert Cau (Bob@leiter.co.id)</td>  
        </tr>
        <tr>
            <td style="padding-right: 20px;">Nomor PO</td>
            <td>: </td> 
            <td><?php //echo $no; ?></td>  
        </tr>    
        <?php
           // }
        ?>            
    </table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-bottom:40px;padding-top: 17px;">
    <table border="0" align="left" style="font-size: 14px;border: none; text-align: left;width: 900px;margin-left: 15px;">
        <?php
            /*foreach ($order->result_array() as $a) {
                $id=$a['order_id'];
                $no=$a['order_no'];
                $date=$a['order_date'];
                $kurs=$a['order_kurs'];
                */
            ?>
        <!--<tr>
            <td colspan="3"><?php echo 'Tangerang, '.date("d F Y", strtotime($podate)); ?></td>
        </tr>-->
        <tr>
            <td >Dear Bapak / Ibu yang kami hormati,</td> 
        </tr>
        <tr>
            <td style="padding-top: 10px;">Kami mengucapkan terima kasih untuk order yang telah kami terima pada tanggal <?php //echo tgl_indo($date); ?></td>
        </tr> 
        <tr>
            <td>Berikut adalah surat konfirmasi untuk pemesanan barang yang telah kami terima : </td>
        </tr> 
        <?php
           // }
        ?>               
    </table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-top: 15px;">
<table align="left" class="table table-condensed" style="font-size:13px;width: 850px;margin-top: 10px;margin-bottom: 16px;margin-left: 15px;" id="">
    <thead>    
        <tr style="">
            <th style="text-align:center;width:40px;border: 1px solid #000;padding: 5px;">No.</th>
            <th style="text-align:center;border: 1px solid #000;padding: 5px;">Description</th>
            <th style="text-align:center;width:60px;border: 1px solid #000;padding: 5px;">Qty</th>
            <th style="text-align:center;width:160px;border: 1px solid #000;padding: 5px;">Harga<?php //echo '('.$kurs.')'; ?></th>
            <th style="text-align:center;width:160px;border: 1px solid #000;padding: 5px;">Jumlah<?php //echo '('.$kurs.')'; ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        /*
            $no=0;
            $subtotal=0;
            foreach ($product->result_array() as $a):
                $no++;
                $id=$a['product_id'];
                $bn=$a['product_bn'];
                $desc=$a['product_desc'];
                $price=$a['det_price'];
                $qty=$a['det_qty'];
                $total=$a['det_amount'];

                $subtotal = $subtotal+$total;
                */
        ?>
        <tr>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"><?php //echo $no;?></td>
            <td style="border: 1px solid #000;padding: 5px;"><?php //echo $desc;?></td>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"><?php //echo $qty;?></td>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"><?php //echo number_format($price);?></td>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"><?php //echo number_format($total);?></td>
        </tr>
        <?php //endforeach;?>
        <tr>
            <th style="text-align:right;border: 1px solid #000;padding: 5px;" colspan="4">Total</th>
            <th style="text-align:center;border: 1px solid #000;padding: 5px;"><?php //echo number_format($subtotal);?></th>
        </tr>
    </tbody>  
</table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-bottom:20px;">
<table align="left" style="font-size: 14px;border: none; text-align: left;width: 900px;margin-left: 15px;">
    <?php
            /*foreach ($order->result_array() as $a) {
                $id=$a['quo_id'];
                $qno=$a['quo_no'];
                $date=$a['quo_date'];
                $nm=$a['customer_name'];
                $address=$a['c_deliv_address'];
                $cnm=$a['contact_name'];
                $hal=$a['quo_hal'];
                $pengiriman=$a['quo_pengiriman'];
                $pembayaran=$a['quo_pembayaran'];
                $franco=$a['quo_franco'];*/
            ?>
    <tr>
        <td style="width: 240px;">Penyerahan Barang</td>
        <td> :</td>
        <td style="padding-left: 5px;">Franco <?php //echo $franco; ?></td>
    </tr>
    <tr>
        <td style="width: 240px;">Tanggal Penyerahan Barang</td>
        <td> :</td>
        <td style="padding-left: 5px;"><?php //echo $pengiriman; ?></td>
    </tr>
    <tr>
        <td style="width: 240px;">Pembayaran</td>
        <td> :</td>
        <td style="padding-left: 5px;"><?php //echo $pembayaran; ?></td>
    </tr>
    <?php
            //}
        ?>
</table>
</div>
</div>


<div class="row">
<div class="col-lg-12" style="padding-bottom:30px;padding-top: 30px;">
<table align="left" style="border: none; font-size: 14px;text-align: left;padding-top: 30px;width: 900px;margin-left: 15px;">
    <tr>
        <td style="padding-top: 40px;">Hormat kami,</td>
    </tr>
    <tr>
        <td style="font-size: 20px; padding-top: 60px;">Darus</td>
    </tr>  
    <tr>
        <td style="font-size: 14">PT LEITER Indonesia</td>
    </tr>
</table>
</div>
</div>

<div id="footer_wrapper">
    <div id="footer_content">
        <div class="col-lg-16" style="padding-left:0px;padding-right:30px;">
        <table align="left" style="width: 900px; padding-left:20px;padding-right:30px;border: none; font-size: 12px;text-align: left;">
            <tr>
                <hr style="border-width: 1px;border-color: green;width: 1300px;">
            </tr>
            <tr>
                <td style="font-size: 16px;color: green";>PT. LEITER Indonesia</td>
            </tr>
            <tr>
                <td style="color: green;">Ruko Prominence Alam Sutera 38F / 53 Jln. Jalur Sutera Prominence Alam Sutera, Tangerang 15143 Banten - INDONESIA<br>Telp. 021-29586786 Fax. 021-29490663</td>
            </tr>  
            
        </table>
        </div>
    </div>
</div>

</div>
<script src="<?php echo base_url().'assets/print/js/jquery.js'?>"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url().'assets/print/js/dataTables.bootstrap.min.js'?>"></script>
<script src="<?php echo base_url().'assets/print/js/jquery.dataTables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/print/js/bootstrap-datetimepicker.min.js'?>"></script>
<script type="text/javascript">
        $(document).ready(function() {
            $('#mydata').DataTable();
        } );
    </script>
</body>
</html>