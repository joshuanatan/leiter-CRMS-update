<div class="panel-body col-lg-12">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-15">
            
            </div>
        </div>
    </div>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
        <thead>
            <tr>
                <th>RFQ ID</th>
                <th>Nama Perusahaan</th>
                <th>Nama CP</th>
                <th>Purpose</th>
                <th>Status</th>
                <th>Harga Vendor</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0 ; $a<count($request); $a++){ ?>
            <tr class="gradeA">
                <td><?php echo $request[$a]["no_request"]?></td>
                <td><?php echo $request[$a]["nama_perusahaan"];?></td>
                <td><?php echo $request[$a]["nama_cp"];?></td>
                <td>
                    <?php if($request[$a]["untuk_stock"] == 1): ?>
                    CUSTOMER
                    <?php else: ?>
                    STOCK
                    <?php endif;?>
                </td>
                <td>
                    <div class = "modal fade" id = "statusPriceRequestItem<?php echo $a;?>">
                        <div class = "modal-dialog">
                            <div class = "modal-content">
                                <div class = "modal-header">
                                    <h4 class = "modal-title">STATUS PRICE</h4>
                                </div>
                                <div class = "modal-body">
                                    <table class = "table table-bordered table-stripped" data-plugin = "dataTable" style = "width:100%">
                                        <thead>
                                            <th>Item</th>
                                            <th>Status</th>
                                        </thead>
                                        <tbody>
                                            <?php $fail = 1;for($items = 0; $items<count($request[$a]["request_item"]); $items++):?>
                                            <tr>
                                                <td><?php echo $request[$a]["request_item"][$items]["nama_produk"];?></td>
                                                <td>
                                                    <?php if($request[$a]["request_item"][$items]["jumlahHargaVendor"] == 0):$fail=0;?>
                                                    <button class = "btn btn-danger btn-sm">SUPPLIER</button>
                                                    <?php else:?>
                                                    <button class = "btn btn-primary btn-sm">SUPPLIER</button>
                                                    <?php endif;?>

                                                    <?php if($request[$a]["request_item"][$items]["jumlahHargaCourier"] == 0):$fail=0;?>
                                                    <button class = "btn btn-danger btn-sm">COURIER</button>
                                                    <?php else:?>
                                                    <button class = "btn btn-primary btn-sm">COURIER</button>
                                                    <?php endif;?>

                                                    <?php if($request[$a]["request_item"][$items]["jumlahHargaShipping"] == 0):$fail=0;?>
                                                    <button class = "btn btn-danger btn-sm">SHIPPING</button>
                                                    <?php else:?>
                                                    <button class = "btn btn-primary btn-sm">SHIPPING</button>
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                            <?php endfor;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($fail == 1):?>
                    <button class = "btn btn-primary btn-sm" data-toggle = "modal" data-target = "#statusPriceRequestItem<?php echo $a;?>">STATUS</button>
                    <?php else:?>
                    <button class = "btn btn-danger btn-sm" data-toggle = "modal" data-target = "#statusPriceRequestItem<?php echo $a;?>">STATUS</button>
                    <?php endif;?>
                </td>
                <td>
                    <a href = "<?php echo base_url();?>crm/vendor/produk/<?php echo $request[$a]["id_submit_request"];?>" class="btn btn-outline btn-primary btn-sm"><i class="icon wb-book" aria-hidden="true"></i>Harga Vendor</a>
                    <?php if($request[$a]["untuk_stock"]): ?>
                    <?php endif;?>
                </td>
                <td class="actions">
                    
                    
                    <a href = "<?php echo base_url();?>crm/vendor/delete/<?php echo $request[$a]["id_request"];?>" class="btn btn-outline btn-danger btn-sm" data-toggle="tooltip">REJECT</a>
                    
                    <?php 
                    if($fail == 1):?>
                    <a href = "<?php echo base_url();?>crm/vendor/submit/<?php echo $request[$a]["id_request"];?>" class="btn btn-outline btn-success btn-sm" data-trigger = "hover" data-content = <?php if($request[$a]["untuk_stock"] == 1) echo "Proceed to Quotation"; else echo "Proceed to PO";?> data-toggle="popover">PROCEED</a>
                    <?php endif;?>
                    
                </td>
            </tr> 
            <?php } ?>
        </tbody>
    </table>
</div>