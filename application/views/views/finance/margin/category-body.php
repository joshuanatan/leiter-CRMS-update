
<div class="panel-body col-lg-12">
    <div class="row">
    </div>
    <div class = "row">
    </div>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
        <thead>
            <tr>
                <th>Customer PO No</th> <!-- nanti ini keisi waktu nambahin OC-->
                <th>Tanggal Order</th>
                <th>Nama Customer</th>
                <th>Order Confirmation No</th>
                <th>PO Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($oc); $a++):?>
            <tr>
                <td><?php echo strtoupper($oc[$a]["no_po_customer"]);?></td>
                <td><?php $date = date_create($oc[$a]["tgl_po_customer"]); echo date_format($date,"D d-m-Y");?></td>
                <td><?php echo ucwords($oc[$a]["nama_perusahaan"]);?></td>
                <td><?php echo strtoupper($oc[$a]["no_oc"]);?></td>
                <td><?php echo number_format($oc[$a]["total_oc_price"]);?></td>
                <td>
                    <a href = "<?php echo base_url();?>finance/margin/detail/<?php echo $oc[$a]["id_submit_oc"];?>" class = "btn btn-primary btn-sm">TRANSAKSI</a>
                </td>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
    <!--
    <nav aria-label="...">
        <ul class="pagination">
            <?php for($a =0; $a<$total; $a++):?>
            <li class="page-item <?php if(($a+1) == $page) echo "active"; ?>">
                <a class="page-link" href="<?php echo base_url();?>finance/margin/page/<?php echo $a+1;?>"><?php echo $a+1;?></a>
            </li>
            <?php endfor;?>
        </ul>
    </nav>
-->
</div>