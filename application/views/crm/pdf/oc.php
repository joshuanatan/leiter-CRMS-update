<?php
      ob_start();
      //include 'function_string.php';
      $obj_pdf = new Pdf('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $obj_pdf->SetCreator(PDF_CREATOR);


      //$obj_pdf->SetFont('Courier','B', 20);
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
      $obj_pdf->setPrintHeader(false);
      $obj_pdf->setPrintFooter(false);



      $obj_pdf->SetTitle("Invoice"); //buat judul file
      $obj_pdf->AddPage('P', 'A4'); //potrait sama ukuran L atau P

      //query
      
      //konten
$content = '<html lang="en">
<head>
    <title>Print Order Confirmation</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="'.base_url().'assets/print/css/laporan.css"/>
    <link href="'.base_url().'assets/print/css/style.css" rel="stylesheet">
    <link href="'.base_url().'assets/print/css/font-awesome.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="'.base_url().'assets/print/css/4-col-portfolio.css" rel="stylesheet">
    <link href="'.base_url().'assets/print/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="'.base_url().'assets/print/css/jquery.dataTables.min.css" rel="stylesheet">
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
        
<div id="laporan" class="container" style="padding-left: 50px;padding-right: 50px;">


<div class="row">
<table border="0" align="center" style="width:900px; border:none;margin-top:5px;margin-bottom:0px;align-content: flex-start;">
    <tr>
        <img width="150px" src="'.base_url().'assets/images/logo_leiter.png" alt="gambar" class="bg" /> 
    </tr>                   
</table>
</div>

<div class="row">
<div class="col-lg-12" style="padding-bottom:20px;padding-top: 20px;">
    <table border="0" align="left" style="font-size: 14px;border: none; text-align: left;padding-left: 20px;width: 900px;margin-left: 15px;">
        <!--<tr>
            <td colspan="3">Tangerang,</td>
        </tr>-->
        <tr>
            <td style="width: 300px;padding-left: 3px;" valign="top">
                <b></b><br>
                <br>
                Up : 
            </td> 
            <td style="width: 600px;text-align: right;" valign="top">
                
            </td>  
        </tr>

                
    </table>
</div>
</div>

<div class="row">
<table border="0" align="center" style=" border:none;margin-top:10px;margin-bottom:0px;font-family: Meiryo;width: 900px;">
    <tr>
        <th style="font-size: 25px;text-align: center;padding-top: 30px;"><u>Order Konfirmasi</u></th>
    </tr>
    <tr>
        <td style="font-size: 20px;text-align: center;" valign="top"></td>
    </tr>                     
</table>
</div>


<div class="row">
<div class="col-lg-12" style="padding-bottom:40px;padding-top: 20px;">
    <table border="0" align="left" style="font-size: 14px;border: none; text-align: left;width: 900px;margin-left: 15px;">
        
        <!--<tr>
            <td colspan="3"></td>
        </tr>-->
        <tr>
            <td style="padding-right: 80px;width: 200px;">Salesman</td>
            <td style="padding-right: 5px;">: </td> 
            <td style="">Robert Cau (Bob@leiter.co.id)</td>  
        </tr>
        <tr>
            <td style="padding-right: 20px;">Nomor PO</td>
            <td>: </td> 
            <td></td>  
        </tr>         
    </table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-bottom:40px;padding-top: 17px;">
    <table border="0" align="left" style="font-size: 14px;border: none; text-align: left;width: 900px;margin-left: 15px;">
       
        <!--<tr>
            <td colspan="3"></td>
        </tr>-->
        <tr>
            <td >Dear Bapak / Ibu yang kami hormati,</td> 
        </tr>
        <tr>
            <td style="padding-top: 10px;">Kami mengucapkan terima kasih untuk order yang telah kami terima pada tanggal</td>
        </tr> 
        <tr>
            <td>Berikut adalah surat konfirmasi untuk pemesanan barang yang telah kami terima : </td>
        </tr>          
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
            <th style="text-align:center;width:160px;border: 1px solid #000;padding: 5px;">Harga</th>
            <th style="text-align:center;width:160px;border: 1px solid #000;padding: 5px;">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        
        <tr>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"></td>
            <td style="border: 1px solid #000;padding: 5px;"></td>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"</td>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"></td>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"></td>
        </tr>
        <tr>
            <th style="text-align:right;border: 1px solid #000;padding: 5px;" colspan="4">Total</th>
            <th style="text-align:center;border: 1px solid #000;padding: 5px;"><th>
        </tr>
    </tbody>  
</table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-bottom:20px;">
<table align="left" style="font-size: 14px;border: none; text-align: left;width: 900px;margin-left: 15px;">
    
    <tr>
        <td style="width: 240px;">Penyerahan Barang</td>
        <td> :</td>
        <td style="padding-left: 5px;">Franco </td>
    </tr>
    <tr>
        <td style="width: 240px;">Tanggal Penyerahan Barang</td>
        <td> :</td>
        <td style="padding-left: 5px;"></td>
    </tr>
    <tr>
        <td style="width: 240px;">Pembayaran</td>
        <td> :</td>
        <td style="padding-left: 5px;"></td>
    </tr>
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
<script src="'.base_url().'assets/print/js/jquery.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="'.base_url().'assets/print/js/dataTables.bootstrap.min.js"></script>
<script src="'.base_url().'assets/print/js/jquery.dataTables.min.js"></script>
<script src="'.base_url().'assets/print/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
        } );
    </script>
</body>
</html>';

//font
//writehtml
      //$obj_pdf->SetFont(Courier','', 8); //untuk font, liat dokumentasui
      $obj_pdf->writeHTML($content); //yang keluarin html nya. Setfont nya harus diatas kontennya


      ob_end_clean();
      $namafile = "a";
      $obj_pdf->Output($namafile, 'I'); //nama file
      ob_end_flush();
      ?>
