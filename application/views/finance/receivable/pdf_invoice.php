<?php foreach($invoice->result() as $inv):?>
<?php
    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetTitle('INVOICE');
    $pdf->SetTopMargin(30);
    $pdf->setFooterMargin(20);
    $pdf->SetAutoPageBreak(true,22);
    $pdf->SetAuthor('Author');
    $pdf->SetDisplayMode('real', 'default');
    $pdf->setPrintHeader(true);
      $pdf->setPrintFooter(true);
    $pdf->AddPage('P','A4');

    $fontname = TCPDF_FONTS::addTTFfont('../../../libraries/tcpdf/fonts/tahoma.ttf', 'TrueTypeUnicode', '', 96);
    $pdf->SetFont('Tahoma','', 11); //untuk font, liat dokumentasui

    $content='
    <html>
        <head>
        
        </head>
        <body>
            <table>
            <tr>
                <td colspan="2"></td>
                <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alamat Penagihan:</td>
            </tr>
            <tr>
                <td style="width:100px">No. Invoice</td>
                <td style="width:200px"> : '.$inv->no_invoice.'</td>
                <td colspan="2" rowspan="5">';
                
                foreach($perusahaan->result() as $x){
                    $content=$content.$x->nama_perusahaan .'
                    <br>'.nl2br($inv->alamat_penagihan).'
                    <br>Telp. '.$x->notelp_perusahaan.'
                    <br>att: '.$inv->att;
                }
                $content = $content.'</td>
                </tr>
                ';
                $content=$content.'<tr>
                <td>Surat Jalan</td>
                <td> : ';

                if($inv->id_submit_od=="0"){
                    $content=$content."-";
                }else{
                    foreach($jalan->result() as $jl){
                        $content=$content. $jl->no_od;
                    }
                }
                
                $content=$content.'</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td style="width:100px">Tanggal</td>
                <td> : '.date("d-m-Y", strtotime($inv->tgl_invoice_add)).'</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td style="width:100px">Nomor Pembelian</td>
                <td> : '.get1Value("order_confirmation","no_po_customer",array("id_submit_oc"=>$inv->id_submit_oc)).'</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td style="width:100px">Penyerahan</td>
                <td> : franco '.$inv->franco.'</td>
                <td colspan="2"></td>
            </tr>
            </table>
<br><br>
            <table>
            <tr>
                <th colspan="4" style="text-align:center; font-size:24pt;">INVOICE</th>
            </tr>
            </table>
            <br><br>
            <table  border="1" style="border-collapse:collapse">
            <tr>
                        <th style="text-align:center; font-weight:bold; width:26px; background-color:rgb(198, 224, 180)">No.</th>
                        <th style="text-align:center; font-weight:bold; width:250px; background-color:rgb(198, 224, 180)">Jenis Barang</th>
                        <th style="text-align:center; font-weight:bold; width:70px; background-color:rgb(198, 224, 180)">Jumlah</th>
                        <th style="text-align:center; font-weight:bold; width:80px; background-color:rgb(198, 224, 180)">Harga (IDR)</th>
                        <th style="text-align:center; font-weight:bold; width:103px; background-color:rgb(198, 224, 180)">Jumlah (IDR)</th>
                    </tr>';
                $no=0;
                $total=0;
                    foreach($barang->result() as $ss){
                        $no++;
                        if($cekOd=="0"){
                            $baris="$ss->nama_oc_item";
                        }else{
                            $baris="$ss->nama_oc_item";
                        }
                        

                        $split = explode("\n",$baris);
                        $jumlah_baris = count($split);
                        $line_height = round($jumlah_baris * 12.5);

                        $content=$content.'
                        <tr>
                            <td>'.$no.'</td>
                            <td>'.nl2br($baris).'</td>
                            <td style="text-align:center;line-height:'.$line_height.'px">'.number_format($ss->final_amount).' '.$ss->satuan_produk .'</td>
                            <td style="text-align:right;line-height:'.$line_height.'px">'.number_format($ss->final_selling_price,2).'</td>
                            <td style="text-align:right;line-height:'.$line_height.'px">'.number_format($ss->final_amount *$ss->final_selling_price,2).'</td>
                        </tr>';

                        $total=$total+($ss->final_amount * $ss->final_selling_price);
                    }
                    

                    $content=$content.'
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="2">Total Sebelum PPN</td>
                        <td style="text-align:right">'.number_format($total,2).'</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="2">PPN 10%</td>
                        <td style="text-align:right">'.number_format(0.1*$total,2).'</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="2" style="background-color: rgb(198, 224, 180); font-weight:bold">TOTAL</td>
                        <td  style="background-color: rgb(198, 224, 180); font-weight:bold; text-align:right">'.number_format($total+(0.1*$total),2).'</td>
                    </tr>
            </table>
            <br>
            <br><br>
            <table>
                <tr>
                    <td style="width: 150px">Pembayaran</td>
                    <td>: '.$inv->durasi_pembayaran.' hari setelah invoice diterima</td>
                </tr>
                <tr>
                    <td>Jatuh Tempo</td>
                    <td>: '.tanggalCantik(date("Y/m/d",strtotime($inv->jatuh_tempo))).'</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>: IDR '.number_format($total+(0.1*$total),2).'</td>
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
            <br><br>';
            if($inv->id_submit_od!="0"){
                $content=$content.'
                <table style="width:500px;text-align:center">
                    <tr>
                    <td style="width:50px"></td>
                        <td colspan="4">************************** PACKING LIST **************************</td>
                    </tr>
                    <tr>
                    <td></td>
                        <td style="text-align:left">Box-No</td>
                        <td>Berat Bersih</td>
                        <td>Berat Kotor</td>
                        <td>Dimensi (L/W/H)</td>
                    </tr>';

                    $no=0;
                    foreach($box->result() as $boxx){
                        $no++;
                        $content=$content.'
                        <tr>
                        <td></td>
                            <td style="text-align:left">'.sprintf("%02d",$no).'</td>
                            <td>'.$boxx->berat_bersih.' kg</td>
                            <td>'.$boxx->berat_kotor.' kg</td>
                            <td>'.$boxx->dimensi_box.'</td>
                        </tr>';
                    }
                    

                    $content=$content.'
                    <tr>
                    <td></td>
                        <td colspan="4">*****************************************************************</td>
                    </tr>
                    <tr>
                    <td></td>
                        <td  style="text-align:left" colspan="4">Total</td>
                    </tr>
                    <tr>
                    <td></td>
                        <td style="text-align:left">'.sprintf("%02d",$no).'</td>
                        <td>'.$inv->berat_bersih.' kg</td>
                        <td>'.$inv->berat_kotor.' kg</td>
                        <td>'.$inv->dimensi.'</td>
                    </tr>
                </table>';
            }
            $content=$content.'
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <table style = "width:500px">
                <tr>
                <td></td>
                    <td style="text-align:center">
                        Jakarta, '.tanggalCantik(date("Y/m/d",strtotime($inv->tgl_invoice_add))).'
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center">
                        
                    </td>
                    <td style="text-align:center">
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>'.$inv->sign_off.'
                    </td>
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
<?php endforeach; ?>