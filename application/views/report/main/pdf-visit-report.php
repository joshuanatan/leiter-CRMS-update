<?php
    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetTitle('VISIT REPORT');
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
            <h1 align = "center">VISIT REPORT</h1>
            <table style = "width:100%;border:1px solid black">
                <tr style = "border:1px solid black">
                    <td style = "border:1px solid black;width:15%">Sales Name</td>
                    <td style = "border:1px solid black;width:35%">'.$visit["sales_name"].'</td>
                    <td style = "border:1px solid black;width:15%">Company Name</td>
                    <td style = "border:1px solid black;width:35%">'.$visit[0]["nama_perusahaan"].'</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "border:1px solid black;width:15%">Visit Date</td>
                    <td style = "border:1px solid black;width:35%">'.$visit[0]["action_date"].'</td>
                    <td style = "border:1px solid black;width:15%">Location / Duration</td>
                    <td style = "border:1px solid black;width:35%">'.ucwords($visit[0]["action_location"]).' / '. $visit[0]["action_duration"].'</td>
                </tr>
            </table>
            <br/><br/>
            <table style = "width:100%;border:1px solid black">
                <tr style = "border:1px solid black">
                    <td style = "border:1px solid black">1. Purpose of the Visit</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "height:30px">'.ucwords($visit[0]["action_purpose"]).'</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "border:1px solid black">2. To who did you talk and what is his/her Position</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "height:30px">'.ucwords(nl2br($visit[0]["action_pic"])).'</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "border:1px solid black">3. Dialog/Conversation with Customers</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "height:30px">'.nl2br(nl2br($visit[0]["action_conversation"])).'</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "border:1px solid black">4. Potential Machine</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "height:30px">'.ucwords(nl2br($visit[0]["potential_machine"])).'</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "border:1px solid black">5. Conclusion of Dialog about Metting/Test?</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "height:30px">'.ucwords(nl2br($visit[0]["action_conclusion"])).'</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "border:1px solid black">6. Percentage to Get the Order</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "height:30px">'.$visit[0]["action_percentage_order"].'%</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "border:1px solid black">7. Next Action Items</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "border:1px solid black;">
                        <div></div>
                        <table style = "border:1px solid black; width:100%;">
                            <tr>
                                <th style = "width: 10%;border:1px solid black; text-align:center"><strong>No</strong></th>
                                <th style = "width: 60%;border:1px solid black; text-align:center"><strong>Remarks</strong></th>
                                <th style = "width: 30%;border:1px solid black; text-align:center"><strong>PIC</strong></th>
                            </tr>';
                            for($a = 0; $a<count($next_action); $a++):
                            $content .= '
                            <tr>
                                <td style = "width: 10%;border:1px solid black">'.($a+1).'</td>
                                <td style = "width: 60%;border:1px solid black">'.ucwords(nl2br($next_action[$a]["remarks"])).'</td>
                                <td style = "width: 30%;border:1px solid black">'.ucwords(nl2br($next_action[$a]["pic"])).'</td>
                            </tr>';
                            endfor;
                            $content .='
                        </table>
                        <div></div>
                    </td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "border:1px solid black">8. Support Needed</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "border:1px solid black;height:30px">'.ucwords(nl2br($visit[0]["support_need"])).'</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "border:1px solid black">9. Follow up Date</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "border:1px solid black;height:30px">'.$visit["followup_date"].'</td>
                </tr>
                <tr style = "border:1px solid black">
                    <td style = "border:1px solid black">10. Attachment</td>
                </tr>';
                for($b = 0; $b<count($attachment); $b++){
                    $content .='
                <tr style = "border:1px solid black">
                    <td>
                        <img style = "width:200px" src = "'.base_url().'/assets/report/visit/'.$attachment[$b]["attachment"].'"></td></tr>';
                    }
                $content .='
            </table>
        </body>
    </html>
    ';

    //$obj_pdf->SetFont(Courier','', 8); //untuk font, liat dokumentasui
    $pdf->writeHTML($content); //yang keluarin html nya. Setfont nya harus diatas kontennya
    //$pdf->Write(5, 'Contoh Laporan PDF dengan CodeIgniter + tcpdf');
    $pdf->Output('contoh1.pdf', 'I');
?>