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
                    <form action = "<?php echo base_url();?>crm/oc/insertoc" method = "post">    
                        <div class="tab-content">
                            <div class="tab-pane active" id="primaryData" role="tabpanel">
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">No Quotation</h5>
                                    <input value = "<?php echo $oc[0]["no_quotation"];?>" type ="text" class = "form-control" readonly> <!-- keisi sendiri dari db max(), bentuknya berformat -->
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">No OC</h5>
                                    <input value = "LI<?php echo date("Y");?><?php echo sprintf("%04d",$maxId);?>" type ="text" class = "form-control" readonly> <!-- keisi sendiri dari db max(), bentuknya berformat -->
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Perusahaan Customer</h5>
                                    <input type ="text" value = "<?php echo $oc[0]["nama_perusahaan"];?>" id = "nama_perusahaan" class = "form-control perusahaanCust" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Nama Customer</h5>
                                    <input  value = "<?php echo $oc[0]["nama_cp"];?>" name = "" id = "namaCust" type ="text" class = "form-control namaCust" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Total Quotation Price</h5>
                                    <input value = "<?php echo $oc[0]["no_quotation"];?>" name = "" id = "total_quotation_price" type ="text" class = "form-control" readonly>
                                </div>
                            </div>
                            <!-- fungsi -->
                            <div class="tab-pane" id="items" role="tabpanel">
                                <div class = "form-group col-lg-12">
                                    <table class = "table table-stripped col-lg-12" style = "width:100%" data-plugin = "dataTable">
                                        <thead>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Product Catalog</th>
                                            <th>Amount</th>
                                            <th>Final Price (Per item)</th>
                                        </thead>
                                        <tbody id ="t1">
                                            <?php for($a = 0; $a<count($items); $a++):?>
                                            <tr>
                                                <td>
                                                    <div class = "checkbox-custom checkbox-primary" >
                                                        <input id = "checks<?php echo $a;?>" type = "checkbox" name = "checks[]" value = "<?php echo $items[$a]["id_quotation_item"];?>" checked>
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <textarea name = "nama_oc_item<?php echo $items[$a]["id_quotation_item"];?>" class = "form-control"><?php echo ($items[$a]["nama_produk_leiter"]);?></textarea>
                                                </td>
                                                <td>
                                                    <span id = "produkNotFound<?php echo $a;?>" style = "color:red; display:none">PRODUCT NOT FOUND</span>
                                                    <input placeholder = "search item here..." type = "text" class = "form-control" id = "namaproduk<?php echo $a;?>" oninput = "searchProdukByName('<?php echo $a;?>')">
                                                    <select data-plugin = "select2" class = "form-control" id = "similarProduk<?php echo $a;?>" name = "id_produk<?php echo $items[$a]["id_quotation_item"];?>">
                                                        <option value = "0"></option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input id = "jumlah_produk<?php echo $a;?>" type = "text" name = "final_amount<?php echo $items[$a]["id_quotation_item"];?>" class = "form-control" value = "<?php echo $items[$a]["item_amount_quotation"]." ".$items[$a]["satuan_produk_quotation"];?>">
                                                </td>
                                                <td>
                                                    <input id = "selling_price<?php echo $a;?>" type = "text" oninput = "commas('selling_price<?php echo $a;?>')" name ="final_selling_price<?php echo $items[$a]["id_quotation_item"];?>" class = "form-control" value = "<?php echo number_format($items[$a]["selling_price_quotation"],2);?>">
                                                </td>
                                            </tr>
                                            <?php endfor;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="payment" role="tabpanel">
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Total Order Confirmation Amount</h5>
                                    <input type = "text" id = "totalQuotation" class = "form-control" name = "total_oc_price" value = "<?php echo number_format($oc[0]["total_quotation_price"],2);?>" readonly onclick = "countTotal()">
                                </div>
                                <div class = "row">
                                    <div class = "form-group col-lg-4 containerDp" style = ""> <!-- textarea klo DP % -->
                                        <h5 style = "opacity:0.5">DP (%)</h5>
                                        <input name = "persentase_pembayaran" id = "persenDp" oninput = "paymentWithDP()" value = "<?php echo $metode_pembayaran[0]["persentase_pembayaran"];?>" required type ="text" class = "form-control">
                                    </div>
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">Payment Method</h5>
                                        <select class = "form-control" id = "paymentMethod" name = "trigger_pembayaran">
                                            <option value = "1">BEFORE DELIVERY</option>
                                        </select>
                                    </div>
                                    <div class = "form-group col-lg-4 containerDp" style = ""> <!-- Nominal DP -->
                                        <h5 style = "opacity:0.5">Jumlah DP</h5>
                                        <input name = "nominal_pembayaran" value = "<?php echo number_format($metode_pembayaran[0]["nominal_pembayaran"],2);?>" required id = "jumlahDp" type ="text" class = "form-control">
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "form-group col-lg-4 containerSisa" style = ""> <!-- textarea klo DP% -->
                                        <h5 style = "opacity:0.5">Pelunasan (%)</h5>
                                        <input name = "persentase_pembayaran2" value = "<?php echo $metode_pembayaran[0]["persentase_pembayaran2"];?>" required id = "persenSisa" type ="text" class = "form-control">
                                    </div>
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">Payment Method</h5>
                                        <select class = "form-control" id = "paymentMethod" name = "trigger_pembayaran2">
                                            <option value = "1">BEFORE DELIVERY</option>
                                            <option value = "2" <?php if($metode_pembayaran[0]["trigger_pembayaran2"] == 2) echo "selected"; ?>>AFTER DELIVERY</option>
                                        </select>
                                    </div>  
                                    <div class = "form-group col-lg-4 containerSisa" style = ""> <!-- Nominal DP -->
                                        <h5 style = "opacity:0.5">Jumlah Pelunasan</h5>
                                        <input name = "nominal_pembayaran2" required value = "<?php echo number_format($metode_pembayaran[0]["nominal_pembayaran2"],2);?>" id = "jumlahSisa" type ="text" class = "form-control">
                                    </div>
                                </div>
                                <!-- end ngeloadnya pembayaran -->
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Durasi Pembayaran</h5>
                                    <input value = "<?php echo $oc[0]["durasi_pembayaran_quotation"];?>" name = "durasi_pembayaran" id = "durasi_pembayaran" required type ="text" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Mata Uang Pembayaran</h5>
                                    <input value = "<?php echo $metode_pembayaran[0]["kurs"];?>" name = "mata_uang_pembayaran" id = "kurs" type ="text" class = "form-control" readonly>
                                </div>
                            </div>
                            <!-- dokumen -->
                            <div class="tab-pane" id="detail" role="tabpanel">
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">No OC</h5>
                                    <input name ="no_oc" value = "LI<?php echo date("Y");?><?php echo sprintf("%04d",$maxId);?>" type ="text" class = "form-control" readonly> <!-- keisi sendiri dari db max(), bentuknya berformat -->
                                    <input value = "<?php echo $maxId;?>" type ="hidden" name = "id_oc" class = "form-control" readonly> <!-- buat isi dalam bentuk angka -->
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">No PO Customer</h5>
                                    <input name = "no_po_customer" required type ="text" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Tanggal PO Customer</h5>
                                    <input name = "tgl_po_customer" required type ="date" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Perusahaan Customer</h5>
                                    <input type ="text" value = "<?php echo $oc[0]["nama_perusahaan"];?>" id = "nama_perusahaan" class = "form-control perusahaanCust" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Nama Customer</h5>
                                    <input  value = "<?php echo $oc[0]["nama_cp"];?>" name = "" id = "namaCust" type ="text" class = "form-control namaCust" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Alamat Customer</h5>
                                    <textarea class = "form-control" id ="alamatCust" name = "alamat_perusahaan_oc"><?php echo $oc[0]["alamat_perusahaan"];?></textarea>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Up Nama Customer</h5>
                                    <input name = "up_cp" id = "up_cp" value = "<?php echo $oc[0]["up_cp_quotation"];?>" type ="text" required class = "form-control">
                                </div>
                            </div>
                            <div class="tab-pane" id="tambahan" role="tabpanel">
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Durasi Pengiriman</h5>
                                    <input required value = "<?php echo $oc[0]["durasi_pengiriman_quotation"];?>" name = "durasi_pengiriman" id = "durasi_pengiriman" type ="text" class = "form-control"> 
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Metode Pengiriman</h5> <!-- by air land atau sea -->
                                    <input required name = "metode_pengiriman" id = "metode_courier" type ="text" class = "form-control"> 
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Franco</h5>
                                    <input required value = "<?php echo $oc[0]["franco_quotation"] ?>" name = "franco" id = "franco" type ="text" class = "form-control"> 
                                </div>
                                
                                <button class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <a href = "<?php echo base_url();?>crm/oc/page/<?php echo $this->session->page;?>" class = "btn btn-primary btn-outline btn-sm">BACK</a>
            <!-- End Example Tabs Left -->
        </div>
    </div>
</div>
