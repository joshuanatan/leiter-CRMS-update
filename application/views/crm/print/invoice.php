<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Print Invoice</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php //echo base_url('assets/print/css/laporan.css')?>"/>
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
<div id="laporan" class="container" style="padding-left: 20px;padding-right: 10px;">


<div class="row">
<table border="0" align="center" style="width:900px; border:none;margin-top:5px;margin-bottom:0px;align-content: flex-start;">
    <tr>
        <img width="150px" src="<?php echo base_url().'assets/print/img/leiter.jpg'?>" alt="gambar" class="bg" /> 
    </tr>                   
</table>
</div>

<?php
            /*foreach ($dataInvoice->result_array() as $a) {
                $noInvoice=$a['invoice_no'];
                $suratJalan=$a['surat_jalan'];
                $tempo=$a['invoice_tempo'];
                $ttd=$a['invoice_ttd'];
                $invoiceDate=$a['invoice_date'];
            }*/
            ?>

<div class="row">
<div class="col-lg-12" style="padding-bottom:20px;padding-top: 30px;">
    <table border="0" align="left" style="font-size: 14px;border: none; text-align: left;padding-right: 20px;font-family: Meiryo;width: 900px;">
        <?php
        /*
            foreach ($invoice2->result_array() as $a) {
                $id=$a['order_id'];
                $orderNo=$a['order_po_nomor'];
                $order_date=$a['order_date'];
                $cname=$a['customer_name'];
                $caddress=$a['c_inv_address'];
                $contact=$a['contact_name'];
                $contactposition=$a['contact_position'];
                // $suratjalan=$a['surat_jalan'];
                $tanggaldelivery=$a['delivery_date'];
                $franco=$a['quo_franco'];
                //$kurs=$a['order_kurs'];*/
            ?>
        <!--<tr>
            <td colspan="3"><?php// //echo 'Tangerang, '.date("d F Y", strtotime($podate)); ?></td>
        </tr>-->
        <tr>
            <td style="width: 380px;text-align: left;" valign="top" >
            </td> 
            <td style="width: 300px;text-align: left;padding-left: 100px;" valign="top" >
                Alamat Penagihan :
            </td> 
        </tr>
        <tr>
            <td style="width: 500px;padding-left: 3px;padding-top: 15px;" valign="top">
                <table style="font-size: 14px;border: none;">
                    <tr>
                        <td>No Invoice</td>
                        <td style="padding-left: 20px;"> : <?php //echo $noInvoice; ?></td>
                    </tr>
                    <tr>
                        <td>Surat Jalan</td>
                        <td style="padding-left: 20px;"> : <?php //echo $suratJalan; ?></td>
                    </tr>

                    <tr>
                        <td>Tanggal</td>
                        <td style="padding-left: 20px;"> : <?php //echo date("d/m/Y", strtotime($tanggaldelivery)); ?></td>
                    </tr>
                    <tr>
                        <td>Nomor Pembelian</td>
                        <td style="padding-left: 20px;"> : <?php //echo $orderNo; ?></td>
                    </tr>
                    <tr>
                        <td>Penyerahan</td>
                        <td style="padding-left: 20px;"> : Franco <?php //echo $franco; ?></td>
                    </tr>
                </table>
            </td>
            <td style="width: 400px;padding-left: 100px;padding-top: 15px;" valign="top">
                <?php //echo $cname; ?><br>
                <?php //echo str_replace("\n", "<br/>", $caddress); ?><br>
                UP : <?php //echo $contactposition; ?>
            </td> 
        </tr>
   
        <?php
            //}
        ?>            
    </table>
</div>
</div>

<div class="row">
<table border="0" style="border:none;padding-top:15px;margin-bottom:0px;font-family: Meiryo;width: 900px;text-align: center;">
    <tr>
        <td style="font-size: 28px;padding-left: 90px;">INVOICE</td>
    </tr>                    
</table>
</div>


<div class="row">
<div class="col-lg-12" style="padding-top: 15px;">
<table align="left" class="table table-condensed" style="font-size:14px;border-color: solid #000;font-family: Meiryo;width: 950px;" id="">
    <thead>    
        <tr class="vendorListHeading" style="background: #c1e597;">
            <?php
            //foreach ($invoice2->result_array() as $a) {
             //   $kurs=$a['order_kurs'];}
            ?>
            <th style="text-align:center;width:40px;border: 1px solid #000;padding: 5px;">No.</th>
            <th style="text-align:center;border: 1px solid #000;padding: 5px;">Jenis Barang</th>
            <th style="text-align:center;width:100px;border: 1px solid #000;padding: 5px;">Jumlah</th>
            <th style="text-align:center;width:100px;border: 1px solid #000;padding: 5px;">Harga<?php //echo '('.$kurs.')'; ?></th>
            <th style="text-align:center;width:100px;border: 1px solid #000;padding: 5px;">JUMLAH<?php //echo '('.$kurs.')'; ?></th>
        </tr>
    </thead>
    <tbody >
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

                $subtotal = $subtotal+$total;
                $ppn = $subtotal*10/100;
                $subtotal2 = $subtotal+$ppn;*/
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
            <td style="border: 1px solid #000;"> </td>
            <td style="border: 1px solid #000;"> </td>
            <td style="text-align:left;border: 1px solid #000;padding: 5px;" colspan="2">Total Sebelum PPN</td>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"><?php //echo number_format($subtotal);?></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000;"></td>
            <td style="border: 1px solid #000;"></td>
            <td style="text-align:left;border: 1px solid #000;padding: 5px;" colspan="2">PPN 10%</td>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"><?php //echo number_format($ppn);?></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000;"></td>
            <td style="border: 1px solid #000;"></td>
            <th class="totalTab" style="text-align:left;border: 1px solid #000;background: #c1e597;padding: 5px;" colspan="2">TOTAL</th>
            <th class="totalTab" style="text-align:center;border: 1px solid #000;background: #c1e597;padding: 5px;"><?php //echo number_format($subtotal2);?></th>
        </tr>
    </tbody>  
