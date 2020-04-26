<div class="panel-body col-lg-12">
    <div class="row row-lg">
        <div class="col-xl-12">
            <!-- Example Tabs Left -->
            <div class="example-wrap">
                <div class="nav-tabs-vertical" data-plugin="tabs">
                    <ul class="nav nav-tabs mr-25" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#primaryData" aria-controls="primaryData" role="tab">Primary Data</a></li>

                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#items" aria-controls="pengiriman" role="tab">Items</a></li>

                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#payment" aria-controls="produksi" role="tab">Pembayaran</a></li>
                        
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#detail" aria-controls="produksi2" role="tab">Detail OC</a></li>
                        
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#tambahan" aria-controls="pengiriman" role="tab">S&K OC</a></li>

                    </ul>
                    <form action = "<?php echo base_url();?>crm/oc/editoc" method = "post">    
                        <div class="tab-content">
                            <div class="tab-pane active" id="primaryData" role="tabpanel">
                            <input type = "hidden" name = "id_submit_oc" value = "<?php echo $detail[0]["id_submit_oc"];?>">
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">No OC</h5>
                                    <input type = "text" value = "<?php echo $detail[0]["no_oc"];?>" class = "form-control" name = "no_oc">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Id OC</h5>
                                    <input type = "text" value = "<?php echo $detail[0]["id_oc"];?>" class = "form-control" name = "id_oc">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Tahun OC</h5>
                                    <input 
                                        type ="text" 
                                        value = "<?php echo $detail[0]["tahun_oc"];?>"
                                        class = "form-control" 
                                        required 
                                        name = "tahun_oc"
                                    />
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Bulan OC</h5>
                                    <select class = "form-control" name = "bulan_oc" data-plugin = "select2">
                                        <?php
                                        $name = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
                                        $bulan = array('01','02','03','04','05','06','07','08','09','10','11','12');
                                        for($b = 0; $b<count($name); $b++):?>
                                        <option <?php if($bulan[$b] == $detail[0]["bulan_oc"]) echo "selected";?> value = "<?php echo $bulan[$b];?>"><?php echo $name[$b];?></option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Perusahaan Customer</h5>
                                    <input type ="text" id = "nama_perusahaan" value = "<?php echo $detail[0]["nama_perusahaan"];?>" class = "form-control perusahaanCust" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Nama Customer</h5>
                                    <input id = "namaCust" type ="text" value = "<?php echo $detail[0]["nama_cp"];?>" class = "form-control namaCust" readonly>
                                </div>
                            </div>
                            <!-- fungsi -->
                            <div class="tab-pane" id="items" role="tabpanel">
                                
                                <div class = "form-group col-lg-12">
                                <table class = "table table-stripped col-lg-12" style = "width:100%" data-plugin = "dataTable">
                                        <thead>
                                            <th>Add</th>
                                            <th>Delete</th>
                                            <th>Product Name</th>
                                            <th>Product Catalog</th>
                                            <th>Amount</th>
                                            <th>Final Price (Per item)</th>
                                        </thead>
                                        <tbody id ="t1">
                                            <?php for($a = 0; $a<count($items); $a++):?>
                                            <tr>
                                                <input type = "hidden" name = "status_ada_item<?php echo $items[$a]["id_quotation_item"];?>" value = "<?php echo $items[$a]["id_oc_item"]; ?>">
                                                <td>
                                                    <div class = "checkbox-custom checkbox-primary" >
                                                        <input id = "checks<?php echo $a;?>" type = "checkbox" name = "checks[]" value = "<?php echo $items[$a]["id_quotation_item"];?>" checked>
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if($items[$a]["id_oc_item"] != ""):?>
                                                    <div class = "checkbox-custom checkbox-primary" >
                                                        <input type = "checkbox" name = "delete[]" value = "<?php echo $items[$a]["id_oc_item"];?>">
                                                        <label></label>
                                                    </div>
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                    <textarea name = "nama_oc_item<?php echo $items[$a]["id_quotation_item"];?>" class = "form-control"><?php if($items[$a]["nama_oc_item"] != "") echo $items[$a]["nama_oc_item"]; else echo ($items[$a]["nama_produk_leiter"]);?></textarea>
                                                </td>
                                                <td>
                                                    <span id = "produkNotFound<?php echo $a;?>" style = "color:red; display:none">PRODUCT NOT FOUND</span>
                                                    <input placeholder = "search item here..." type = "text" class = "form-control" id = "namaproduk<?php echo $a;?>" oninput = "searchProdukByName('<?php echo $a;?>')">
                                                    <select class = "form-control" id = "similarProduk<?php echo $a;?>" name = "id_produk<?php echo $items[$a]["id_quotation_item"];?>">
                                                        <?php if($items[$a]["id_produk"] == "" || $items[$a]["id_produk"] == "-1"):?>
                                                        <option value = "0"></option>
                                                        <?php else:?>
                                                        <option value = "<?php echo $items[$a]["id_produk"];?>"><?php echo $items[$a]["deskripsi_produk"];?></option>
                                                        <?php endif;?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input id = "jumlah_produk<?php echo $a;?>" type = "text" name = "final_amount<?php echo $items[$a]["id_quotation_item"];?>" class = "form-control" value = "<?php if($items[$a]["final_amount_oc"] == "") echo $items[$a]["item_amount_quotation"]." ".$items[$a]["satuan_produk_quotation"]; else echo $items[$a]["final_amount_oc"]." ".$items[$a]["satuan_produk_oc"];?>">
                                                </td>
                                                <td>
                                                    <input id = "selling_price<?php echo $a;?>" type = "text" oninput = "commas('selling_price<?php echo $a;?>')" name ="final_selling_price<?php echo $items[$a]["id_quotation_item"];?>" class = "form-control" value = "<?php if($items[$a]["final_selling_price_oc"] == "") echo number_format($items[$a]["selling_price_quotation"],2); else echo number_format($items[$a]["final_selling_price_oc"],2);?>">
                                                </td>
                                            </tr>
                                            <?php endfor;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="payment" role="tabpanel">
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Total Quotation Amount</h5>
                                    <input type = "text" id = "totalQuotation" value = "<?php echo number_format($detail[0]["total_oc_price"],2);?>" class = "form-control" name = "total_oc_price" readonly onclick = "countTotal()">
                                </div>
                                <div class = "row">
                                    <div class = "form-group col-lg-4 containerDp" style = ""> <!-- textarea klo DP % -->
                                        <h5 style = "opacity:0.5">DP (%)</h5>
                                        <input name = "persentase_pembayaran" value = "<?php echo $pembayaran[0]["persentase_pembayaran"];?>%" id = "persenDp" oninput = "paymentWithDP()" type ="text" class = "form-control">
                                    </div>
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">Payment Method</h5>
                                        <select class = "form-control" id = "paymentMethod" name = "trigger_pembayaran">
                                            <option value = "1">BEFORE DELIVERY</option>
                                        </select>
                                    </div>
                                    <div class = "form-group col-lg-4 containerDp" style = ""> <!-- Nominal DP -->
                                        <h5 style = "opacity:0.5">Jumlah DP</h5>
                                        <input name = "nominal_pembayaran" value = "<?php echo number_format($pembayaran[0]["nominal_pembayaran"],2);?>" id = "jumlahDp" type ="text" class = "form-control">
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "form-group col-lg-4 containerSisa" style = ""> <!-- textarea klo DP% -->
                                        <h5 style = "opacity:0.5">Pelunasan (%)</h5>
                                        <input name = "persentase_pembayaran2" value = "<?php echo $pembayaran[0]["persentase_pembayaran2"];?>%" id = "persenSisa" type ="text" class = "form-control">
                                    </div>
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">Payment Method</h5>
                                        <select class = "form-control" id = "paymentMethod" name = "trigger_pembayaran2">
                                            <option value = "2">AFTER DELIVERY</option>
                                            <option value = "1" <?php if($pembayaran[0]["trigger_pembayaran2"] == 1) echo "selected"; ?> >BEFORE DELIVERY</option>
                                        </select>
                                    </div>  
                                    <div class = "form-group col-lg-4 containerSisa" style = ""> <!-- Nominal DP -->
                                        <h5 style = "opacity:0.5">Jumlah Pelunasan</h5>
                                        <input name = "nominal_pembayaran2" value = "<?php echo number_format($pembayaran[0]["nominal_pembayaran2"],2);?>" id = "jumlahSisa" type ="text" class = "form-control">
                                    </div>
                                </div>
                                <!-- end ngeloadnya pembayaran -->
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Durasi Pembayaran</h5>
                                    <input name = "durasi_pembayaran" value = "<?php echo $detail[0]["durasi_pembayaran_oc"];?>" id = "durasi_pembayaran" type ="text" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Mata Uang Pembayaran</h5>
                                    <input name = "mata_uang_pembayaran" value = "<?php echo $pembayaran[0]["kurs"];?>" id = "kurs" type ="text" class = "form-control">
                                </div>
                            </div>
                            <!-- dokumen -->
                            <div class="tab-pane" id="detail" role="tabpanel">
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">No PO Customer</h5>
                                    <input name = "no_po_customer" value = "<?php echo $detail[0]["no_po_customer"];?>" type ="text" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Tanggal PO Customer</h5>
                                    <input name = "tgl_po_customer" type ="date" class = "form-control" value = "<?php echo $detail[0]["tgl_po_customer"];?>">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Perusahaan Customer</h5>
                                    <input type ="text" value = "<?php echo $detail[0]["nama_perusahaan"];?>" class = "form-control perusahaanCust" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Nama Customer</h5>
                                    <input type ="text" value = "<?php echo $detail[0]["nama_cp"];?>" class = "form-control namaCust" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Alamat Customer</h5>
                                    <textarea class = "form-control" id ="alamatCust" name = "alamat_perusahaan_oc" ><?php echo $detail[0]["alamat_perusahaan_oc"];?></textarea>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Up Nama Customer</h5>
                                    <input name = "up_cp" id = "up_cp" type ="text" class = "form-control" value = "<?php echo $detail[0]["up_cp_oc"];?>"> 
                                </div>
                            </div>
                            <div class="tab-pane" id="tambahan" role="tabpanel">
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Durasi Pengiriman</h5>
                                    <input name = "durasi_pengiriman" id = "durasi_pengiriman" value = "<?php echo $detail[0]["durasi_pengiriman_oc"];?>" type ="text" class = "form-control"> 
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Metode Pengiriman</h5> <!-- by air land atau sea -->
                                    <input name = "metode_pengiriman" id = "metode_courier" value = "<?php echo $detail[0]["metode_pengiriman"];?>" type ="text" class = "form-control"> 
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Franco</h5>
                                    <input name = "franco" id = "franco" type ="text" value = "<?php echo $detail[0]["franco_oc"];?>" class = "form-control"> 
                                </div>
                                
                                <button class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                    <a href = "<?php echo base_url();?>crm/oc/page/<?php echo $this->session->page;?>" class = "btn btn-primary btn-outline btn-sm">BACK</a>
                </div>
            </div>
            <!-- End Example Tabs Left -->
        </div>
    </div>
</div>
