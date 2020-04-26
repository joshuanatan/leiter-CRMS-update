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
      $content = '
      <html>
      <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <title>Invoice</title>
          <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
          <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      </head>
      
      <body style="font-family: font-family: Tahoma, Verdana, Segoe, sans-serif     ">
      <table>
            <tr>
              <td colspan="4"><img src="'.base_url().'assets/images/logo_leiter.png" width="155px"></td>
            </tr>
            <tr>
                <td style="text-align: right" colspan="2"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alamat Penagihan:</td>
            </tr>
            <br>
            <tr>
                <td style="width:100px">No. Invoice</td>
                <td style="width:200px"> : 1231231212312</td>
                <td colspan="2">PT. DASD ASF SDF</td>
            </tr>
            <tr>
                <td>Surat Jalan</td>
                <td> : 1231231212312</td>
                <td colspan="2">Jl. asf sf</td>
            </tr>
            <tr>
                <td style="width:100px">Tanggal</td>
                <td> : 1231231212312</td>
                <td colspan="2">Sidoarjo -Jatim</td>
            </tr>
            <tr>
                <td style="width:100px">Nomor Pembelian</td>
                <td> : 1231231212312</td>
                <td colspan="2">Telp. 3242342355 /23423</td>
            </tr>
            <tr>
                <td style="width:100px">Penyerahan</td>
                <td> : 1231231212312</td>
                <td colspan="2">att: Bpk. afsdffs</td>
            </tr>
            <br>
            <tr>
                <th colspan="4" style="text-align:center; font-size:14px; font-weight:bold">INVOICE</th>
            </tr>
            <br>
            <tr>
                <table border="1" style="border-collapse:collapse">
                    <tr>
                        <th style="text-align:center; font-weight:bold; width:26px; background-color:#9edfc2">No.</th>
                        <th style="text-align:center; font-weight:bold; width:270px; background-color:#9edfc2">Jenis Barang</th>
                        <th style="text-align:center; font-weight:bold; width:70px; background-color:#9edfc2">Jumlah</th>
                        <th style="text-align:center; font-weight:bold; width:80px; background-color:#9edfc2">Harga (IDR)</th>
                        <th style="text-align:center; font-weight:bold; width:83px; background-color:#9edfc2">Jumlah (IDR)</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="2">Total Sebelum PPN</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="2">PPN 10%</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="2" style="background-color: #9edfc2">TOTAL</td>
                        <td  style="background-color: #9edfc2">ddd</td>
                    </tr>
            </table>
            </tr>
            <br>
            <br>
            <table>
                <tr>
                    <td style="width: 150px">Pembayaran</td>
                    <td>: 14 hari setelah sadhfsdjhg</td>
                </tr>
                <tr>
                    <td>Jatuh Tempo</td>
                    <td>: 23.12.2010</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>: IDR 234.234.234</td>
                </tr>
                <tr>
                    <td>Rekening Pembayaran</td>
                    <td style="width:300px">: PT. LEITER Indonesia, Bank Central Asia (BCA)<br>&nbsp;
                    Rukan Grand Aries Niaga, Blok E1. No.2A-2B<br>&nbsp;
                    Jl. Taman Aries Meruya Utara, Jakarta Barat 11620<br>&nbsp;
                    No. Rekening: <b>4890-335-581</b>
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <tr colspan="4">
            <table style="width:400px;text-align:center">
                <tr>
                    <td colspan="4">******************************** PACKING LIST ********************************</td>
                </tr>
                <tr>
                    <td style="text-align:left">Box-No</td>
                    <td>Berat Bersih</td>
                    <td>Berat Kotor</td>
                    <td>Dimensi (L/W/H)</td>
                </tr>
                <tr>
                    <td style="text-align:left">01</td>
                    <td>17.231 kg</td>
                    <td>234 kg</td>
                    <td>35 * 35 * 34</td>
                </tr>
                <tr>
                    <td colspan="4">************************************************************************************</td>
                </tr>
                <tr>
                    <td  style="text-align:left" colspan="4">Total</td>
                </tr>
                <tr>
                    <td style="text-align:left">01</td>
                    <td>17.231 kg</td>
                    <td>234 kg</td>
                    <td>35 * 35 * 34</td>
                </tr>
            </table>
            </tr>
            <br>
            <br>
            <br>
            <table>
            <tr>
                <td colspan="">
                 
                </td>
                <td colspan="4" style="text-align:center">
                    Jakarta, 13 Jun 2019
                </td>
            </tr>
            <br>
            <tr>
                <td colspan="">

                </td>
                <td colspan="4"  style="text-align:center">
                    <br>
                    <br>
                    asdasdassda
                </td>
            </tr>
            </table>

            <table>
            <tr>
                <td style="color:green">
                <hr>
                PT LEITER INDONESIA<br>
                <span style="font-size:8px">Ruku Prominence Alam Sutera 38F/53-22 Jln. Jalur Sutera Prominence, Alam Sutera, Tangerang 15143 Banten - INDONESIA<br>Tel: 021-2958-6786 &nbsp;&nbsp; Fax: 021-29490663</span>
                </td>
            </tr>
           </table>
            
            
            
            
           </table>
           
        </body>
        </html>
      
      
      
      ';
//font
//writehtml
      //$obj_pdf->SetFont(Courier','', 8); //untuk font, liat dokumentasui
      $obj_pdf->writeHTML($content); //yang keluarin html nya. Setfont nya harus diatas kontennya


      ob_end_clean();
      $namafile = "a";
      $obj_pdf->Output($namafile, 'I'); //nama file
      ob_end_flush();

?>
