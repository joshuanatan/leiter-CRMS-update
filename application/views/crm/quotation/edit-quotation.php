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
                        
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#detail" aria-controls="produksi2" role="tab">Detail Quotation</a></li>
                        
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#tambahan" aria-controls="pengiriman" role="tab">S&K Quotation</a></li>

                    </ul>
                    <form action = "<?php echo base_url();?>crm/quotation/editquotation" method = "post" enctype = "multipart/form-data">    
                        <div class="tab-content">
                            <div class="tab-pane active" id="primaryData" role="tabpanel">
                                <input type = "hidden" name = "id_submit_quotation" value = "<?php echo $quotation["id_submit_quotation"];?>" id = "id_submit_quotation">
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">RFQ</h5>
                                    <input type = "text" readonly class = "form-control" value = "<?php echo $quotation["no_request"];?>">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Quotation No</h5> <!-- nanti ganti jadi select -->
                                    <input id = "no_quotation" name = "no_quotation" type ="text" class = "form-control" readonly  value = "<?php echo $quotation["no_quotation"];?>">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Quotation Versi</h5>
                                    <input name = "versi_quotation" id = "versi_quotation" value = "<?php echo $quotation["versi_quotation"];?>" readonly type ="text" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Perusahaan Customer</h5>
                                    <input type ="text" class = "form-control perusahaanCust" value = "<?php echo $quotation["nama_perusahaan"];?>" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Nama Customer</h5>
                                    <input name = "" type ="text" value = "<?php echo $quotation["nama_cp"];?>" class = "form-control namaCust" readonly>
                                </div>
                            </div>
                            <!-- fungsi -->
                            <div class="tab-pane" id="items" role="tabpanel">
                                <div class = "row">
                                    <div class = "form-group col-lg-5">
                                        <h5 style = "opacity:0.5">Items</h5>
                                        <select class = "form-control" id = "itemsOrdered" data-plugin = "select2" onchange = "loadVendors()">
                                            <option selected disabled>Choose Item</option>
                                            <?php for($item = 0; $item<count($request_item); $item++):?>
                                            <option value = "<?php echo $request_item[$item]["id_request_item"];?>"><?php echo $request_item[$item]["nama_produk"]; ?></option>
                                            <?php endfor;?>
                                        </select>
                                    </div>
                                    <div class = "form-group col-lg-2">
                                        <h5 style = "opacity:0.5">Quantity</h5>
                                        <input name = "Abc" type ="text" class = "form-control" id = "itemamount" value = "">
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "form-group col-lg-5">
                                        <h5 style = "opacity:0.5">Supplier</h5>
                                        <select data-plugin = "select2" class = "form-control" id = "products" onchange = "getVendorPrice()">
                                            <option selected disabled>Choose Product Vendor</option>
                                        </select>
                                    </div>
                                    <div class = "form-group col-lg-5">
                                        <h5 style = "opacity:0.5">Supplier Price (Per satuan)</h5>
                                        <input name = "Abc" type ="text" id = "hargaProduk" class = "form-control" disabled placeholder = "Product Price">
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "form-group col-lg-5">
                                        <h5 style = "opacity:0.5">Shipping</h5>
                                        <select data-plugin = "select2" class = "form-control" id="shippers" onchange = "getShippingPrice()">
                                            <option selected disabled>Choose Shipping Vendor</option>
                                        </select>
                                    </div>
                                    <div class = "form-group col-lg-5">
                                        <h5 style = "opacity:0.5">Shipping Price (Per satuan)</h5>
                                        <input name = "Abc" type ="text" id = "hargashipping" class = "form-control" disabled placeholder = "Shipping Price">
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "form-group col-lg-5">
                                        <h5 style = "opacity:0.5">Courier</h5>
                                        <select data-plugin = "select2" class = "form-control" id = "courier" onchange = "getCourierPrice()">
                                            <option selected disabled>Choose Courier</option>
                                        </select>
                                    </div>
                                    <div class = "form-group col-lg-5">
                                        <h5 style = "opacity:0.5">Courier Price (Per satuan)</h5>
                                        <input name = "Abc" type ="text" id = "hargaCourier" class = "form-control" disabled placeholder = "Courier Price">
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Nama Produk Leiter</h5>
                                    <textarea class = "form-control" id = "nama_produk_leiter" name = "nama_produk_leiter"></textarea>
                                </div>
                                <div class = "form-group" onclick = "getTotal()">
                                    <h5 style = "opacity:0.5">Total Price (All Qty)</h5>
                                    <input name = "Abc"  type ="text" class = "form-control" id = "totalPrice" disabled placeholder = "Click to get Total Price">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Selling Price (Per Satuan)</h5>
                                    <input name = "Abc" type ="text" class = "form-control" id = "inputNominal" oninput ="decimal()" placeholder = "Selling Price">
                                </div>
                                <div class = "form-group" onclick = "getMargin()">
                                    <h5 style = "opacity:0.5">Margin</h5>
                                    <input name = "Abc"  type ="text" class = "form-control" id = "totalMargin" disabled placeholder = "Margin">
                                </div>
                                <div class = "form-group">
                                    <button type = "button" onclick = "quotationItem()" class = "col-lg-2 btn btn-primary btn-outline btn-sm">ADD TO QUOTATION</button>
                                </div>
                                <div class = "form-group col-lg-12">
                                    <table class = "table table-stripped col-lg-12" style = "width:100%" data-plugin = "dataTable">
                                        <thead>
                                            <th>#</th>
                                            <th>Item Request ID</th>
                                            <th style = "width:20%">Product Name</th>
                                            <th>Amount</th>
                                            <th>Selling Price</th>
                                            <th style = "width:10%">Margin</th>
                                            <th style = "width:10%">Gambar Baru</th>
                                            <th>Gambar</th>
                                        </thead>
                                        <tbody id ="t1">
                                            <?php for($quo_item = 0; $quo_item<count($quotation_item); $quo_item++):?>
                                            <tr>
                                                <td>
                                                    <div class = "checkbox-custom checkbox-primary">
                                                        <input type = "checkbox" name = "checks[]" checked id = "checks<?php echo ($quo_item+1);?>" value = "<?php echo ($quo_item+1);?>">
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type = "text" name = "id_request_item<?php echo ($quo_item+1);?>" class = "form-control" value = "<?php echo $quotation_item[$quo_item]["id_request_item"];?>" readonly>
                                                </td>
                                                <td>
                                                    <textarea name = "nama_produk_leiter<?php echo ($quo_item+1);?>" class = "form-control"><?php echo $quotation_item[$quo_item]["nama_produk_leiter"];?></textarea>
                                                </td>
                                                <td>
                                                    <input type = "text" name = "item_amount<?php echo ($quo_item+1);?>" class = "form-control" id = "jumlah_produk<?php echo ($quo_item+1);?>" value = "<?php echo $quotation_item[$quo_item]["item_amount"];?> <?php echo $quotation_item[$quo_item]["satuan_produk"];?>">
                                                </td>
                                                <td>
                                                    <input type = "text" name = "selling_price<?php echo ($quo_item+1);?>" class = "form-control" value = "<?php echo number_format($quotation_item[$quo_item]["selling_price"]);?>" oninput = "commas('selling_price<?php echo ($quo_item+1);?>')" id = "selling_price<?php echo ($quo_item+1);?>" >
                                                </td>
                                                <td>
                                                    <input type = "text" name = "margin_price<?php echo ($quo_item+1);?>" class = "form-control" value = "<?php echo $quotation_item[$quo_item]["margin_price"];?>%">
                                                </td>
                                                <td><input type = "file" name = "attachment<?php echo ($quo_item+1);?>"></td>
                                                <td>
                                                    <a href = "<?php echo base_url();?>assets/dokumen/quotation/<?php echo $quotation_item[$quo_item]["attachment"];?>" target = "_blank" class = "btn btn-primary btn-sm">DOCUMENT</a>
                                                </td>
                                                <input type = "hidden" value = "<?php echo $quotation_item[$quo_item]["id_harga_vendor"];?>" name = "id_harga_vendor<?php echo ($quo_item+1);?>">
                                                <input type = "hidden" value = "<?php echo $quotation_item[$quo_item]["id_harga_courier"];?>" name = "id_harga_courier<?php echo ($quo_item+1);?>">
                                                <input type = "hidden" value = "<?php echo $quotation_item[$quo_item]["id_harga_shipping"];?>" name = "id_harga_shipping<?php echo ($quo_item+1);?>">
                                            </tr>
                                            <?php endfor;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="payment" role="tabpanel">
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Total Quotation Amount</h5>
                                    <input type = "text" id = "totalQuotation" class = "form-control" name = "total_quotation_price" readonly onclick = "countTotal()" value = "<?php echo number_format($quotation["total_quotation_price"]);?>">
                                </div>
                                <div class = "row">
                                    <div class = "form-group col-lg-4 containerDp" style = ""> <!-- textarea klo DP % -->
                                        <h5 style = "opacity:0.5">DP (%)</h5>
                                        <input name = "persentase_pembayaran" value = "<?php echo $quotation_metode_pembayaran["persentase_pembayaran"];?>" id = "persenDp" oninput = "paymentWithDP()" type ="text" class = "form-control">
                                    </div>
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">Payment Method</h5>
                                        <select class = "form-control" number_format(id = "paymentMethod" name = "trigger_pembayaran">
                                            <option value = "1">BEFORE DELIVERY</option>
                                        </select>
                                    </div>
                                    <div class = "form-group col-lg-4 containerDp" style = ""> <!-- Nominal DP -->
                                        <h5 style = "opacity:0.5">Jumlah DP</h5>
                                        <input name = "nominal_pembayaran" value = "<?php echo number_format($quotation_metode_pembayaran["nominal_pembayaran"]);?>" id = "jumlahDp" type ="text" class = "form-control">
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "form-group col-lg-4 containerSisa" style = ""> <!-- textarea klo DP% -->
                                        <h5 style = "opacity:0.5">Pelunasan (%)</h5>
                                        <input name = "persentase_pembayaran2" value = "<?php echo $quotation_metode_pembayaran["persentase_pembayaran2"];?>" id = "persenSisa" type ="text" class = "form-control">
                                    </div>
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">Payment Method</h5>
                                        <select class = "form-control" id = "paymentMethod" name = "trigger_pembayaran2">
                                            <option value = "2" selected>AFTER DELIVERY</option>
                                            <option value = "1" <?php if($quotation_metode_pembayaran["trigger_pembayaran2"] == 1) echo "selected";?> >BEFORE DELIVERY</option>
                                        </select>
                                    </div>  
                                    <div class = "form-group col-lg-4 containerSisa" style = ""> <!-- Nominal DP -->
                                        <h5 style = "opacity:0.5">Jumlah Pelunasan</h5>
                                        <input name = "nominal_pembayaran2" value = "<?php echo number_format($quotation_metode_pembayaran["nominal_pembayaran2"]);?>" id = "jumlahSisa" type ="text" class = "form-control">
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Durasi Pembayaran (... minggu setelah invoice diterima)</h5>
                                    <input name = "durasi_pembayaran" type ="text" value = "<?php echo $quotation["durasi_pembayaran"];?>" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Mata Uang Pembayaran</h5>
                                    <input name = "mata_uang_pembayaran" type ="text" value = "<?php echo $quotation_metode_pembayaran["kurs"];?>" value ="IDR" class = "form-control">
                                </div>
                                <!-- (1) invoice keluar triggernya abis keluarin OC -->
                                <!-- (2) invoice keluar triggernya abis keluarin OD -->
                                <!-- (3) 
                                keluar textarea buat isi persen, keluar invoice setelah OC untuk dp
                                selebihnya keluar setelah bkin OD
                                -->
                                <!-- (4) 
                                keluar textarea buat isi persen, keluar invoice setelah OC untuk dp
                                selebihnya keluar setelah bkin OD
                                -->
                            </div>
                            <!-- dokumen -->
                            <div class="tab-pane" id="detail" role="tabpanel">
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">No Quotation</h5>
                                    <input value = "<?php echo $quotation["no_quotation"];?>" type ="text" class = "form-control" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Quotation Perihal</h5>
                                    <input name = "hal_quotation" type ="text" value = "<?php echo $quotation["hal_quotation"];?>" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Perusahaan Customer</h5>
                                    <input type ="text" class = "form-control perusahaanCust" value = "<?php echo $quotation["nama_perusahaan"];?>" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Nama Customer</h5>
                                    <input name = "" type ="text" value = "<?php echo $quotation["nama_cp"];?>" class = "form-control namaCust" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Alamat Customer</h5>
                                    <textarea name = "alamat_perusahaan" class = "form-control" id ="alamatCust"><?php echo $quotation["alamat_perusahaan"];?></textarea>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Up Nama Customer</h5>
                                    <input name = "up_cp" value = "<?php echo $quotation["up_cp"];?>" type ="text" class = "form-control">
                                </div>
                            </div>
                            <div class="tab-pane" id="tambahan" role="tabpanel">
                                
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Durasi Pengiriman (... Minggu setelah PO di konfirmasi)</h5>
                                    <input name = "durasi_pengiriman" value = "<?php echo $quotation["durasi_pengiriman"];?>" type ="text" class = "form-control"> Minggu
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Masa Berlaku Quotation</h5>
                                    <input name = "dateline_quotation" value = "<?php echo $quotation["dateline_quotation"];?>" type ="date" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Franco</h5>
                                    <input name = "franco" id = "franco" type ="text" value = "<?php echo $quotation["franco"];?>" class = "form-control"> 
                                </div>
                                
                                <button class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
                            </div>
                        </div>
                        <div class = "form-group">
                            <a href = "<?php echo base_url();?>crm/quotation" class = "btn btn-outline btn-primary btn-sm">BACK</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Example Tabs Left -->
        </div>
    </div>
</div>