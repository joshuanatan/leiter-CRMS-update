<div class="panel-body col-lg-12">
<?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_receivable")) == 0):?>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-15">
                <a href = "<?php echo base_url();?>finance/receivable/create" class="btn btn-outline btn-sm btn-primary">
                    <i class="icon wb-plus" aria-hidden="true"></i> Create Invoice
                </a>
                <a href = "<?php echo base_url();?>finance/receivable/openDataEntry" class="btn btn-outline btn-sm btn-primary">
                    <i class="icon wb-plus" aria-hidden="true"></i> Data Entry
                </a>
            </div>
        </div>
    </div>
<?php endif;?>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
        <thead>
            <tr>
                <th>No Invoice</th>
                <th>PO Customer No</th>
                <th>Invoice Amount</th>
                <th>Purpose</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0 ; $a<count($invoice); $a++): ?>
            <tr class="gradeA">
                
                <td><?php echo $invoice[$a]["no_invoice"];?></td>
                <td><?php echo $invoice[$a]["no_po_customer"];?></td>
                <td><?php echo number_format($invoice[$a]["nominal_pembayaran"],2,".",",");?></td>
                <td><?php echo $invoice[$a]["purpose"];?></td>
                <td class="actions">
                    <a href = "<?php echo base_url();?>finance/receivable/invoicePdf/<?php echo $invoice[$a]["id_submit_invoice"];?>" class = "btn btn-sm btn-primary btn-outline" target="_blank">CETAK</a>
                    <?php if($invoice[$a]["status_lunas"] == 1):?>
                    
                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "delete_receivable")) == 0):?>
                    <a href = "<?php echo base_url();?>finance/receivable/delete/<?php echo $invoice[$a]["id_submit_invoice"];?>" class="btn btn-outline btn-danger btn-sm"
                    data-toggle="tooltip"><i class="icon wb-trash" aria-hidden="true"></i></a>
                    <?php endif;?>

                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "edit_receivable")) == 0):?>
                    <a href = "<?php echo base_url();?>finance/receivable/edit/<?php echo $invoice[$a]["id_submit_invoice"];?>" class = "btn btn-sm btn-primary btn-outline">EDIT</a>
                    <?php endif;?>

                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_receivable")) == 0):?>
                    <button class = "btn btn-primary btn-sm btn-outline" type="button" data-toggle = "modal" data-target="#pay<?php echo $a;?>">PAY</button>
                    <?php endif;?>
                    <?php else:?>
                    <button class = "btn btn-success btn-outline btn-sm">PAID</button>
                    <?php endif;?>
                </td>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
</div>
<?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_receivable")) == 0):?>
<?php for($a = 0 ; $a<count($invoice); $a++): ?>
<div class = "modal fade" id = "pay<?php echo $a;?>">
    <div class = "modal-dialog modal-xl">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">DO PAYMENT</h4>
            </div>
            <div class ="modal-body">
                <form action = "<?php echo base_url();?>finance/receivable/pay/<?php echo $invoice[$a]["id_submit_invoice"] ?>" method = "POST" enctype = "multipart/form-data">
                    <div class = "form-group">
                        <input type = "hidden" class = "form-control" name = "id_refrensi" value = "<?php echo $invoice[$a]["id_submit_invoice"];?>" readonly>
                    </div>
                    <div class = "form-group">
                        <h5 class = "opacity:0.5">No Refrence</h5>
                        <input type = "text" class = "form-control" name = "no_refrence" value = "<?php echo $invoice[$a]["no_invoice"];?>" readonly>
                    </div>
                    <div class = "form-group">
                        <h5 class = "opacity:0.5">Payment Subject</h5>
                        <input required type = "text" class = "form-control" name = "subject_pembayaran">
                    </div>
                    <div class = "form-group">
                        <h5 class = "opacity:0.5">Payment Date</h5>
                        <input required type = "date" class = "form-control" name = "tgl_bayar">
                    </div>
                    <div class = "form-group">
                        <h5 class = "opacity:0.5">Payment Amount</h5>
                        <input required type = "text" class = "form-control" name = "nominal_pembayaran" id="paymentAmount<?php echo $a;?>" value = "<?php echo number_format($invoice[$a]["nominal_pembayaran"],2,".",",");?>" oninput = "commas('paymentAmount<?php echo $a;?>')">
                    </div>
                    <div class = "form-group">
                        <h5 class = "opacity:0.5">Rate</h5>
                        <input required type = "text" oninput = "commas('paymentRate<?php echo $a;?>')" id = "paymentRate<?php echo $a;?>" placeholder = "Kurs mata uang pembayaran ke IDR. 1 untuk IDR ke IDR" class = "form-control" name = "kurs_pembayaran">
                    </div>
                    <div class = "form-group">
                        <h5 class = "opacity:0.5">Currency</h5>
                        <input required type = "text" class = "form-control" name = "mata_uang_pembayaran" placeholder = "Mata uang pembayaran" >
                    </div>
                    <div class = "form-group">
                        <h5 class = "opacity:0.5">Notes</h5>
                        <textarea placeholder = "Catatan pembayaran" class = "form-control" name = "notes_pembayaran"></textarea>
                    </div>
                    <div class = "form-group">
                        <h5 class = "opacity:0.5">Payment Method</h5>
                        <select name = "metode_pembayaran" class = "form-control" data-plugin = "select2">
                            <option value = "0">TRANSFER</option>
                            <option value = "1">CASH</option>
                        </select>
                    </div>
                    <div class = "form-group">
                        <h5 class = "opacity:0.5">Attachment</h5>
                        <input type = "file" class = "form-control" name = "attachment">
                    </div>
                    <div class = "form-group">
                        <button type = "submit" class = "btn btn-primary col-lg-2 btn-outline btn-sm">SUBMIT</button>
                    </div>
            </form>
                </div>
        </div>
    </div>
</div>
<?php endfor;?>
<?php endif;?>