<?php foreach($purchaseorder->result() as $po): ?>
<?php
    $pdf = new Pdf_oc('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetTitle('PURCHASE ORDER');
    $pdf->SetTopMargin(30);
    $pdf->setFooterMargin(20);
    $pdf->SetAutoPageBreak(true,22);
    $pdf->SetAuthor('Author');
    $pdf->SetDisplayMode('real', 'default');
    $pdf->setPrintHeader(true);
      $pdf->setPrintFooter(true);
    $pdf->AddPage('P','A4');

    $fontname = TCPDF_FONTS::addTTFfont('../../../libraries/tcpdf/fonts/tahoma.ttf', 'TrueTypeUnicode', '', 96);
    $pdf->SetFont('Tahoma','', 9);

    $content='
    <html>
        <head>
        
        </head>
        <body style="font-family: Tahoma, Verdana, Segoe, sans-serif">
        <br>
        <br>
        <table>
            <tr>
                <th colspan="4" style="text-align:center; font-size:16px; font-weight:bold">PURCHASE ORDER</th>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:30px; font-weight:bold; font-size:10pt">Date.</td>
                <td style="font-weight:bold; font-size:9pt">: '.date("F j, Y",strtotime($po->date_po_core_add)).'</td>
            </tr>
            <tr>
                <td style="width:30px; font-weight:bold; font-size:10pt">Ref</td>
                <td style="font-weight:bold; font-size:9pt">: '.$po->no_po.'</td>
            </tr>
        </table>
        <br><br>
        <table>
            <tr>
                <td style="font-weight:bold; font-size:10pt; width:165px">PT Leiter Indonesia</td>
                <td style="font-size:9pt; width:45px">VENDOR:</td>
                <td style="font-weight:bold; font-size:10pt; width:150px">';
                
                foreach($vendor->result() as $x){
                    $content=$content.$x->nama_perusahaan;
                }
                
                $content=$content.'</td>
                <td style="font-size:9pt; width:40px">SHIP TO:</td>
                <td style="font-weight:bold; font-size:10pt; width:165px">';
                
                foreach($customer->result() as $y){
                    $content=$content.$y->nama_perusahaan;
                }
                
                $content=$content.'</td>
            </tr>
            <tr>
                <td style="font-size:9pt; width:165px">Ruko Prominence Alam Sutera F38/53-55
                <br>Jln. Jalur Sutera Prominence
                <br>Alam Sutera, Tangerang 15143 Banten
                <br>INDONESIA
                <br>Phone : +6221 2958 6786
                <br>Fax : +6221 2949 0663
                <br>Email : info@leiter.co.id
                </td>

                <td></td>

                <td style="font-size:9pt; width:150px">';
                
                foreach($vendor->result() as $x){
                    $content=$content.wordwrap(nl2br($x->alamat_perusahaan),50,"<br>\n",TRUE);
                }
                
                $content=$content.'
                <br>';
                
                foreach($vendor->result() as $x){
                    $content=$content.$x->notelp_perusahaan;
                }
                
                $content=$content.'
                <br>';
                
                foreach($vendor->result() as $x){
                    $content=$content.$x->nofax_perusahaan;
                }
                
                $content=$content.'
                </td>

                <td style="font-size:9pt"></td>

                <td style="font-size:9pt;width:165px">';
                
                foreach($customer->result() as $y){
                    $content=$content.nl2br($y->alamat_perusahaan);
                }
                
                $content=$content.'

                </td>
            </tr>
        </table>
<br><br>
        <table border="1" align="center">
            <tr>
                <th style="font-size:10pt; text-align:center; font-weight:bold; background-color:#dcdcdc">SHIPPING METHOD</th>
                <th style="font-size:10pt; text-align:center; font-weight:bold; background-color:#dcdcdc">SHIPPING TERMS</th>
                <th style="font-size:10pt; text-align:center; font-weight:bold; background-color:#dcdcdc">REQUIREMENT DATE</th>
            </tr>
            <tr>
                <td style="font-size:9pt; height:20px;line-height:20px;">By '.$po->shipping_method.'</td>
                <td>'.$po->shipping_term.'</td>
                <td style="font-size:9pt; height:20px;line-height:20px;background-color:yellow;">';
                
                $content=$content. date("F j, Y",strtotime($po->requirement_date)) .' in '.$po->destination.'</td>
            </tr>
        </table>
        <br><br>
        <table  border="1" style="border-collapse:collapse">
            <tr>
            <th style="text-align:center; font-weight:bold; width:26px;background-color:#dcdcdc; font-size:10pt">No.</th>
            <th style="text-align:center; font-weight:bold; width:240px;background-color:#dcdcdc; font-size:10pt">Description</th>
            <th style="text-align:center; font-weight:bold; width:70px;background-color:#dcdcdc">Qty</th>
            <th style="text-align:center; font-weight:bold; width:100px;background-color:#dcdcdc; font-size:10pt">Price ('.strtoupper($mata_uang).')</th>
            <th style="text-align:center; font-weight:bold; width:100px;background-color:#dcdcdc; font-size:10pt">Amount ('.strtoupper($mata_uang).')</th>
            </tr>';

            $baris="Filter Belt made of Tetex DLW 05-8000-K030
            Size: 2200mm x 9750mm";

                $split = explode("\n",$baris);
                $jumlah_baris = count($split);
                $line_height = round($jumlah_baris * 12);
$no=0;
$total=0;
                foreach($barang->result() as $brg){
                    $no++;
                    $content = $content .'<tr>
                <td style="text-align:center; font-size:9pt;line-height:'.$line_height.'px;">'.$no.'</td>
                <td style="font-size:9pt">'.nl2br($brg->nama_produk_vendor).'</td>
                <td style="text-align:center; font-size:9pt;line-height:'.$line_height.'px;">'.$brg->jumlah_item.' '.$brg->satuan_item .'</td>
                <td style="text-align:center; font-size:9pt;line-height:'.$line_height.'px;">'.number_format($brg->harga_item,2).'</td>
                <td style="text-align:center; font-size:9pt;line-height:'.$line_height.'px;">'.number_format($brg->jumlah_item*$brg->harga_item,2).'</td>
            </tr>';

            $total=$total+ ($brg->jumlah_item*$brg->harga_item);
                }
            

            $content=$content.'
            <tr>
                <td colspan="3"></td>
                <td style="text-align:center;background-color:#dcdcdc; font-size:9pt">Total</td>
                <td style="text-align:center;background-color:#dcdcdc; font-size:9pt">'.number_format($total,2).'</td>
            </tr>
        </table>
        <br>
        <br>
        <hr>
        <br>
        <table style="font-size:10pt">
            <tr>
                <td>TERM & CONDITION:</td>
            </tr>
            <tr>
                <td style="width:15px">1. </td>
                <td>Requirement Date: <span style="background-color:yellow">'. date("F j, Y",strtotime($po->requirement_date)) .' in '.$po->destination.'</span></td>
            </tr>
            <tr>
                <td style="width:15px">2. </td>
                <td>Please notify us immediately if you are unable to ship as specified. </td>
            </tr>
            <tr>
                <td style="width:15px">3. </td>
                <td>Payment T/T with AR 60 days after goods received in good condition.</td>
            </tr>
            <tr>
                <td style="width:15px">4. </td>
                <td>Delivery Condition: Vendor will be apply penalty for any lateness of shipment. Penalty 2% for lateness within 1 week or penalty 5% for lateness after 1 week onward.</td>
            </tr>
            <tr>
                <td style="width:15px; background-color:#00ffff">5. </td>
                <td style="background-color:#00ffff">Please inform PT. LEITER INDONESIA packing list details before delivery (delivery destination might change)</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" style="width:400px">We look forward to our good partnership.</td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        Best regards,
                <br><br><br>
        </body>
        </html>
';
$pdf->writeHTML($content);

$pdf->SetFont('MonotypeCorsivai','', 24);
$content = 'Robert Cau';
$pdf->writeHTML($content); //yang keluarin html nya. Setfont nya harus diatas kontennya

$pdf->SetFont('Tahoma','', 10.5);
$content ='Managing Director<br>PT LEITER INDONESIA';
$pdf->writeHTML($content);
    //$obj_pdf->SetFont(Courier','', 8); //untuk font, liat dokumentasui
    //$pdf->writeHTML($content); //yang keluarin html nya. Setfont nya harus diatas kontennya
    //$pdf->Write(5, 'Contoh Laporan PDF dengan CodeIgniter + tcpdf');
    $pdf->Output('contoh1.pdf', 'I');
?>
<?php endforeach;?>