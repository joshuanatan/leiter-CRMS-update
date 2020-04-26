<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=pph23.xls");
?>
<h5>PPH 23 <?php echo $bulan_pajak;?>/<?php echo $tahun_pajak;?></h5>
<table border = "1">
    <thead>
        <td>No Faktur Pajak</td>
        <td>Jumlah Pajak</td>
        <td>Refrensi</td>
    </thead>
    <?php for($a = 0; $a<count($tax);$a++):?>
    <tr>
        <td><?php echo $tax[$a]["no_faktur_pajak"];?></td>
        <td><?php echo number_format($tax[$a]["jumlah_pajak"],2);?></td>
        <td><?php echo $tax[$a]["id_refrensi"];?></td>
    </tr>
    <?php endfor;?>
</table>