<?php $noinvoice = date("y").date("m").sprintf("%02d",$maxId)."/LI/".date("m")."/".date('y');?>
<div class="panel-body col-lg-12">
    <div class="row row-lg">
        <div class="col-xl-12">
            <!-- Example Tabs Left -->
            <div class="example-wrap">
                <div class="nav-tabs-vertical" data-plugin="tabs">
                    <ul class="nav nav-tabs mr-25" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#primaryData" aria-controls="primaryData" role="tab">Primary Data</a></li>

                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#items" aria-controls="pengiriman" role="tab">Items</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#document" aria-controls="pengiriman" role="tab">Document</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#box" aria-controls="pengiriman" role="tab">Box</a></li>

                    </ul>
                    <form action = "<?php echo base_url();?>finance/receivable/createinvoice" method = "post">    
                        <div class="tab-content">
                            <div class="tab-pane active" id="primaryData" role="tabpanel">
                                <div class = "form-group"> <!-- nanti bentuknya nomorquotation/versi -->
                                    <h5 style = "color:darkgrey; opacity:0.8">Invoice No</h5> <!-- max id -->
                                    <input name = "no_invoice" type ="text" value = "<?php echo $noinvoice;?>" class = "form-control" readonly>
                                    <input id="" name = "id_invoice" type ="hidden" value = "<?php echo $maxId;?>" class = "form-control" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Customer PO</h5>
                                    
                                    <select onchange = "oc_detail()" id = "id_submit_oc" name = "id_submit_oc" class = "form-control" data-plugin ="select2">
                                        <option value = "0" disabled selected>Choose Customer PO</option>
                                        <?php for($a = 0;  $a<count($oc); $a++): ?>
                                        <option value = "<?php echo $oc[$a]["id_submit_oc"];?>-<?php echo $oc[$a]["id_perusahaan"];?>"><?php echo $oc[$a]["no_po_customer"];?> - <?php echo $oc[$a]["nama_perusahaan"];?> <?php if($oc[$a]["not_new"] == 1):?><span>[ NEW ]</span><?php endif;?></option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                                
                                <div class = "form-group"> <!-- nanti bentuknya nomorquotation/versi -->
                                    <h5 style = "color:darkgrey; opacity:0.8">Payment Type</h5> <!-- ngejax di item --> 
                                    <select data-plugin = "select2" class = "form-control" id = "payment_type" name = "tipe_invoice" onchange = "changePayment()">
                                    </select>
                                </div>
                                
                                

                                <div class = "form-group dp" style = "display:none"> <!-- nanti bentuknya nomorquotation/versi -->
                                    <h5 style = "color:darkgrey; opacity:0.8">Dp (%)</h5> <!-- ngejax di item --> 
                                    <input type = "text" class = "form-control" id = "persen_dp" readonly>
                                </div>
                                <div class = "form-group pelunasan" style = "display:none"> <!-- nanti bentuknya nomorquotation/versi -->
                                    <h5 style = "color:darkgrey; opacity:0.8">Pelunasan (%)</h5> <!-- ngejax di item --> 
                                    <input type = "text" class = "form-control" id = "persen_sisa" readonly>
                                </div>
                                
                                <div class = "form-group dp" style = "display:none"> <!-- nanti bentuknya nomorquotation/versi -->
                                    <h5 style = "color:darkgrey; opacity:0.8">Total Dp</h5> <!-- ngejax di item --> 
                                    <input type = "text" class = "form-control" id = "total_dp" readonly>
                                </div>
                                <div class = "form-group pelunasan" style = "display:none"> <!-- nanti bentuknya nomorquotation/versi -->
                                    <h5 style = "color:darkgrey; opacity:0.8">Total Sisa</h5> <!-- ngejax di item --> 
                                    <input type = "text" class = "form-control" id = "total_sisa" readonly>
                                </div>
                                
                                <div class = "form-group">
                                    <a href = "<?php echo base_url();?>finance/receivable" class = "btn btn-sm btn-primary btn-outline col-lg-2">BACK</a>
                                </div>
                            </div>
                            <!-- fungsi -->
                            <div class="tab-pane" id="items" role="tabpanel">
                                <div class = "form-group" id = "od_container"> <!-- nanti bentuknya nomorquotation/versi -->
                                    <h5 style = "color:darkgrey; opacity:0.8">Order Delivery No</h5> <!-- ngejax di item --> 
                                    <select data-plugin = "select2" class = "form-control" name = "id_od" id = "od" onchange = "loadOdItem()">
                                        <option>Choose Order Delivery No</option>
                                    </select>
                                </div>
                                
                                <div class = "form-group col-lg-12 method2">
                                    <table class = "table table-stripped col-lg-12" id="paymentWithOd" style = "width:100%;">
                                        <thead>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Amount</th>
                                            <th>Selling Price</th>
                                            <th>Final Price</th>
                                        </thead>
                                        <tbody id ="list_item_oc">
                                            <!-- di load pake foreach abis onchange -->
                                            <!-- bentuknya checklist, nanti yang ke checklist masuk ke db -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class = "form-group">
                                    <div class="checkbox-custom checkbox-primary">
                                        <input type="checkbox" id="inputUnchecked" checked name = "ppn[]">
                                        <label for="inputUnchecked">PPN</label>
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <a href = "<?php echo base_url();?>finance/receivable" class = "btn btn-sm btn-primary btn-outline col-lg-2">BACK</a>
                                </div>
                            </div>
                            <div class="tab-pane" id="document" role="tabpanel">   
                                <div class = "form-group"> <!-- nanti bentuknya nomorquotation/versi -->
                                    <h5 style = "color:darkgrey; opacity:0.8">Harga Total PO</h5> <!-- ngejax di item --> 
                                    <input type = "text" class = "form-control" id = "total_tagihan_po" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Sub Total</h5>
                                    <input name = "nominal_pembayaran" id = "nominal_pembayaran" readonly type ="text" class = "form-control namaCust">
                                </div> 
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Franco Penyerahan</h5>
                                    <input name = "franco" id = "franco" type ="text" class = "form-control namaCust">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Att</h5>
                                    <input name = "att" id = "att" type ="text" class = "form-control namaCust">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Alamat Penagihan</h5>
                                    <textarea class = "form-control" id = "alamat_penagihan" name = "alamat_penagihan"></textarea>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Durasi Pembayaran</h5>
                                    <input name = "durasi_pembayaran" id = "durasi_pembayaran" type ="text" class = "form-control namaCust">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Jatuh Tempo</h5>
                                    <input name = "jatuh_tempo" id = "jatuh_tempo" type ="date" class = "form-control namaCust">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Rekening Pembayaran</h5>
                                    <input name = "no_rekening" id = "no_rekening" type ="text" value = "489O-335-581" class = "form-control namaCust">
                                </div>
                                
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Sign Off</h5>
                                    <input name = "sign_off" id = "sign_off" type ="text" value = "Teguh Budiaryanto" class = "form-control namaCust">
                                </div>

                                <div class = "form-group">
                                    <a href = "<?php echo base_url();?>finance/receivable" class = "btn btn-sm btn-primary btn-outline col-lg-2">BACK</a>
                                </div>
                            </div>
                            <div class="tab-pane" id="box" role="tabpanel">
                                <div class = "form-group col-lg-12 method2" id="boxes">
                                    <table data-plugin = "dataTable" class = "table table-stripped col-lg-12" style = "width:100%;">
                                        <thead>
                                            <th>#</th>
                                            <th>No Box</th>
                                            <th>Jumlah Box</th>
                                            <th>Berat Bersih</th>
                                            <th>Berat Kotor</th>
                                            <th>Dimensi (P * L * T satuan)</th>
                                        </thead>
                                        <tbody>
                                            <?php for($a = 0; $a<20; $a++):?>
                                            <tr>
                                                <td>
                                                    <div class = "checkbox-custom checkbox-primary">
                                                        <input type = "checkbox" value = "<?php echo $a;?>" name = "checks[]">
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type = "text" class = "form-control" name = "no_box<?php echo $a;?>">
                                                </td>
                                                <td>
                                                    <input type = "text" class = "form-control" name = "jumlah_box<?php echo $a;?>">
                                                </td>
                                                <td>
                                                    <input type = "text" class = "form-control" name = "berat_bersih<?php echo $a;?>">
                                                </td>
                                                <td>
                                                    <input type = "text" class = "form-control" name = "berat_kotor<?php echo $a;?>">
                                                </td>
                                                <td>
                                                    <input type = "text" class = "form-control" name = "dimensi_box<?php echo $a;?>">
                                                </td>
                                            </tr>
                                            <?php endfor;?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class = "form-group">
                                    <button type = "submit" class = "btn btn-primary btn-outline col-lg-2 btn-sm">CREATE INVOICE</button>
                                    <a href = "<?php echo base_url();?>finance/receivable" class = "btn btn-primary btn-sm btn-outline col-lg-2">BACK</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Example Tabs Left -->
        </div>
    </div>
</div>
