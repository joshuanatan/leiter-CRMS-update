<div class="panel-body col-lg-12">
<?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_payable")) == 0):?>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-15">
            <a href = "<?php echo base_url();?>finance/payable/insert" class="btn btn-sm btn-outline btn-primary">
                <i class="icon wb-plus" aria-hidden="true"></i> Insert Invoice
            </a>
            </div>
        </div>
    </div>
<?php endif;?>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
        <thead>
            <tr>
                <th style = "width:15%">No Invoice</th>
                <th style = "width:15%">No Refrence</th>
                <th style = "width:15%">Company Name</th> <!-- yang ngelaurin invoice ini -->
                <th style = "width:10%">Amount</th>
                <th style = "width:5%">Currency</th> <!-- ini yang harus di bayarkan --> 
                <th style = "width:5%">Attachment</th> <!-- catetan aja seperti nomor rekening, dsb -->
                <th style = "width:10%">Due date Invoice</th>
                <th style = "width:10%">Bank Account</th>
                <th style = "width:5%">Notes</th> <!-- catetan aja seperti nomor rekening, dsb -->
                <th style = "width:10%">Status</th>
                <th style = "width:10%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($tagihan);$a++): ?>
            <tr>
                <td><?php echo $tagihan[$a]["no_invoice"];?></td>
                <td><?php echo $tagihan[$a]["no_refrence"];?></td>
                <td><?php echo $tagihan[$a]["nama_target"];?></td>
                <td><?php echo number_format($tagihan[$a]["total"]);?></td>
                <td><?php echo $tagihan[$a]["mata_uang"];?></td>
                <td>
                    <?php if($tagihan[$a]["attachment"] == "-"):?>
                    <button class = "btn btn-danger btn-sm btn-outline">NO DOCUMENT</button>
                    <?php else:?>
                    <a target = "_blank" class = "btn btn-primary btn-sm btn-outline " href = "<?php echo base_url();?>assets/dokumen/invoice/<?php echo $tagihan[$a]["attachment"];?>">DOCUMENT</a>
                    <?php endif;?>
                </td>
                <td><?php $date = date_create($tagihan[$a]["dateline_invoice"]); echo date_format($date,"D, d-m-Y");?></td>
                <td><?php echo $tagihan[$a]["rekening_pembayaran"];?></td>
                <td>
                    <button type = "button" class = "btn btn-outline btn-sm btn-primary " data-target ="#notes<?php echo $a;?>" data-toggle = "modal">NOTES</button>
                    <div class = "modal fade" id ="notes<?php echo $a;?>">
                        <div class = "modal-dialog modal-xl">
                            <div class = "modal-content">
                                <div class = "modal-header">
                                    <h4 class = "modal-title">INVOICE NOTES</h4>
                                </div>
                                <div class = "modal-body">
                                    <div class = "form-group">
                                        <h5 style = "opacity:0.5">NOTES</h5>
                                        <textarea class = "form-control" readonly><?php echo $tagihan[$a]["notes"];?></textarea>
                                    </div>
                                    <div class = "form-group">
                                        <h5 style = "opacity:0.5">BANK ACCOUNT</h5>
                                        <input type = "text" readonly class = "form-control" value = "<?php echo $tagihan[$a]["rekening"];?>"/>
                                    </div>
                                    <div class = "form-group">
                                        <h5 style = "opacity:0.5">PPN</h5>
                                        <input type = "text" readonly class = "form-control" value = "<?php echo number_format($tagihan[$a]["ppn"]);?>"/>
                                    </div>
                                    <div class = "form-group">
                                        <h5 style = "opacity:0.5">PPH</h5>
                                        <input type = "text" readonly class = "form-control" value = "<?php echo number_format($tagihan[$a]["pph"]);?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <?php if($tagihan[$a]["status_lunas"] == 0):?>
                    <button class = "btn btn-success btn-outline btn-sm"  style = "width:100%">PAID</button>
                    <?php else:?>
                    <button class = "btn btn-danger btn-outline btn-sm "  style = "width:100%">NOT PAID</button>
                    <?php endif;?>
                </td>
                <td>
                    <?php if($tagihan[$a]["status_lunas"] == 1):?> 
                    
                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_payable")) == 0):?>
                    <button style = "width:100%" class = "btn btn-primary col-lg-12 btn-sm btn-outline" type="button" data-toggle = "modal" data-target="#pay<?php echo $tagihan[$a]["id_tagihan"];?>">PAY</button>
                    <?php endif;?>

                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "edit_payable")) == 0):?>
                    <a style = "width:100%" href = "<?php echo base_url();?>finance/payable/edit/<?php echo $tagihan[$a]["id_tagihan"];?>" class = "btn btn-sm btn-primary col-lg-12 btn-outline">EDIT</a>
                    <?php endif;?>

                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "delete_payable")) == 0):?>
                    <a style = "width:100%" href = "<?php echo base_url();?>finance/payable/remove/<?php echo $tagihan[$a]["id_tagihan"];?>" class = "btn btn-sm btn-danger col-lg-12 btn-outline">REMOVE</a>
                    <?php endif;?>

                    <?php endif;?>
                    
                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_payable")) == 0):?>
                    <div class = "modal fade" id = "pay<?php echo $tagihan[$a]["id_tagihan"];?>">
                        <div class = "modal-dialog modal-xl">
                            <form action = "<?php echo base_url();?>finance/payable/pay/<?php echo $tagihan[$a]["id_tagihan"];?>" method = "POST" enctype = "multipart/form-data">
                                <div class = "modal-content">
                                    <div class = "modal-header">
                                        <h4 class = "modal-title">DO PAYMENT</h4>

                                    </div>
                                    <div class ="modal-body">
                                        <div class = "form-group">
                                            <input type = "hidden" class = "form-control" name = "id_refrensi" value = "<?php echo $tagihan[$a]["id_tagihan"];?>" readonly>
                                        </div>
                                        <div class = "form-group">
                                            <h5 class = "opacity:0.5">No Refrence</h5>
                                            <input type = "text" class = "form-control" value = "<?php echo $tagihan[$a]["no_refrence"];?>" name = "no_refrence" readonly>
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
                                            <input required type = "text" class = "form-control" name = "nominal_pembayaran" id="paymentAmount<?php echo $a;?>" value = "<?php echo number_format($tagihan[$a]["total"]);?>" oninput = "commas('paymentAmount<?php echo $a;?>')">
                                        </div>
                                        <div class = "form-group">
                                            <h5 class = "opacity:0.5">Rate</h5>
                                            <input required type = "text" oninput = "commas('paymentRate<?php echo $a;?>')" id = "paymentRate<?php echo $a;?>" placeholder = "Kurs mata uang pembayaran ke IDR. 1 untuk IDR ke IDR" class = "form-control" name = "kurs_pembayaran">
                                        </div>
                                        <div class = "form-group">
                                            <h5 class = "opacity:0.5">Currency</h5>
                                            <input required type = "text" class = "form-control" <?php echo $tagihan[$a]["mata_uang"];?> name = "mata_uang_pembayaran" placeholder = "Mata uang pembayaran" value = "<?php echo $tagihan[$a]["mata_uang"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 class = "opacity:0.5">Notes</h5>
                                            <textarea placeholder = "Catatan pembayaran" class = "form-control" name = "notes_pembayaran"></textarea>
                                        </div>
                                        <div class = "form-group">
                                            <h5 class = "opacity:0.5">Payment Method</h5>
                                            <select name = "metode_pembayaran" class = "form-control">
                                                <option value = "0">TRANSFER</option>
                                                <option value = "1">CASH</option>
                                            </select>
                                        </div>
                                        <div class = "form-group">
                                            <h5 class = "opacity:0.5">Attachment</h5>
                                            <input type = "file" class = "form-control" name = "attachment">
                                        </div>
                                        <div class = "form-group">
                                            <button type = "submit" style = "width:100%" class = "btn btn-primary col-lg-12 btn-outline btn-sm">SUBMIT</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php endif;?>

                    <?php if($tagihan[$a]["status_lunas"] == 0):?>
                    <button class = "btn btn-primary col-lg-12 btn-sm btn-outline" style = "width:100%" type="button" data-toggle = "modal" data-target="#detailPayment<?php echo $a;?>">DETAIL</button> <!-- muncul hanya saat uda pernah ada pembayaran -->
                    <div class = "modal fade" id = "detailPayment<?php echo $a;?>">
                        <div class = "modal-dialog modal-xl">
                            <form action = "<?php echo base_url();?>finance/payable/pay/<?php echo $tagihan[$a]["id_tagihan"];?>" method = "POST">
                                <div class = "modal-content">
                                    <div class = "modal-header">
                                        <h4 class = "modal-title">DO PAYMENT</h4>

                                    </div>
                                    <div class ="modal-body">
                                        <div class = "form-group">
                                            <h5 class = "opacity:0.5">Payment Date</h5>
                                            <input type = "text" class = "form-control" readonly value = "<?php $date = date_create($tagihan[$a]["pembayaran"][0]["tgl_bayar"]); echo date_format($date,"D d-m-Y");?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 class = "opacity:0.5">Payment Amount</h5>
                                            <input type = "text" class = "form-control" readonly value = "<?php echo number_format($tagihan[$a]["pembayaran"][0]["nominal_pembayaran"]);?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 class = "opacity:0.5">Rate</h5>
                                            <input type = "text" class = "form-control" readonly value = "<?php echo number_format($tagihan[$a]["pembayaran"][0]["kurs_pembayaran"]);?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 class = "opacity:0.5">Currency</h5>
                                            <input type = "text" class = "form-control" readonly value = "<?php echo $tagihan[$a]["pembayaran"][0]["mata_uang_pembayaran"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 class = "opacity:0.5">Total Payment</h5>
                                            <input type = "text" class = "form-control" readonly value = "<?php echo number_format($tagihan[$a]["pembayaran"][0]["total_pembayaran"]);?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 class = "opacity:0.5">Payment Method</h5>
                                            <input type = "text" class = "form-control" readonly value = "<?php if($tagihan[$a]["pembayaran"][0]["metode_pembayaran"] == 0) echo "TRANSFER"; else echo "CASH";?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 class = "opacity:0.5">Notes</h5>
                                            <textarea class = "form-control" readonly readonly ><?php echo $tagihan[$a]["pembayaran"][0]["notes_pembayaran"];?></textarea>
                                        </div>
                                        <div class = "form-group">
                                            <h5 class = "opacity:0.5">Attachment</h5>
                                            <a href = "<?php echo base_url();?>assets/dokumen/buktibayar/<?php echo $tagihan[$a]["pembayaran"][0]["attachment"];?>" target = "_blank" class = "btn btn-outline btn-primary btn-sm">DOCUMENT</a>
                                        </div>
                                    </div>
                                    <div class = "modal-footer">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php endif;?>
                </td>
                <?php endfor;?>
            </tr>
        </tbody>
    </table>
</div>