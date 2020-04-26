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
                    <form action = "<?php echo base_url();?>crm/quotation/insertquotation" method = "post" enctype = "multipart/form-data">    
                        <div class="tab-content">
                            <div class="tab-pane active" id="primaryData" role="tabpanel">
                                <input 
                                    type = "hidden"  
                                    value = "<?php echo $id_submit_quotation;?>" 
                                    id = "id_submit_quotation" 
                                    required 
                                />
                                <input 
                                    type = "hidden"  
                                    value = "<?php echo $id_submit_quotation;?>" 
                                    id = "id_submit_quotation" 
                                    required 
                                />
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">RFQ</h5>
                                    <input  
                                        type = "text" 
                                        value = "<?php echo $request[0]["no_request"];?>" 
                                        class = "form-control" 
                                        required 
                                        readonly
                                    />
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Quotation No</h5> <!-- nanti ganti jadi select -->
                                    <input 
                                        type ="text" 
                                        value = "LI-<?php echo sprintf("%03d",$quotation_id);?>/QUO/<?php echo bulanRomawi(date("m"));?>/<?php echo date("Y");?>"
                                        id = "no_quotation" 
                                        class = "form-control" 
                                        name = "no_quotation" 
                                        required 
                                        readonly  
                                    />
                                    <input 
                                        type ="hidden" 
                                        value = "<?php echo $quotation_id;?>" 
                                        id = "id_quotation"
                                        name = "id_quotation"  
                                    />
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Quotation Versi</h5>
                                    <input 
                                        type ="text" 
                                        value = "1" 
                                        id = "versi_quotation" 
                                        class = "form-control"
                                        name = "versi_quotation" 
                                        readonly 
                                    />
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Perusahaan Customer</h5>
                                    <input 
                                        type ="text" 
                                        value = "<?php echo $request[0]["nama_perusahaan"];?>" 
                                        class = "form-control perusahaanCust" 
                                        readonly
                                    />
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Nama Customer</h5>
                                    <input 
                                        type ="text" 
                                        value = "<?php echo $request[0]["nama_cp"];?>" 
                                        class = "form-control namaCust" 
                                        name = "" 
                                        readonly
                                    >
                                </div>
                            </div>
                            <!-- fungsi -->
                            <div class="tab-pane" id="items" role="tabpanel">
                                <div class = "form-group col-lg-12">
                                    <table class = "table table-stripped col-lg-12" style = "width:100%">
                                        <thead>
                                            <th>#</th>
                                            <th>Vendor Price</th>
                                            <th style = "width:15%">Quotation Product Name</th>
                                            <th style = "width:15%">Modal</th>
                                            <th style = "width:15%">Selling Price</th>
                                            <th style = "width:15%">Amount (Jumlah Satuan)</th>
                                            <th style = "width:15%">Total</th>
                                            <th style = "width:15%">Margin</th>
                                            <th style = "width:5%">Gambar</th>
                                        </thead>
                                        <tbody id ="quotation_item_table">
                                            <?php for($a = 0;$a<count($items); $a++):?>
                                            <tr>
                                                <td>
                                                    <div class = "checkbox-custom checkbox-primary">
                                                        <input 
                                                            type = "checkbox" 
                                                            value = "<?php echo $items[$a]["id_request_item"];?>"
                                                            id = "checks<?php echo $a;?>" 
                                                            name = "checks[]" 
                                                        >
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type = "button" class = "btn btn-primary btn-sm" data-toggle = "modal" data-target = "#estimation<?php echo $a;?>">ESTIMATION</button>
                                                </td>
                                                <td>
                                                    <textarea 
                                                        name = "nama_produk_leiter<?php echo $items[$a]["id_request_item"];?>" 
                                                        class = "form-control"
                                                        ><?php echo $items[$a]["nama_produk_request"];?></textarea>
                                                </td>
                                                <td>
                                                    <input 
                                                        type = "text" 
                                                        id = "modal_vendor<?php echo $a;?>"
                                                        class = "form-control" 
                                                        readonly 
                                                        onclick="countTotalVendorPrice(<?php echo $a;?>)"
                                                    />
                                                </td>
                                                <td>
                                                    <input 
                                                        type = "text" 
                                                        id = "selling_price<?php echo $a;?>" 
                                                        class = "form-control" 
                                                        name = "selling_price<?php echo $items[$a]["id_request_item"];?>"
                                                         
                                                        oninput = "commas('selling_price<?php echo $a;?>')" 
                                                    />
                                                </td>
                                                <td>
                                                    <input 
                                                        type = "text" 
                                                        value = "<?php echo $items[$a]["jumlah_produk_request"];?> <?php echo $items[$a]["satuan_produk_request"];?>"
                                                        id = "item_amount<?php echo $a;?>" 
                                                        class = "form-control" 
                                                        name = "item_amount<?php echo $items[$a]["id_request_item"];?>" 
                                                    />
                                                </td>
                                                <td>
                                                    <input 
                                                        type = "text" 
                                                        id = "harga_jual<?php echo $a;?>" 
                                                        class = "form-control" 
                                                        readonly 
                                                        onclick = "totalJualBarang(<?php echo $a;?>)"
                                                    />
                                                </td>
                                                <td>
                                                    <input 
                                                        type = "text" 
                                                        id = "margin_price<?php echo $a;?>" 
                                                        class = "form-control"
                                                        name = "margin_price<?php echo $items[$a]["id_request_item"];?>" 
                                                         
                                                        readonly 
                                                        onclick = "getMarginItem(<?php echo $a;?>)" 
                                                    />
                                                </td>
                                                <td>
                                                    <button type = "button" class = "btn btn-primary btn-sm" data-target = "#uploadGambar<?php echo $a;?>" data-toggle = "modal">UPLOAD GAMBAR</button>    
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
                                    <input 
                                        type = "text" 
                                        id = "totalQuotation" 
                                        class = "form-control" 
                                        name = "total_quotation_price" 
                                        required 
                                        readonly 
                                        onclick = "getQuotationPrice()"
                                    />
                                </div>
                                <div class = "row">
                                    <div class = "form-group col-lg-4 containerDp" style = ""> <!-- textarea klo DP % -->
                                        <h5 style = "opacity:0.5">DP (%)</h5>
                                        <input 
                                            type ="text"
                                            id = "persenDp" 
                                            class = "form-control"
                                            name = "persentase_pembayaran" 
                                            required 
                                            oninput = "paymentWithDP()" 
                                        />
                                    </div>
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">Payment Method</h5>
                                        <select class = "form-control" id = "paymentMethod" name = "trigger_pembayaran">
                                            <option value = "1">BEFORE DELIVERY</option>
                                        </select>
                                    </div>
                                    <div class = "form-group col-lg-4 containerDp" style = ""> <!-- Nominal DP -->
                                        <h5 style = "opacity:0.5">Jumlah DP</h5>
                                        <input 
                                            type ="text"
                                            id = "jumlahDp" 
                                            class = "form-control"
                                            name = "nominal_pembayaran" 
                                            required 
                                        />
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "form-group col-lg-4 containerSisa" style = ""> <!-- textarea klo DP% -->
                                        <h5 style = "opacity:0.5">Pelunasan (%)</h5>
                                        <input 
                                            type ="text" 
                                            id = "persenSisa" 
                                            class = "form-control"
                                            name = "persentase_pembayaran2" 
                                            required 
                                        />
                                    </div>
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">Payment Method</h5>
                                        <select class = "form-control" id = "paymentMethod" name = "trigger_pembayaran2">
                                            <option value = "1">BEFORE DELIVERY</option>
                                            <option value = "2" selected>AFTER DELIVERY</option>
                                        </select>
                                    </div>  
                                    <div class = "form-group col-lg-4 containerSisa" style = ""> <!-- Nominal DP -->
                                        <h5 style = "opacity:0.5">Jumlah Pelunasan</h5>
                                        <input 
                                            type ="text"
                                            id = "jumlahSisa" 
                                            class = "form-control"
                                            name = "nominal_pembayaran2" 
                                            required 
                                        />
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Durasi Pembayaran (... minggu setelah invoice diterima)</h5>
                                    <input 
                                        type ="text" 
                                        class = "form-control"
                                        name = "durasi_pembayaran" 
                                        required 
                                    />
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Mata Uang Pembayaran</h5>
                                    <input 
                                        type ="text" 
                                        value ="IDR" 
                                        class = "form-control"
                                        name = "mata_uang_pembayaran" 
                                        required 
                                    />
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
                                    <input 
                                        type ="text" 
                                        value = "LI-<?php echo sprintf("%03d",$quotation_id);?>/QUO/<?php echo bulanRomawi(date("m"));?>/2019" 
                                        class = "form-control" 
                                        required 
                                        readonly
                                    />
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Quotation Perihal</h5>
                                    <input 
                                        type ="text" 
                                        class = "form-control"
                                        name = "hal_quotation" 
                                        required 
                                    />
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Perusahaan Customer</h5>
                                    <input 
                                        type ="text" 
                                        value = "<?php echo $request[0]["nama_perusahaan"];?>" 
                                        class = "form-control perusahaanCust" 
                                        required
                                        readonly
                                    />
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Nama Customer</h5>
                                    <input 
                                        type ="text" 
                                        value = "<?php echo $request[0]["nama_cp"];?>" 
                                        class = "form-control namaCust" 
                                        name = "" 
                                        readonly
                                    />
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Alamat Customer</h5>
                                    <textarea 
                                        name = "alamat_perusahaan" 
                                        class = "form-control" 
                                        id ="alamatCust"
                                        ><?php echo $request[0]["alamat_perusahaan"];?></textarea>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Up Nama Customer</h5>
                                    <input 
                                        type ="text" 
                                        class = "form-control"
                                        name = "up_cp" 
                                        required 
                                    />
                                </div>
                            </div>
                            <div class="tab-pane" id="tambahan" role="tabpanel">
                                
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Durasi Pengiriman (... Minggu setelah PO di konfirmasi)</h5>
                                    <input 
                                        type ="text" 
                                        class = "form-control"
                                        name = "durasi_pengiriman" 
                                        required 
                                    />
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Masa Berlaku Quotation</h5>
                                    <input 
                                        type ="date" 
                                        class = "form-control"
                                        name = "dateline_quotation" 
                                        required 
                                        style = "width:20%"
                                    />
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Franco</h5>
                                    <input 
                                        type ="text" 
                                        id = "franco" 
                                        class = "form-control"
                                        name = "franco" 
                                        required 
                                    /> 
                                </div>
                                
                                <button class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
                            </div>
                        </div>
                        <div class = "form-group">
                            <a href = "<?php echo base_url();?>crm/quotation" class = "btn btn-outline btn-primary btn-sm">BACK</a>
                        </div>
                        <?php for($a = 0; $a<count($items); $a++):?>
                        <div class = "modal fade" id = "uploadGambar<?php echo $a;?>">
                            <div class = "modal-dialog modal-lg">
                                <div class = "modal-content">
                                    <div class = "modal-header"></div>
                                    <div class = "modal-body">
                                        <div class = "form-group">
                                            <h5>Upload Gambar Produk Quotation</h5>
                                            <input 
                                                type = "file" 
                                                name = "attachment<?php echo $items[$a]["id_request_item"];?>"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "modal fade" id = "estimation<?php echo $a;?>">
                            <div class = "modal-dialog modal-lg">
                                <div class = "modal-content">
                                    <div class = "modal-header"></div>
                                    <div class = "modal-body">
                                        <table class = "table table-striped table-hover table-bordered">
                                            <thead>
                                                <th style = "width:10%">#</th>
                                                <th style = "width:15%">Nama Vendor</th>
                                                <th style = "width:15%">Nama Produk Vendor</th>
                                                <th style = "width:15%">Harga Satuan</th>
                                                <th style = "width:15%">Rate</th>
                                                <th style = "width:15%">Currency</th>
                                                <th style = "width:15%">Notes</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Harga Vendor</td>
                                                    <td>
                                                        <select 
                                                            data-plugin = "select2" 
                                                            class = "form-control" 
                                                            name = "vendor<?php echo $items[$a]["id_request_item"];?>"
                                                            >
                                                            <?php for($i =0; $i<count($vendor); $i++):?>
                                                            <option 
                                                                value = "<?php echo $vendor[$i]["id_perusahaan"];?>">
                                                                <?php echo $vendor[$i]["nama_perusahaan"];?>
                                                            </option>
                                                            <?php endfor;?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea
                                                            name = "nama_produk_vendor<?php echo $items[$a]["id_request_item"];?>"
                                                            class = "form-control"
                                                            ></textarea>
                                                    </td>
                                                    <td>
                                                        <input 
                                                            type = "text" 
                                                            id = "harga_produk_vendor<?php echo $a;?>" 
                                                            class = "form-control" 
                                                            name = "harga_produk_vendor<?php echo $items[$a]["id_request_item"];?>"
                                                            oninput = "commas('harga_produk_vendor<?php echo $a;?>')" 
                                                        />
                                                    </td>
                                                    <td>
                                                        <input 
                                                            type = "text" 
                                                            id = "rate_vendor<?php echo $a;?>" 
                                                            class = "form-control" 
                                                            name = "rate_vendor<?php echo $items[$a]["id_request_item"];?>"
                                                            oninput = "commas('rate_vendor<?php echo $a;?>')" 
                                                        />
                                                    </td>
                                                    <td>
                                                        <input 
                                                            type = "text" 
                                                            class = "form-control" 
                                                            name = "mata_uang_vendor<?php echo $items[$a]["id_request_item"];?>"
                                                        />
                                                    </td>
                                                    <td>
                                                        <textarea
                                                            name = "notes_vendor<?php echo $items[$a]["id_request_item"];?>"
                                                            class = "form-control"
                                                            
                                                            >-</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Harga Shipper</td>
                                                    <td>
                                                        <select 
                                                            data-plugin = "select2" 
                                                            class = "form-control" 
                                                            name = "shipper<?php echo $items[$a]["id_request_item"];?>">
                                                            <?php for($i =0; $i<count($shipper); $i++):?>
                                                            <option value = "<?php echo $shipper[$i]["id_perusahaan"];?>"><?php echo $shipper[$i]["nama_perusahaan"];?>
                                                            </option>
                                                            <?php endfor;?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                        <input 
                                                            type = "text" 
                                                            id = "harga_produk_shipper<?php echo $a;?>" 
                                                            class = "form-control" 
                                                            name = "harga_produk_shipper<?php echo $items[$a]["id_request_item"];?>"
                                                            oninput = "commas('harga_produk_shipper<?php echo $a;?>')" 
                                                        />
                                                    </td>
                                                    <td>
                                                        <input 
                                                            type = "text" 
                                                            id = "rate_shipper<?php echo $a;?>" 
                                                            class = "form-control" 
                                                            name = "rate_shipper<?php echo $items[$a]["id_request_item"];?>"
                                                            oninput = "commas('rate_shipper<?php echo $a;?>')" 
                                                        />
                                                    </td>
                                                    <td>
                                                        <input 
                                                            type = "text" 
                                                            class = "form-control" 
                                                            name = "mata_uang_shipper<?php echo $items[$a]["id_request_item"];?>"
                                                        />
                                                    </td>
                                                    <td>
                                                        <textarea
                                                            name = "notes_shipper<?php echo $items[$a]["id_request_item"];?>"
                                                            class = "form-control"
                                                            
                                                            >-</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Harga Kurir</td>
                                                    <td>
                                                        <select data-plugin = "select2" class = "form-control" name = "kurir<?php echo $items[$a]["id_request_item"];?>">
                                                            <?php for($i =0; $i<count($shipper); $i++):?>
                                                            <option value = "<?php echo $shipper[$i]["id_perusahaan"];?>"><?php echo $shipper[$i]["nama_perusahaan"];?></option>
                                                            <?php endfor;?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                        <input 
                                                            type = "text" 
                                                            id = "harga_produk_kurir<?php echo $a;?>" 
                                                            class = "form-control" 
                                                            name = "harga_produk_kurir<?php echo $items[$a]["id_request_item"];?>"    
                                                            oninput = "commas('harga_produk_kurir<?php echo $a;?>')" 
                                                        />
                                                    </td>
                                                    <td>
                                                        <input 
                                                            type = "text" 
                                                            id = "rate_kurir<?php echo $a;?>" 
                                                            class = "form-control" 
                                                            name = "rate_kurir<?php echo $items[$a]["id_request_item"];?>"
                                                            oninput = "commas('rate_kurir<?php echo $a;?>')" 
                                                        />
                                                    </td>
                                                    <td>
                                                        <input 
                                                            type = "text" 
                                                            class = "form-control" 
                                                            name = "mata_uang_kurir<?php echo $items[$a]["id_request_item"];?>"
                                                        />
                                                    </td>
                                                    <td>
                                                        <textarea
                                                            name = "notes_kurir<?php echo $items[$a]["id_request_item"];?>"
                                                            class = "form-control"
                                                            
                                                            >-</textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endfor;?>
                    </form>
                </div>
            </div>
            <!-- End Example Tabs Left -->
        </div>
    </div>
</div>
