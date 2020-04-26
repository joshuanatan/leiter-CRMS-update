<div class="panel-body col-lg-12">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-15">
            <button class="btn btn-outline btn-sm btn-primary" data-toggle = "modal" data-target = "#tambahReimburse">Insert Reimburse Request</button>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
        <thead>
            <tr>
                <th>No Request</th>
                <th>User Name</th> <!-- yang ngelaurin invoice ini -->
                <th>Subject Reimburse</th>
                <th>Amount</th>
                <th>Notes</th> <!-- catetan aja seperti nomor rekening, dsb -->
                <th>Status</th>
                <th>Dokumen</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($reimburse);$a++): ?>
            <tr>
                <td><?php echo $reimburse[$a]["id_reimburse"];?></td>
                <td><?php echo $reimburse[$a]["nama_user"];?></td>
                <td><?php echo $reimburse[$a]["subject_reimburse"];?></td>
                <td><?php echo number_format($reimburse[$a]["nominal_reimburse"]);?></td>
                <td><?php echo $reimburse[$a]["notes"];?></td>
                <td>
                    <?php if($reimburse[$a]["status_paid"] == 0):?>
                    <button class = "btn btn-success btn-sm btn-outline">PAID</button>
                    <?php else:?>
                    <button class = "btn btn-danger btn-sm btn-outline">NOT PAID</button>
                    <?php endif;?>
                </td>
                <td>
                    <?php if($reimburse[$a]["attachment"] == "-"):?>
                    <button class = "btn btn-danger btn-sm btn-outline">NO DOCUMENT</button>
                    <?php else:?>
                    <a href = "<?php echo base_url();?>assets/dokumen/reimburse/<?php echo $reimburse[$a]["attachment"];?>" target = "_blank" class = "btn btn-primary btn-sm btn-outline">DOCUMENT</a>
                    <?php endif;?>
                </td>
                <td>
                    <?php if($reimburse[$a]["status_paid"] == 0):?>
                    <button class = "btn btn-primary btn-sm btn-outline col-lg-12" type="button" data-toggle = "modal" data-target="#detail<?php echo $a;?>">DETAIL</button>
                    <div class = "modal fade" id = "detail<?php echo $a;?>">
                        <div class = "modal-dialog modal-xl">
                            <div class = "modal-content">
                                <div class = "modal-header">
                                    <h4 class = "modal-title">PAYMENT DATA</h4>
                                </div>
                                <div class ="modal-body">
                                    <div class = "form-group">
                                        <h5 class = "opacity:0.5">Payment Date</h5>
                                        <input type = "text" class = "form-control" readonly value = "<?php $date = date_create($reimburse[$a]["payment_data"]["tgl_bayar"]); echo date_format($date,"D d-m-Y");?>">
                                    </div>
                                    <div class = "form-group">
                                        <h5 class = "opacity:0.5">Payment Subject</h5>
                                        <input type = "text" class = "form-control" readonly value = "<?php echo $reimburse[$a]["payment_data"]["subject_pembayaran"];?>">
                                    </div>
                                    <div class = "form-group">
                                        <h5 class = "opacity:0.5">Payment Method</h5>
                                        <input type = "text" readonly class = "form-control" value = "<?php if($reimburse[$a]["payment_data"]["metode_pembayaran"] == 0) echo "TRANSFER"; else echo "CASH";?>">
                                    </div>
                                    <div class = "form-group">
                                        <h5 class = "opacity:0.5">Payment Amount</h5>
                                        <input type = "text" class = "form-control" readonly value = "<?php echo number_format($reimburse[$a]["nominal_reimburse"]);?>">
                                    </div>
                                    <div class = "form-group">
                                        <h5 class = "opacity:0.5">Notes</h5>
                                        <textarea class = "form-control" name = "pay_notes" readonly><?php echo $reimburse[$a]["payment_data"]["notes_pembayaran"];?></textarea>
                                    </div>
                                    <div class = "form-group">
                                        <h5 class = "opacity:0.5">Attachment</h5> <!-- bukti bayar -->
                                        <?php if($reimburse[$a]["payment_data"]["attachment"] != "-"):?>
                                        <a href = "<?php echo base_url();?>assets/dokumen/buktibayar/<?php echo $reimburse[$a]["payment_data"]["attachment"];?>" target = "_blank" class = "btn btn-primary btn-outline btn-sm">DOCUMENT</a>
                                        <?php else:?>
                                        <button type = "button" class = "btn btn-outline btn-danger btn-sm">NO DOCUMENT</button>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
                    <?php if($reimburse[$a]["status_paid"] == 1):?>
                    <a href = "<?php echo base_url();?>finance/reimburse/remove/<?php echo $reimburse[$a]["id_reimburse"];?>" class = "btn btn-outline btn-danger col-lg-12 btn-sm">REMOVE</a>
                    <button class = "btn btn-primary btn-sm btn-outline col-lg-12" type = "button" data-toggle = "modal" data-target = "#edit<?php echo $a;?>">EDIT</button>
                    <div class = "modal fade" id = "edit<?php echo $a;?>">  
                        <div class = "modal-dialog modal-xl">
                            <div class = "modal-content">
                                <div class = "modal-header">
                                    <h4 class = "modal-title">EDIT REIMBURSE DATA</h4>
                                </div>
                                <form action = "<?php echo base_url();?>finance/reimburse/edit/<?php echo $reimburse[$a]["id_reimburse"]?>" method = "POST" enctype = "multipart/form-data">
                                    <div class = "modal-body">
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Subject Reimburse</h5>
                                            <input type = "text" class = "form-control" name = "subject_edit" value = "<?php echo $reimburse[$a]["subject_reimburse"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Amount</h5>
                                            <input type = "text" class = "form-control" name = "amount_edit" oninput = "commas('amountReimburseEdit')" id = "amountReimburseEdit" value = "<?php echo number_format($reimburse[$a]["nominal_reimburse"]);?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Notes</h5>
                                            <textarea class = "form-control" name = "notes_edit"><?php echo $reimburse[$a]["notes"];?></textarea>
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Attachment</h5>
                                            <input type = "file" class = "form-control" name = "attachment_edit">
                                            <br/>
                                            <a href ="<?php echo base_url();?>assets/dokumen/reimburse/<?php echo $reimburse[$a]["attachment"];?>" target ="_blank" class = "btn btn-primary btn-outline btn-sm">DOCUMENT</a>
                                        </div>
                                        <div class = "form-group">
                                            <button type = "submit" class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> 
                    <?php endif;?>
                    <?php if($reimburse[$a]["status_paid"] == 2):?>
                    
                    <a href = "<?php echo base_url();?>finance/reimburse/remove/<?php echo $reimburse[$a]["id_reimburse"];?>" class = "btn btn-outline btn-danger col-lg-12 btn-sm">DELETE</a>
                    <?php endif;?>
                </td>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
</div>
<div class = "modal fade" id = "tambahReimburse">
    <div class = "modal-dialog modal-xl">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">REIMBURSE REQUEST</h4>
            </div>
            <form action = "<?php echo base_url();?>finance/reimburse/insert" method = "POST" enctype = "multipart/form-data">
                <div class = "modal-body">
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Subject Reimburse</h5>
                        <input type = "text" class = "form-control" name = "subject">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Amount</h5>
                        <input type = "text" class = "form-control" name = "amount" oninput = "commas('amountReimburse')" id = "amountReimburse">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Attachment</h5>
                        <input type = "file" class = "form-control" name = "attachment">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Notes</h5>
                        <textarea class = "form-control" name = "notes"></textarea>
                    </div>
                    <div class = "form-group">
                        <button type = "submit" class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>