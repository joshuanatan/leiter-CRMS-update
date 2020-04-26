<?php foreach($order_confirmation->result() as $occ):?>
<?php
    $pdf = new Pdf_oc('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetTitle('ORDER CONFIRMATION');
    $pdf->SetTopMargin(30);
    $pdf->setFooterMargin(20);
    $pdf->SetAutoPageBreak(true,22);
    $pdf->SetAuthor('Author');
    $pdf->SetDisplayMode('real', 'default');
    $pdf->setPrintHeader(true);
      $pdf->setPrintFooter(true);
    $pdf->AddPage('P','A4');
    
    $fontname = TCPDF_FONTS::addTTFfont('../../../libraries/tcpdf/fonts/tahoma.ttf', 'TrueTypeUnicode', '', 96);
    $pdf->SetFont('Tahoma','', 10.5); //untuk font, liat dokumentasui

    $content='
    <html>
        <head>
        
        </head>
        <body>
            <table>
                <tr>
                    <td style="width:300">';
                    
                    foreach($perusahaan->result() as $peru){
                        $content=$content. $peru->nama_perusahaan;

                        $content =$content.'</td>
                    <td style="text-align:right; width:200">'.hariCantik(date("N",strtotime($occ->date_oc_add))) . ", " . tanggalCantik(date("Y/m/d",strtotime($occ->date_oc_add))).'</td>
                    <td></td>
                </tr>
                <tr>
                    <td>'.nl2br($peru->alamat_perusahaan).'
                    
                    </td>
                </tr>
            </table>';
        }
            $content=$content.'
                    
                    
<br><br>
            <table>
                <tr>
                    <th style="text-align:center; font-size:22pt; font-weight:bold;text-decoration:underline"><b>Order Konfirmasi</b></th>
                </tr>
                <tr>
                    <th style="text-align:center; font-size:16pt;">'.$occ->no_oc.'</th>
                </tr>
            </table>
            <br><br><br>
            <table>
                <tr>
                    <td style="width: 190px">Salesman</td>
                    <td>: Robert Cau (Bob@leiter.co.id)</td>
                </tr>
                <tr>
                    <td>Nomor PO</td>
                    <td>: '.$occ->no_po_customer.'</td>
                </tr>
            </table>
            <br>
            <br>
            <table>
                <tr>
                    <td>Dear Bapak / Ibu yang kami hormati,</td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td>Kami mengucapkan terima kasih untuk order yang telah kami terima pada tanggal '.tanggalCantik(date("Y/m/d",strtotime($occ->tgl_po_customer))).'.
                    </td>
                </tr>    
                <tr>
                    <td>Berikut adalah surat konfirmasi untuk pemesanan barang yang telah kami terima :
                    </td>
                </tr>
            </table>
            <br><br>
            <table  border="1" style="border-collapse:collapse">
                <tr>
                    <th style="text-align:center; font-weight:bold; width:26px;">No.</th>
                    <th style="text-align:center; font-weight:bold; width:240px;">Deskripsi</th>
                    <th style="text-align:center; font-weight:bold; width:70px;">Qty</th>
                    <th style="text-align:center; font-weight:bold; width:100px;">Harga (IDR)</th>
                    <th style="text-align:center; font-weight:bold; width:100px;">Jumlah (IDR)</th>
                </tr>';
                $jum = 0;
                foreach($barang->result() as $brnya){
                    $baris="$brnya->nama_oc_item";

                    $split = explode("\n",$baris);
                    $jumlah_baris = count($split);
                    $line_height = round($jumlah_baris * 12.5);

                    $content= $content.'
                    <tr>
                        <td style="text-align:center;height:20px;line-height:'.$line_height.'px;">1</td>
                        <td>'. nl2br($baris).'
                        </td>
                        <td style="text-align:center;height:20px;line-height:'.$line_height.'px;">'. $brnya->final_amount. ' '.$brnya->satuan_produk .'</td>
                        <td style="text-align:center;height:20px;line-height:'.$line_height.'px;">'.number_format($brnya->final_selling_price,2,".",",").'</td>
                        <td style="text-align:center;height:20px;line-height:'.$line_height.'px;">'.number_format($brnya->final_selling_price*$brnya->final_amount,2,".",",").'</td>
                    </tr>';
                    $jum=$jum+ ($brnya->final_selling_price * $brnya->final_amount);
                }

                $content=$content.'
                <tr>
                    <td colspan="4" style="text-align:right"><b>TOTAL</b></td>
                    <td style="text-align:center"><b>'.number_format($jum,2,".",",").'</b></td>
                </tr>
                ';
                
                

                $content=$content.'
            </table>
            <br><br><br>
            <table>
                <tr>
                    <td style="width: 190px">Penyerahan Barang</td>
                    <td style="width:6px;">: </td>
                    <td style="width:340px;">Franco '.$occ->franco.'</td>
                </tr>
                <tr>
                    <td>Metode Pengiriman</td>
                    <td style="width:6px;">: </td>
                    <td>BY '.$occ->metode_pengiriman.'</td>
                </tr>
                <tr>
                    <td>Tanggal Penyerahan Barang</td>
                    <td style="width:6px;">: </td>
                    <td>'.$occ->durasi_pengiriman.' minggu, setelah PO dikonfirmasi</td>
                </tr>';
                foreach($metodebayar->result() as $cc){
                    
                    $content_dp = "";
                    if($cc->persentase_pembayaran != 0){ //kalau ada persen dp (ada transaksi dp)
                        $content_dp = $cc->persentase_pembayaran.'% DP diawal
                        <br>';
                        if($cc->persentase_pembayaran2 != 0){
                            if($cc->trigger_pembayaran2 == 1){ //sebelum od
                                $content_dp .= $cc->persentase_pembayaran2.'% pelunasan dalam '.$occ->durasi_pembayaran.' minggu setelah invoice diterima';
                            }
                            else{
                                $content_dp .= $cc->persentase_pembayaran2.'% pelunasan dalam '.$occ->durasi_pembayaran.' minggu setelah barang & invoice diterima';
                            }
                        }
                    }
                    else{ //tidak ber DP
                        if($cc->trigger_pembayaran2 == 1){ //sebelum od
                            $content_dp = '100% pelunasan dalam '.$occ->durasi_pembayaran.' minggu setelah invoice diterima';
                        }
                        else{
                            $content_dp = '100% pelunasan dalam '.$occ->durasi_pembayaran.' minggu setelah barang & invoice diterima';
                        }
                    }
                }   
                    $content=$content.'
                    <tr>
                        <td>Pembayaran</td>
                        <td style="width:6px;">: </td>
                        <td>'.$content_dp.'
                        </td>
                    </tr>
                </table>';
                
               

            $content=$content.'
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
                Hormat Kami,
                <br><br><br>
        </body>
        </html>
';
$pdf->writeHTML($content);
//echo $content;
$pdf->SetFont('MonotypeCorsivai','', 24);
$content = $this->session->nama_user;
$pdf->writeHTML($content); //yang keluarin html nya. Setfont nya harus diatas kontennya

$pdf->SetFont('Tahoma','', 10.5);
$content ='PT LEITER INDONESIA';
$pdf->writeHTML($content);
    //$obj_pdf->SetFont(Courier','', 8); //untuk font, liat dokumentasui
    //$pdf->writeHTML($content); //yang keluarin html nya. Setfont nya harus diatas kontennya
    //$pdf->Write(5, 'Contoh Laporan PDF dengan CodeIgniter + tcpdf');
    $pdf->Output('contoh1.pdf', 'I');
?>
<?php endforeach;?>