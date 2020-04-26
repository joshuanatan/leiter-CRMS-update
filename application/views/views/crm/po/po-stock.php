<div class="panel-body col-lg-12">
<?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_po")) == 0):?>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-15">
                <a class = "btn btn-primary btn-outline btn-sm" href = "<?php echo base_url();?>crm/po/createPoStock">Create Stock Purchase Order</a>
            </div>
        </div>
    </div>
<?php endif;?>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
        <!-- List OC yang sudah di selesaikan -->
        <thead>
            <tr>
                <th>Purchase Order ID</th>
                <th>Supplier Firm</th>
                <th>Shipper Firm</th>
                <th>Destination</th>
                <th>Requirement Date</th>
                <th style = "width:10%">Details</th>
                <th style = "width:10%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($purchase_order);$a++): ?>
            <tr class="gradeA">
                <td><?php echo $purchase_order[$a]["no_po"];?></td>
                <td><?php echo strtoupper($purchase_order[$a]["nama_supplier"]);?></td>
                <td><?php echo strtoupper($purchase_order[$a]["nama_shipper"]);?></td>
                <td><?php echo $purchase_order[$a]["destination"];?></td>
                <td><?php $date = date_create($purchase_order[$a]["requirement_date"]); echo date_format($date,"D, M d, Y");?></td>
                <td>
                    <button class = "btn btn-primary btn-sm col-lg-12 btn-outline" type = "button" data-toggle = "modal" data-target = "#detailPo<?php echo $a;?>">DETAIL PO</button>
                    <button class = "btn btn-primary btn-sm col-lg-12 btn-outline" type = "button" data-toggle = "modal" data-target = "#detailItem<?php echo $a;?>">DETAIL ITEM</button>
                </td>
                <td class="actions">
                    <a target="_blank" href = "<?php echo base_url();?>crm/po/poStockPdf/<?php echo $purchase_order[$a]["id_submit_po"];?>" class = "btn btn-outline btn-primary btn-sm col-lg-12">CETAK</a>
                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "edit_po")) == 0):?>
                    <a href = "<?php echo base_url();?>crm/po/editPoStock/<?php echo $purchase_order[$a]["id_submit_po"];?>" class = "btn btn-outline btn-primary btn-sm col-lg-12">EDIT</a>
                    <?php endif;?>
                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "delete_po")) == 0):?>
                    <a href = "<?php echo base_url();?>crm/po/deletePoStock/<?php echo $purchase_order[$a]["id_submit_po"];?>" class = "btn btn-outline btn-danger btn-sm col-lg-12">DELETE</a>
                    <?php endif;?>
                    <?php if($purchase_order[$a]["status_selesai_po"] == 1):?>
                    <a href = "<?php echo base_url();?>crm/po/donePoStock/<?php echo $purchase_order[$a]["id_submit_po"];?>" class = "btn btn-outline btn-success btn-sm col-lg-12">DONE</a>
                    <?php endif;?>
                </td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>
    <a href = "<?php echo base_url();?>crm/po" class = "btn btn-primary btn-sm">BACK</a>
</div>


<?php for($a = 0; $a<count($purchase_order);$a++): ?>
<div class = "modal fade" id = "detailPo<?php echo $a;?>">
    <div class = "modal-dialog modal-lg">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">DETAIL PO NO <?php echo $purchase_order[$a]["no_po"];?></h4>
            </div>
            <div class = "modal-body">
                <table class = "table table-stripped table-bordered">
                    <tr>
                        <td>No Po</td>
                        <td><?php echo $purchase_order[$a]["no_po"];?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Buat PO</td>
                        <td><?php $date = date_create($purchase_order[$a]["date_po_core_add"]); echo date_format($date,"M d, Y"); ?></td>
                    </tr>
                    <tr>
                        <td>Nama Supplier</td>
                        <td><?php echo ucwords($purchase_order[$a]["nama_supplier"]);?></td>
                    </tr>
                    <tr>
                        <td>PIC Supplier</td>
                        <td><?php echo ucwords($purchase_order[$a]["nama_cp_supplier"]);?></td>
                    </tr>
                    <tr>
                        <td>Nama Shipper</td>
                        <td><?php echo ucwords($purchase_order[$a]["nama_shipper"]);?></td>
                    </tr>
                    <tr>
                        <td>PIC Shipper</td>
                        <td><?php echo ucwords($purchase_order[$a]["nama_cp_shipper"]);?></td>
                    </tr>
                    <tr>
                        <td>Destination</td>
                        <td><?php echo $purchase_order[$a]["destination"];?></td>
                    </tr>
                    <tr>
                        <td>Requirement Date</td>
                        <td><?php $date = date_create($purchase_order[$a]["requirement_date"]); echo date_format($date,"M d, Y");?></td>
                    </tr>
                    <tr>
                        <td>Shipping Term</td>
                        <td><?php echo $purchase_order[$a]["shipping_term"];?></td>
                    </tr>
                    <tr>
                        <td>Shipping Method</td>
                        <td><?php echo $purchase_order[$a]["shipping_method"];?></td>
                    </tr>
                    <tr>
                        <td>Mata Uang Pembayaran</td>
                        <td><?php echo $purchase_order[$a]["mata_uang_pembayaran"];?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endfor;?>
<?php for($a = 0; $a<count($purchase_order);$a++): ?>
<div class = "modal fade" id = "detailItem<?php echo $a;?>">
    <div class = "modal-dialog modal-lg">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">DETAIL PO NO <?php echo $purchase_order[$a]["no_po"];?></h4>
            </div>
            <div class = "modal-body">
                <table class = "table table-stripped table-bordered" style = "width:100%" data-plugin = "dataTable">
                    <thead>
                        <th>Nama Produk Leiter</th>
                        <th>Nama Produk Vendor</th>
                        <th>Harga Item</th>
                        <th>Jumlah Item</th>
                    </thead>
                    <tbody>
                        <?php for($items = 0; $items<count($purchase_order[$a]["items"]); $items++):?>
                        <tr>
                            <td><?php echo nl2br($purchase_order[$a]["items"][$items]["deskripsi_produk"]);?></td>
                            <td><?php echo nl2br($purchase_order[$a]["items"][$items]["nama_produk_vendor"]);?></td>
                            <td valign = "middle"><?php echo number_format($purchase_order[$a]["items"][$items]["harga_item"],2);?></td>
                            <td valign = "middle"><?php echo number_format($purchase_order[$a]["items"][$items]["jumlah_item"],2)." ".$purchase_order[$a]["items"][$items]["satuan_item"];?></td>
                        </tr>
                        <?php endfor;?>    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endfor;?>