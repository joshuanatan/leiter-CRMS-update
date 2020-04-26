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

                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#detail" aria-controls="detail" role="tab">Detail</a></li>
                    </ul>
                    <form action = "<?php echo base_url();?>crm/oc/dataentry" method = "post">    
                        <div class="tab-content">
                            <div class="tab-pane active" id="primaryData" role="tabpanel">
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">No OC</h5>
                                    <input required type ="text" name = "no_oc" class = "form-control" placeholder = "LI20190001">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">No PO Customer</h5>
                                    <input required name = "no_po_customer" type ="text" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Tanggal PO Customer</h5>
                                    <input required name = "tgl_po_customer" type ="date" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Perusahaan Customer</h5>
                                    <span id = "customerNotFound" style = "color:red; display:none">CUSTOMER NOT FOUND</span>
                                    <input required type = "text" class = "form-control" oninput = "getRecommendationPerusahaan()" id = "namaperusahaan" placeholder="Ketik Perusahaan"> 
                                    <select class = "form-control" name = "id_perusahaan" id = "recommendationPerusahaan"></select>
                                        
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Franco</h5>
                                    <input required name = "franco" id = "franco" type ="text" class = "form-control"> 
                                </div>
                            </div>
                            <!-- fungsi -->
                            <div class="tab-pane" id="items" role="tabpanel">
                                
                                <div class = "form-group col-lg-12">
                                    <table class = "table table-stripped col-lg-12" style = "width:100%" data-plugin = "dataTable">
                                        <thead>
                                            <th>Product ID</th>
                                            <th>Product Name</th>
                                            <th>Amount</th>
                                            <th>Final Price (Per item)</th>
                                        </thead>
                                        <tbody id ="t1">
                                            <?php for($a = 0; $a<20; $a++):?>
                                            <tr>
                                                <td>
                                                    <span id = "produkNotFound<?php echo $a;?>" style = "color:red; display:none">PRODUCT NOT FOUND</span>
                                                    <input placeholder = "search item here..." type = "text" class = "form-control" id = "namaproduk<?php echo $a;?>" oninput = "getRecommendationProduk('<?php echo $a;?>')">
                                                    <select data-plugin = "select2" class = "form-control" id = "similarProduk<?php echo $a;?>" name = "id_produk[]">
                                                        <option value = "0"></option>
                                                    </select>
                                                </td>
                                                <td><textarea name = "nama_oc_item[]" class = "form-control"></textarea></td>
                                                <td><input type = "text" id = "jumlah_produk<?php echo $a;?>" name = "final_amount[]" class = "form-control"></td>
                                                <td><input type = "text" id = "selling_price<?php echo $a;?>" oninput = "commas('selling_price<?php echo $a;?>')" name ="final_selling_price[]" class = "form-control"></td>
                                            </tr>
                                            <?php endfor;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="payment" role="tabpanel">
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Total oc Amount</h5>
                                    <input required type = "text" id = "totalQuotation" class = "form-control" name = "total_oc_price" onclick = "countTotalDataEntry()">
                                </div>
                                <div class = "row">
                                    <div class = "form-group col-lg-4 containerDp" style = ""> <!-- textarea klo DP % -->
                                        <h5 style = "opacity:0.5">DP (%)</h5>
                                        <input required name = "persentase_pembayaran" id = "persenDp" oninput = "paymentWithDP()" type ="text" class = "form-control">
                                    </div>
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">Payment Method</h5>
                                        <select class = "form-control" id = "paymentMethod" name = "trigger_pembayaran">
                                            <option value = "1">BEFORE DELIVERY</option>
                                        </select>
                                    </div>
                                    <div class = "form-group col-lg-4 containerDp" style = ""> <!-- Nominal DP -->
                                        <h5 style = "opacity:0.5">Jumlah DP</h5>
                                        <input name = "nominal_pembayaran" id = "jumlahDp" type ="text" class = "form-control">
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "form-group col-lg-4 containerSisa" style = ""> <!-- textarea klo DP% -->
                                        <h5 style = "opacity:0.5">Pelunasan (%)</h5>
                                        <input name = "persentase_pembayaran2" id = "persenSisa" type ="text" class = "form-control">
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
                                        <input name = "nominal_pembayaran2" id = "jumlahSisa" type ="text" class = "form-control">
                                    </div>
                                </div>
                                <!-- end ngeloadnya pembayaran -->
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Mata Uang Pembayaran</h5>
                                    <input required placeholder = "contoh: IDR" name = "mata_uang_pembayaran" id = "kurs" type ="text" class = "form-control">
                                </div>
                            </div>
                            <div class="tab-pane" id="detail" role="tabpanel">
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">UP CP </h5>
                                    <input required type ="text" name = "up_cp" class = "form-control" placeholder = "contoh: Bapak Johny">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Durasi Pembayaran (... Minggu)</h5>
                                    <input required type ="number" name = "durasi_pembayaran" placeholder = "contoh: 12" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Durasi Pengiriman (... Minggu)</h5>
                                    <input required type ="number" name = "durasi_pengiriman" placeholder = "contoh: 16" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Metode Pengiriman</h5>
                                    <input required type ="text" name = "metode_pengiriman" class = "form-control">
                                </div>
                                <button class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                </div>
                <a href = "<?php echo base_url();?>crm/oc" class = "btn btn-sm btn-primary">BACK</a>
            </div>
            <!-- End Example Tabs Left -->
        </div>
    </div>
</div>
