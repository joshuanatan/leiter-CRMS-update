<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Print Quotation</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/print/css/laporan.css')?>"/>
    
    <link href="<?php echo base_url().'assets/print/css/style.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/print/css/font-awesome.css'?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url().'assets/print/css/4-col-portfolio.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/print/css/dataTables.bootstrap.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/print/css/jquery.dataTables.min.css'?>" rel="stylesheet">
    <style>
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

            div#quotation {
              
            }


            @page {
                padding-bottom: 300px;
            }

            .page-break { display: block; page-break-before: always;

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
<div class="container" id="quotation" style="padding-left: 60px;padding-bottom: 60px;width: 900px;">

<div class="row">
<table border="0" align="center" style="width:900px; border-bottom:none;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <img width="200px" src="<?php echo base_url().'assets/print/img/leiter.jpg'?>"/> 
    </tr>                   
</table>
</div>

<div class="row">
<div class="col-lg-12" style="padding-right:0px;padding-bottom:30px;padding-top: 10px;">
    <table border="0" align="left" style="padding-left:20px;padding-right:80px;border: none; font-size: 15px;text-align: left;width: 900px;">
        <?php
            /*foreach ($quot->result_array() as $a) {
                $id=$a['quo_id'];
                $qno=$a['quo_no'];
                $date=$a['quo_date'];
                $nm=$a['customer_name'];
                $address=$a['c_deliv_address'];
                $cnm=$a['contact_name'];
                $hal=$a['quo_hal'];
                $pengiriman=$a['quo_pengiriman'];
                $pembayaran=$a['quo_pembayaran'];
                $franco=$a['quo_franco'];
                $kurs=$a['quo_kurs'];*/
            ?>
        <tr>
            <td colspan="3"><?php //echo 'Tangerang, '.tgl_indo($date); ?></td>
        </tr>
        <tr>
            <th style="padding-right: 20px;padding-top: 20px;width: 20px;">No</th>
            <th style="padding-right: 5px;padding-top: 20px;width: 5px;">: </th> 
            <th style="padding-top: 20px;"><?php //echo $qno; ?></th>  
        </tr>
        <tr>
            <th style="padding-right: 20px;">Hal</th>
            <th>: </th> 
            <th><?php //echo $hal; ?></th>  
        </tr>
        <tr>
            <td colspan="3" style="padding-top: 25px;"><?php //echo '<b>Kepada Yth.</b><br>'.$nm.'<br>'.str_replace("\n", "<br/>", $address); ?></td>
        </tr>
        <tr>
            <th style="padding-right: 20px;padding-top: 20px;">Up</th>
            <th style="padding-right: 5px;padding-top: 20px;">: </th> 
            <th style="padding-top: 17px;"><?php //echo $cnm; ?></th>  
        </tr>       
        <?php
            //}
        ?>            
    </table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-left:0px;padding-right:80px;padding-bottom:30px;padding-top: 5px;">
<table align="left" style="padding-left:20px;padding-right:80px; padding-bottom: 20px;border: none; font-size: 15px;text-align: left;width: 900px;">
    <tr>
        <td style="padding-top: 8px;">Dengan hormat,</td>
    </tr>
    <tr>
        <td style="padding-top: 10px;">Memenuhi kebutuhan Bapak, dengan ini kami ajukan penawaran harga sebagai berikut :</td>
    </tr>  
</table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-left:20px;padding-right:80px;padding-top: 15px;">
<table align="left" class="table table-condensed" style="font-size:15px;color: #000;border-collapse: collapse;" id="">
    <thead>    
        <tr>
            <th style="text-align:center;width:30px;border: 1px solid #000;padding: 5px;">No.</th>
            <th style="text-align:center;border: 1px solid #000;width: 370px;">Description</th>
            <th style="text-align:center;width:60px;border: 1px solid #000;">Qty</th>
            <th style="text-align:center;width:160px;border: 1px solid #000;">Price<?php //echo '('.$kurs.')'; ?></th>
            <th style="text-align:center;width:160px;border: 1px solid #000;">Amount<?php //echo '('.$kurs.')'; ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $no=0;
            $subtotal=0;
            /*foreach ($product->result_array() as $a):
                $no++;
                $id=$a['product_id'];
                $bn=$a['product_bn'];
                $desc=$a['product_desc'];
                $price=$a['det_price'];
                $qty=$a['det_qty'];
                $total=$a['det_amount'];

                $subtotal = $subtotal+$total;*/
        ?>
        <tr>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"><?php// echo $no;?></td>
            <td style="border: 1px solid #000;padding: 5px;"><?php //echo $bn;?></td>
            <td style="text-align:center;border: 1px solid #000;"><?php //echo $qty;?></td>
            <td style="text-align:center;border: 1px solid #000;"><?php //echo number_format($price);?></td>
            <td style="text-align:center;border: 1px solid #000;"><?php //echo number_format($total);?></td>
        </tr>
        <?php //endforeach;?>
        <tr>
            <th style="text-align:right;border: 1px solid #000;padding: 5px;" colspan="4">TOTAL</th>
            <th style="text-align:center;border: 1px solid #000;"><?php// echo number_format($subtotal);?></th>
        </tr>
    </tbody>  
</table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-left:0px;padding-right:80px;padding-bottom:20px;">
<table align="left" style="padding-left:25px;padding-right:80px; font-size: 15px;border: none; text-align: left;width: 900px;">
    <tr>
        <td style="padding-top: 15px;" colspan="3"><u>Hal-hal lain yang sehubungan dengan penawaran kami ini adalah :</u></td>
    </tr>
    <?php
            /*foreach ($quot->result_array() as $a) {
                $id=$a['quo_id'];
                $qno=$a['quo_no'];
                $date=$a['quo_date'];
                $nm=$a['customer_name'];
                $address=$a['c_deliv_address'];
                $cnm=$a['contact_name'];
                $hal=$a['quo_hal'];
                $pengiriman=$a['quo_pengiriman'];
                $pembayaran=$a['quo_pembayaran'];
                $franco=$a['quo_franco'];
                $tambahan=$a['quo_tambahan'];*/
            ?>
    <tr>
        <td style="padding-top: 10px;" colspan="3">1. Waktu pengiriman barang dalam kondisi normal :</td>
    </tr>
    <tr>
        <td style="padding-left: 20px;padding-top: 8px;" colspan="3">&bull; <?php// echo $pengiriman.' '; ?></td>
    </tr>
    <tr>
        <td style="width: 170px;padding-left: 20px;">&bull; Franco</td>
        <td> :</td>
        <td style="padding-left: 5px;"><?php //echo $franco; ?></td>
    </tr>
    <tr>
        <td style="width: 170px;padding-left: 20px;">&bull; Jadwal Produksi</td>
        <td> :</td>
        <td style="padding-left: 5px;">(Senin-Jumat), diluar hari libur</td>
    </tr>
    <tr>
        <td style="width: 170px;padding-left: 20px;">&bull; Jadwal Pengiriman</td>
        <td> :</td>
        <td style="padding-left: 5px;">(Senin-Jumat), diluar hari libur</td>
    </tr>
    <tr>
        <td style="padding-top: 10px;" colspan="3">2. Pembayaran : <?php //echo $pembayaran; ?></td>
    </tr>
    <?php
           // }
        ?>
    <tr>
        <td style="padding-top: 7px;" colspan="3">3. Harga tersebut di atas dalam Rupiah, <b>belum termasuk PPN 10%</b></td>
    </tr>
    <tr>
        <td style="padding-top: 7px;" colspan="3"><?php //echo str_replace("\n", "<br/>", $tambahan); ?></td>
    </tr>
</table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-left:0px;padding-right:80px;padding-bottom:30px;">
<table align="left" style="padding-left:25px;padding-right:80px;border: none; font-size: 15px;text-align: left;width: 900px;">
    <tr>
        <td style="padding-top: 25px;">Demikian surat penawaran kami ini, sambil menunggu kabar baik berikutnya dari Bapak.</td>
    </tr>
    <tr>
        <td>Terima kasih atas perhatiannya,</td>
    </tr>  

    <tr>
        <td style="padding-top: 50px;">Hormat kami,</td>
    </tr>
    <tr>
        <td style="font-family: Monotype Corsiva;font-size: 30px; padding-top: 60px;">Robert Cau</td>
    </tr>  
    <tr>
        <td>Sales Director</td>
    </tr>
</table>
</div>
</div>

<div id="footer_wrapper">
    <div id="footer_content">
        <div class="col-lg-16" style="padding-left:0px;padding-right:30px;">
        <table align="left" style="width: 900px; padding-left:20px;padding-right:30px;border: none; font-size: 12px;text-align: left;">
            <tr>
                <hr style="border-width: 1px;border-color: green;width: 900px;">
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
<script src="<?php echo base_url().'assets/print/js/bootstrap.min.js'?>"></script>
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