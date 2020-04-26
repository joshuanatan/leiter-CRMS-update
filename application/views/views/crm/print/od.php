<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <title>Print Order Delivery</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/print/css/laporan.css')?>"/>
    <link href="<?php echo base_url().'assets/print/css/bootstrap.min.css'?>" rel="stylesheet">
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
<body onload="window.print()">
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
<div id="laporan" class="container" style="padding-left: 20px;padding-right: 20px;">

    <?php
        /*foreach ($pengiriman->result_array() as $a) {
            $delivId=$a['deliv_id'];
            $suratJalan=$a['surat_jalan'];
            $delivTanggal=$a['deliv_tanggal'];
            $delivStatus=$a['deliv_status'];

        }
        */
    ?>

<div class="row">
<div class="col-lg-12" style="padding-bottom:20px;padding-top: 20px;">
    <table border="0" align="left" style="font-size: 13px;border: none; text-align: left;padding-right: 20px;">
        <?php
            /*foreach ($delivery2->result_array() as $a) {
                $id=$a['order_id'];
                $orderNo=$a['order_no'];
                $order_date=$a['order_date'];
                $cname=$a['customer_name'];
                $caddress=$a['c_inv_address'];
                $contact=$a['contact_name'];
            */
            ?>
        <!--<tr>
            <td colspan="3"><?php //echo 'Tangerang, '.date("d F Y", strtotime($podate)); ?></td>
        </tr>-->
        <tr>
            <td style="width: 310px;padding-left: 3px;" valign="top" rowspan="2">
                <i>
                    <b style="font-size: 15px;">PT. LEITER INDONESIA</b><br>
                    Ruko Prominence Alam Sutera 38F / 53-55<br>
                    Jln. Jalur Sutera Prominence<br>
                    Alam Sutera, Tangerang 15143<br>
                    Banten INDONESIA
                </i>
            </td> 
            <td style="width: 200px;text-align: right;" valign="top">
                
            </td> 
            <td style="width: 300px;text-align: left;" valign="top">
                Tangerang, <?php //echo tgl_indo($delivTanggal); ?>
            </td>  
        </tr>

        <tr>
            <td style="width: 200px;text-align: right;" valign="top">
                Kepada Yth : 
            </td> 
            <td style="width: 300px;padding-left: 3px;" valign="top" rowspan="2">
                <?php //echo $cname; ?><br>
                <?php //echo str_replace("\n", "<br/>", $caddress); ?><br><br>
                <u>Up : <?php //echo $contact; ?></u>
            </td> 

        </tr>
   
        <?php
            //}
        ?>            
    </table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-left:50px;padding-right:80px;padding-top: 5px;">
<table align="left" style="padding-left:80px;padding-right:80px;border: none; font-size: 14px;text-align: left;">
    <tr>
        <td style="padding-top: 10px;"><b>SURAT JALAN No. : </b> <?php //echo $suratJalan; ?></td>
    </tr>  
</table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-top: 10px;">
<table align="left" style="font-size:13px;border-color: #000" rules="none" id="">
    <thead>    
        <tr >
            <th style="text-align:center;width:90px;border-bottom: 1px solid #000;border-right: 1px solid #000;padding: 3px;">Jumlah</th>
            <th style="text-align:center;width:100px;border-bottom: 1px solid #000;border-right: 1px solid #000">Unit</th>
            <th style="text-align:center;width: 560px;border-bottom: 1px solid #000;">Nama Barang</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            //$no=0;
            //$subtotal=0;
            //foreach ($product->result_array() as $a):
            //    $no++;
            //    $id=$a['product_id'];
            //    $bn=$a['product_bn'];
            //    $desc=$a['product_desc'];
             //   $price=$a['det_price'];
             //   $qty=$a['deliv_qty'];
             //   $total=$a['det_amount'];
            //    $unit=$a['product_unit'];

            //    $subtotal = $subtotal+$total;
        ?>
        <tr>
            <td style="text-align:center;border-right: 1px solid #000;padding-top: 5px;"><?php //echo $qty;?></td>
            <td style="text-align: center;border-right: 1px solid #000;padding-top: 5px;"><?php //echo $unit;?></td>
            <td style="text-align:left;padding-top: 5px;padding-left: 5px;"><?php //echo $desc;?></td>
        </tr>
        <?php// endforeach;?>
        <tr>
            <?php
            //foreach ($delivery2->result_array() as $a) {
            //    $orderNo=$a['order_po_nomor'];
            ?>
            <td style="text-align:center;border-right: 1px solid #000;padding-top: 10px;"></td>
            <td style="text-align: center;border-right: 1px solid #000;padding-top: 10px;"></td>
            <td style="text-align:left;padding-left: 5px;padding-top: 25px;padding-bottom: 14px;"><b>PO No : PO.<?php //echo $orderNo; ?></b></td>
            <?php //} ?>
        </tr>
    </tbody>  
</table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-bottom:30px;">
<table align="left" border="0" style="border: none; font-size: 14px;text-align: left;padding-top: 20px;">
    <tr>
        <td style="padding-top: 10px;padding-left: 80px;padding-right: 370px;" valign="top">TANDA TERIMA :</td>
        <td style="padding-top: 10px;text-align: center;">
            Hormat Kami,
            <br><br><br><br>
            <?php //echo $user; ?>
        </td>
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