</table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-bottom:20px;">
<table align="left" style="font-size: 14px;border: none; text-align: left;font-family: Meiryo;width: 900px;margin-top: 20px;">
    <?php /*
            foreach ($invoice2->result_array() as $a) {
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
                */
            ?>
    <tr>
        <td style="width: 240px;">Pembayaran</td>
        <td> :</td>
        <td style="padding-left: 5px;"><?php //echo $pembayaran; ?></td>
    </tr>
    <tr>
        <td style="width: 240px;">Jatuh tempo</td>
        <td> :</td>
        <td style="padding-left: 5px;"><?php //echo $tempo; ?></td>
    </tr>
    <tr>
        <td style="width: 240px;">Total</td>
        <td> :</td>
        <td style="padding-left: 5px;"><?php //echo $kurs.' '.number_format($subtotal2); ?></td>
    </tr>
    <tr>
        <td style="width: 240px;" valign="top">Rekening Pembayaran</td>
        <td valign="top"> :</td>
        <td style="padding-left: 5px;">
            PT. LEITER Indonesia, Bank Central Asia (BCA)<br>
            Rukan Grand Ariew Niaga, Blok E1 No.2A-2B<br>
            Jl. Taman Aries Meruya Utara, Jakarta Barat 11620<br>
            No. Rekening : <b>4890-335-581</b>
        </td>
    </tr>
    <?php
            //}
        ?>
</table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-bottom:10px;padding-left: 100px;">
<table align="left" style="font-size: 14px;border: none; text-align: left;font-family: Meiryo;width: 900px;">
    <tr>
        <td style="width: 280px;" colspan="4">**************************** PACKING LIST ****************************</td>
    </tr>
    <tr>
        <td style="padding-left: 15px;width: 100px;">Box-No</td>
        <td style="width: 170px;">Berat Bersih</td>
        <td style="width: 170px;">Berat Kotor</td>
        <td style="">Dimensi (L/W/H)</td>
    </tr>
    <?php
            /*$nomor=0;
            foreach ($packing->result_array() as $a) {
                $invoiceId=$a['invoice_id'];
                $transId=$a['transaction_id'];
                $boxNo=$a['box_no'];
                $beratBersih=$a['berat_bersih'];
                $beratKotor=$a['berat_kotor'];
                $dimensiL=$a['dimensi_l'];
                $dimensiW=$a['dimensi_w'];
                $dimensiH=$a['dimensi_h'];
                $dimensiSatuan=$a['dimensi_satuan'];
                $nomor++;
                */
            ?>
            
            <tr>
                <td style="padding-left: 15px;"><?php //echo $boxNo; ?></td>
                <td><?php //echo $beratBersih; ?></td>
                <td style=""><?php //echo $beratKotor; ?></td>
                <td style=""><?php //echo $dimensiL.' * '.$dimensiW.' * '.$dimensiH.'  '.$dimensiSatuan; ?></td>
            </tr>

            <?php
            //}
        ?>
            <tr>
                <td style="width: 280px;" colspan="4">********************************************************************&nbsp&nbsp</td>
            </tr>

            <tr>
                <td style="padding-left: 15px;" colspan="4">Total</td>
            </tr>

            <tr>
                <td style="padding-left: 15px;"><?php //echo $nom; ?></td>
                <td><?php //echo $tbb; ?></td>
                <td style=""><?php //echo $tbk; ?></td>
                <td style=""><?php //echo $dl.' * '.$dw.' * '.$dh.'  '; ?></td>
            </tr>
</table>
</div>
</div>


<div class="row">
<div class="col-lg-12" style="padding-bottom:30px;padding-top: 0px;text-align: right;">
<table align="left" border="0" style="border: none; font-size: 14px;text-align: left;padding-top: 10px;font-family: Meiryo;width: 900px;">
    <tr>
        <td style="padding-top: 20px;text-align: right;">Tangerang, <?php //echo tgl_indo($invoiceDate); ?></td>
    </tr>
    <tr>
        <td style="padding-top: 120px;text-align: right;"><?php //echo $ttd; ?></td>
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