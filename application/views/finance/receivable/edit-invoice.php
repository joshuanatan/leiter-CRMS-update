<div class="panel-body col-lg-12">
    <div class="row row-lg">
        <div class="col-xl-12">
            <!-- Example Tabs Left -->
            <div class="example-wrap">
                <div class="nav-tabs-vertical" data-plugin="tabs">
                    <ul class="nav nav-tabs mr-25" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#primaryData" aria-controls="primaryData" role="tab">Primary Data</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#document" aria-controls="pengiriman" role="tab">Document</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#box" aria-controls="pengiriman" role="tab">Box</a></li>

                    </ul>
                    <form action = "<?php echo base_url();?>finance/receivable/editinvoice" method = "post">    
                        <div class="tab-content">
                            <div class="tab-pane active" id="primaryData" role="tabpanel">
                                <div class = "form-group"> <!-- nanti bentuknya nomorquotation/versi -->
                                    <h5 style = "color:darkgrey; opacity:0.8">Invoice No</h5> <!-- max id -->
                                    <input name = "no_invoice" type ="text" value = "<?php echo $invoice[0]["no_invoice"];?>" class = "form-control" >
                                    <input id="" name = "id_submit_invoice" type ="hidden" value = "<?php echo $invoice[0]["id_submit_invoice"];?>" class = "form-control" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Id Invoice</h5>
                                    <input name = "id_invoice" type ="text" value = "<?php echo $invoice[0]["id_invoice"];?>" class = "form-control" >
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Tahun Invoice</h5>
                                    <input 
                                        type ="text" 
                                        value = "<?php echo $invoice[0]["tahun_invoice"];?>"
                                        class = "form-control" 
                                        required 
                                        name = "tahun_invoice"
                                    />
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Bulan Invoice</h5>
                                    <select class = "form-control" name = "bulan_invoice" data-plugin = "select2">
                                        <?php
                                        $name = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
                                        $bulan = array('01','02','03','04','05','06','07','08','09','10','11','12');
                                        for($b = 0; $b<count($name); $b++):?>
                                        <option <?php if($bulan[$b] == $invoice[0]["bulan_invoice"]) echo "selected";?> value = "<?php echo $bulan[$b];?>"><?php echo $name[$b];?></option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Customer PO</h5>
                                    <input name = "id_submit_oc" type ="text" value = "<?php echo $invoice[0]["no_po_customer"];?>" class = "form-control" readonly>
                                </div>
                                
                                <div class = "form-group"> <!-- nanti bentuknya nomorquotation/versi -->
                                    <h5 style = "color:darkgrey; opacity:0.8">Payment Type</h5> <!-- ngejax di item --> 
                                    <select data-plugin = "select2" class = "form-control" id = "payment_type" name = "tipe_invoice">
                                        <option value = "1">PELUNASAN TANPA DP</option>
                                        <option value = "2"<?php if($invoice[0]["tipe_invoice"] == 2) echo "selected";?>>DOWN PAYMENT</option>
                                        <option value = "3"<?php if($invoice[0]["tipe_invoice"] == 3) echo "selected";?>>PELUNASAN DENGAN DP</option>
                                    </select>
                                </div>
                                <div class = "form-group"> <!-- nanti bentuknya nomorquotation/versi -->
                                    <h5 style = "color:darkgrey; opacity:0.8">Order Delivery</h5> <!-- ngejax di item --> 
                                    <select data-plugin = "select2" class = "form-control" id = "payment_type" name = "od">
                                        <option value = "0">TIDAK ADA OD</option>
                                        <?php for($b = 0; $b<count($od); $b++):?>
                                        <option value = "<?php echo $od[$b]["id_submit_od"];?>"><?php echo $od[$b]["no_od"];?></option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                            </div>
                            <!-- fungsi -->
                            
                            <div class="tab-pane" id="document" role="tabpanel">   
                                <div class = "form-group"> <!-- nanti bentuknya nomorquotation/versi -->
                                    <h5 style = "color:darkgrey; opacity:0.8">Harga Total PO</h5> <!-- ngejax di item --> 
                                    <input value = "<?php echo number_format($invoice[0]["total_oc_price"],2);?>" type = "text" class = "form-control" id = "total_tagihan_po" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Sub Total</h5>
                                    <input name = "nominal_pembayaran" id = "nominal_pembayaran" type ="text" class = "form-control namaCust" value = "<?php echo number_format($invoice[0]["nominal_invoice"],2);?>">
                                </div> 
                                <div class = "checkbox-custom checkbox-primary">
                                    <input type = "checkbox" name = "ppn[]" <?php if($invoice[0]["is_ppn"] == 0) echo "checked";?>>
                                    <label>PPN</label> 
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Franco Penyerahan</h5>
                                    <input name = "franco" id = "franco" type ="text" class = "form-control namaCust" value = "<?php echo $invoice[0]["franco_invoice"];?>">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Att</h5>
                                    <input name = "att" id = "att" type ="text" value = "<?php echo $invoice[0]["att"];?>" class = "form-control namaCust">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Alamat Penagihan</h5>
                                    <textarea class = "form-control" id = "alamat_penagihan" name = "alamat_penagihan"><?php echo $invoice[0]["alamat_penagihan"];?></textarea>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Durasi Pembayaran</h5>
                                    <input name = "durasi_pembayaran" id = "durasi_pembayaran" type ="text" class = "form-control namaCust" value = "<?php echo $invoice[0]["durasi_pembayaran"];?>">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Jatuh Tempo</h5>
                                    <input name = "jatuh_tempo" id = "jatuh_tempo" type ="date" class = "form-control namaCust" value = "<?php echo $invoice[0]["jatuh_tempo"];?>">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Rekening Pembayaran</h5>
                                    <input name = "no_rekening" id = "no_rekening" type ="text" value = "<?php echo $invoice[0]["no_rekening"];?>" class = "form-control namaCust">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Sign Off</h5>
                                    <input name = "sign_off" id = "sign_off" type ="text" value = "<?php echo $invoice[0]["sign_off"];?>" class = "form-control namaCust">
                                </div>
                            </div>
                            <div class="tab-pane" id="box" role="tabpanel">
                                <div class = "form-group col-lg-12 method2" id="boxes">
                                    <table data-plugin = "dataTable" class = "table table-stripped col-lg-12" style = "width:100%;">
                                        <thead>
                                            <th>Add</th>
                                            <th>Delete</th>
                                            <th>No Box</th>
                                            <th>Jumlah Box</th>
                                            <th>Berat Bersih</th>
                                            <th>Berat Kotor</th>
                                            <th>Dimensi (P * L * T satuan)</th>
                                        </thead>
                                        <tbody>
                                            <?php for($a = 0; $a<count($box); $a++):?>
                                            <tr>
                                                <td>
                                                    <div class = "checkbox-custom checkbox-primary">
                                                        <input type = "hidden" value = "<?php echo $box[$a]["id_packaging"];?>" name = "id_packaging<?php echo $a;?>">

                                                        <input type = "checkbox" value = "<?php echo $a;?>" name = "checks[]" checked>
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class = "checkbox-custom checkbox-primary">
                                                        <input type = "checkbox" value = "<?php echo $box[$a]["id_packaging"];?>" name = "delete[]">
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type = "text" class = "form-control" value = "<?php echo $box[$a]["no_box"];?>" name = "no_box<?php echo $a;?>">
                                                </td>
                                                <td>
                                                    <input type = "text" class = "form-control" value = "" name = "jumlah_box<?php echo $a;?>">
                                                </td>
                                                <td>
                                                    <input type = "text" class = "form-control" value = "<?php echo $box[$a]["berat_bersih"];?>" name = "berat_bersih<?php echo $a;?>">
                                                </td>
                                                <td>
                                                    <input type = "text" class = "form-control" value = "<?php echo $box[$a]["berat_kotor"];?>" name = "berat_kotor<?php echo $a;?>">
                                                </td>
                                                <td>
                                                    <input type = "text" class = "form-control" value = "<?php echo $box[$a]["dimensi_box"];?>" name = "dimensi_box<?php echo $a;?>">
                                                </td>
                                            </tr>
                                            <?php endfor;?>
                                            <?php for($a = count($box); $a<20; $a++):?>
                                            <tr>
                                                <td>
                                                    <input type = "hidden" value = "" name = "id_packaging<?php echo $a;?>">
                                                    <div class = "checkbox-custom checkbox-primary">
                                                        <input type = "checkbox" value = "<?php echo $a;?>" name = "checks[]">
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td></td>
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
                                    <button type = "submit" class = "btn btn-primary btn-outline btn-sm">UPDATE INVOICE</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <a href = "<?php echo base_url();?>finance/receivable" class = "btn btn-primary btn-sm ">BACK</a>
                </div>
            </div>
            <!-- End Example Tabs Left -->
        </div>
    </div>
</div>
