
<div class="panel-body col-lg-12">
<?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_od")) == 0):?>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-15">
            <a href = "<?php echo base_url();?>crm/od/create" class="btn btn-outline btn-sm btn-primary">
                <i class="icon wb-plus" aria-hidden="true"></i> Add Order Delivery
            </a>
            </div>
        </div>
    </div>
<?php endif;?>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin="dataTable">
        <thead>
            <tr>
                <th>Order Delivery ID</th>
                <th>Customer PO No</th>
                <th>Customer Firm</th>
                <th>Courier</th>
                <th>Items Ordered</th>
                <th>Date Issued</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($od); $a++): ?>
            <tr class="gradeA">
                <td><?php echo $od[$a]["no_od"];?></td>
                <td><?php echo $od[$a]["no_po_customer"];?></td>
                <td><?php echo $od[$a]["nama_perusahaan"];?></td>
                <td><?php echo $od[$a]["nama_courier"];?></td>
                <td><button class = "btn btn-primary btn-outline" type = "button" data-target = "#detail<?php echo $a;?>" data-toggle = "modal">Detail Items</button></td>
                <td><?php echo $od[$a]["date_od_add"];?></td>
                <td class="actions">
                    <a href="<?php echo base_url();?>crm/od/odPdf/<?php echo $od[$a]["id_submit_od"];?>" target="_blank" class="btn btn-primary btn-outline btn-sm">CETAK</a>
                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "edit_od")) == 0):?>
                    <a href = "<?php echo base_url();?>crm/od/edit/<?php echo $od[$a]["id_submit_od"];?>" class = "btn btn-primary btn-sm btn-outline">EDIT</a>
                    <?php endif;?>
                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "delete_od")) == 0):?>
                    <a href = "<?php echo base_url();?>crm/od/remove/<?php echo $od[$a]["id_submit_od"];?>" class = "btn btn-danger btn-sm btn-outline">REMOVE</a>
                    <?php endif;?>
                </td>
                
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
</div>

<?php for($a = 0; $a<count($od); $a++): ?>
    <div class="modal fade" id="detail<?php echo $a;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Sent Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class = "table table-bordered table-stripped">
                    <?php for($b = 0 ; $b<count($od[$a]["items"]); $b++): ?>
                        <tr>
                            <td><?php echo nl2br($od[$a]["items"][$b]["nama_oc_item"]);?></td>
                            <td><?php echo $od[$a]["items"][$b]["item_qty"];?> <?php echo $od[$a]["items"][$b]["satuan_produk"];?></td>
                        </tr>
                    <?php endfor;?>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endfor;?>
