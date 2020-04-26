<?php foreach($od->result() as $odx):?>
<?php
    $pdf = new Pdf_noHead('P', 'mm', 'A5', true, 'UTF-8', false);
    $pdf->SetTitle('ORDER DELIVERY');
    //$pdf->SetTopMargin(30);
    $pdf->setFooterMargin(20);
    $pdf->SetAutoPageBreak(true,22);
    $pdf->SetAuthor('Author');
    $pdf->SetDisplayMode('real', 'default');
    $pdf->setPrintHeader(false);
      $pdf->setPrintFooter(true);
    $pdf->AddPage('L','A5');

    $fontname = TCPDF_FONTS::addTTFfont('../../../libraries/tcpdf/fonts/tahoma.ttf', 'TrueTypeUnicode', '', 96);
    $pdf->SetFont('Tahoma','', 10.5); //untuk font, liat dokumentasui

    $content='
    <html>
        <head>
        
        </head>
        <body>
            <table>
                <tr>
                    <td style="width:310; font-weight:bold;"><i>PT LEITER INDONESIA</i></td>
                    <td>'.hariCantik(date("N",strtotime($odx->date_od_add))) . ", " . tanggalCantik(date("Y/m/d",strtotime($odx->date_od_add))).'</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Ruko Prominence Alam Sutera 38F / 53-55	
                    <br>Jln. Jalur Sutera Prominence	
                    <br>Alam Sutera, Tangerang 15143 
                    <br>Banten INDONESIA
                    </td>
                    <td><br><br>Kepada Yth.
                    <br>';

                    foreach($perusahaan->result() as $x){
                        $content=$content.$x->nama_perusahaan;
                        $content = $content . '
                        <br>'.$x->alamat_perusahaan.'</td>';

                    }
                    
                    $content=$content.'
                </tr>
            </table>
<br><br>
            <table>
                <tr>
                    <td style="width:120px">Surat Jalan No.</td>
                    <td>: '.$x->no_od.'
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <table border="0.5">
                <tr>
                    <th style="width:65px; font-weight:bold; text-align:center">Jumlah</th>
                    <th style="width:65px; font-weight:bold; text-align:center">Unit</th>
                    <th style="width:390px; font-weight:bold; text-align:center">Nama Barang</th>
                </tr>';
                
                foreach($barang->result() as $y){

                    $baris="$y->nama_oc_item";
                    $split = explode("\n",$baris);

                    $kata='';
                    for($k=0; $k<count($split) ; $k++){
                        $kata = $kata .'<br> '.$split[$k];
                    }

                    $jumlah_baris = count($split);
                    $line_height = round($jumlah_baris * 14);

                    $content=$content.'<tr>
                    <td style="text-align:center; line-height:'.$line_height.'px;">'.$y->item_qty.'</td>
                    <td style="text-align:center; line-height:'.$line_height.'px;">'.$y->satuan_produk.'</td>
                    <td>'.$kata.'
                    </td>
                </tr>';
                }
                $content=$content.'
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align:left">
                    <b>PO No : ';
                    
                    foreach($nopo->result() as $po){
                        $content=$content.$po->no_po_customer;
                    }
                    $content=$content.'</b>
                    </td>
                </tr>
            </table>
<br><br><br><br>
            <table align="center">
                <tr>
                    <td>Tanda Terima,</td>
                    <td></td>
                    <td>Hormat Kami,</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>'.$this->session->nama_user.'</td>
                </tr>
            </table>
        </body>
    </html>
    ';

    //$obj_pdf->SetFont(Courier','', 8); //untuk font, liat dokumentasui
    $pdf->writeHTML($content); //yang keluarin html nya. Setfont nya harus diatas kontennya
    //$pdf->Write(5, 'Contoh Laporan PDF dengan CodeIgniter + tcpdf');
    $pdf->Output('contoh1.pdf', 'I');
?>
<?php endforeach;?>