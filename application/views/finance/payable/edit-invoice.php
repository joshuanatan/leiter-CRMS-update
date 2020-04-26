<div class="panel-body col-lg-12">
    <div class="row row-lg">
        <div class="col-xl-12">
            <!-- Example Tabs Left -->
            <div class="example-wrap">
                <div class="nav-tabs-vertical" data-plugin="tabs">
                    <ul class="nav nav-tabs mr-25" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#primaryData" aria-controls="primaryData" role="tab">Primary Data</a></li>
                        
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#detailData" aria-controls="primaryData" role="tab">Detail Data</a></li>
                    </ul>
                    <form action = "<?php echo base_url();?>finance/payable/editinvoice" method = "post" enctype = "multipart/form-data">    
                        <div class="tab-content">
                            <div class="tab-pane active" id="primaryData" role="tabpanel">
                                <input type = "hidden" value = "<?php echo $tagihan["id_tagihan"];?>" name = "id_tagihan">
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">No Invoice</h5>
                                    <input type = "text" class = "form-control" name = "no_invoice" placeholder = "Nomor Invoice Masuk" value = "<?php echo $tagihan["no_invoice"];?>">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Payment For</h5>
                                    
                                    <select class = "form-control" name = "peruntukan_tagihan" id ="peruntukan">
                                        <option value = "SUPPLIER">SUPPLIER</option>
                                        <option value = "SHIPPER" <?php if($tagihan["peruntukan_tagihan"] == "SHIPPER") echo "selected"; ?> >SHIPPER</option>
                                        <option value = "COURIER" <?php if($tagihan["peruntukan_tagihan"] == "COURIER") echo "selected"; ?> >COURIER</option>
                                    </select>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">No Refrence</h5> <!-- Nanti ajax, kalau pilih supplier/shipper ngeload nomor po vendor, kalau courier, no OD -->
                                    <input type = "text" class = "form-control" id ="no_refrence" oninput = "isExistsInRefrence()" name = "no_refrence" placeholder = "No refrensi PO Vendor/ Order Delivery" value = "<?php echo $tagihan["no_refrence"];?>">
                                    <h5 class = "color:red" id = "resultMessage"></h5>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Transfer To</h5>
                                    <input type = "text" class = "form-control" name = "rekening" placeholder = "Rekening Bank untuk Pembayaran" value = "<?php echo $tagihan["rekening_pembayaran"];?>">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Dateline</h5>
                                    <input type = "date" class = "form-control" name = "dateline" value = "<?php echo $tagihan["dateline_invoice"];?>">
                                </div>
                            </div>
                            <div class="tab-pane" id="detailData" role="tabpanel">
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Subtotal</h5>
                                    <input type = "text" class = "form-control" oninput = "commas('subtotal')" id = "subtotal" name = "subtotal" placeholder = "Nominal tagihan dalam mata uang untuk pembayaran" value = "<?php echo number_format($tagihan["subtotal"]);?>">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Discount</h5>
                                    <input type = "text" class = "form-control" oninput = "commas('discount')" name = "discount" id = "discount" placeholder = "Nominal tagihan dalam mata uang untuk pembayaran" value = "<?php echo number_format($tagihan["discount"]);?>">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Total After Discount</h5>
                                    <input type = "text" class = "form-control" id = "afterDiscount" onfocus = "countAfterDiscont()" value = "<?php $total = splitterMoney($tagihan["subtotal"],",") - splitterMoney($tagihan["discount"],",") ;echo number_format($total);?>" readonly placeholder = "Tekan untuk mendapatkan Total">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Tax</h5>
                                    <div class="checkbox-custom checkbox-primary">
                                        <input type="checkbox" <?php if($tagihan["is_ppn"] == 0) echo "checked";?> id="inputUnchecked" name = "is_ppn[]">
                                        <label for="inputUnchecked">PPN</label>
                                    </div>
                                    <input type = "text" class = "form-control" name = "ppn" onfocus = "countPpn()" id = "afterPpn" readonly value = "<?php echo number_format($tagihan["ppn"]);?>">

                                    <div class="checkbox-custom checkbox-primary">
                                        <input type="checkbox" <?php if($tagihan["is_pph"] == 0) echo "checked"; ?> id="inputUnchecked" name = "is_pph[]">
                                        <label for="inputUnchecked">PPH 23</label>
                                    </div>
                                    <input type = "text" class = "form-control" name = "pph" value = "<?php echo number_format($tagihan["pph"]);?>" onfocus = "countPph()"  id = "afterPph" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Total</h5>
                                    <input type = "text" class = "form-control" value = "<?php echo number_format($tagihan["total"]);?>" onfocus = "countTotal()" name = "total" id = "total">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Currency (USD,IDR,EUR,etc)</h5>
                                    <input type = "text" placeholder = "Mata uang untuk pembayaran" class = "form-control" name = "mata_uang" value = "<?php echo $tagihan["mata_uang"];?>">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Notes</h5>
                                    <textarea class = "form-control" placeholder = "Dimasukan apabila ada kebutuhan" name = "notes_tagihan"><?php echo $tagihan["notes_tagihan"];?></textarea>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Attachment (File Invoice)</h5>
                                    <input type = "file" class = "form-control" name = "attachment" placeholder = "File Tagihan"><br/>
                                    <?php if($tagihan["attachment"] != "-"):?>
                                    <a href = "<?php echo base_url();?>assets/dokumen/invoice/<?php echo $tagihan["attachment"];?>" class = "btn btn-primary btn-outline btn-sm">ATTACHMENT</a>
                                    <?php endif;?>
                                </div>
                                <div class = "form-group">
                                    <button class = "btn btn-primary btn-sm">SUBMIT</button>
                                    
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <a href = "<?php echo base_url();?>finance/payable/index" class = "btn btn-primary btn-sm">BACK</a>
            </div>
            <!-- End Example Tabs Left -->
        </div>
    </div>
</div>
