<div class="panel-body col-lg-12">
    <div class="row row-lg">
        <div class="col-xl-12">
            <!-- Example Tabs Left -->
            <div class="example-wrap">
                <div class="nav-tabs-vertical" data-plugin="tabs">
                    <ul class="nav nav-tabs mr-25" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#primaryData" aria-controls="primaryData" role="tab">Primary Data</a></li>

                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#items" aria-controls="pengiriman" role="tab">Supplier & Items</a></li>

                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#shipper" aria-controls="produksi" role="tab">Shipper</a></li>
                        

                    </ul>
                    <form action = "<?php echo base_url();?>crm/po/updatePoStock" method = "post">    
                        <div class="tab-content">
                            <div class="tab-pane active" id="primaryData" role="tabpanel">
                                <input type = "hidden" name = "id_submit_po" value = "<?php echo $po_core[0]["id_submit_po"];?>">
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">No PO</h5>
                                    <input type = "text" value = "<?php echo $po_core[0]["no_po"] ?>" class = "form-control" id = "no_po" readonly>
                                </div>
                            </div>
                            <!-- fungsi -->
                            <div class="tab-pane" id="items" role="tabpanel">
                                <div class = "row">
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">Supplier</h5>
                                        <select class = "form-control" name = "id_supplier" id = "id_supplier" data-plugin = "select2" onchange = "getDetailSupplier()">

                                            <?php for($sup = 0; $sup<count($supplier);$sup++):?>
                                            <?php if($supplier[$sup]["peran_perusahaan"] == "PRODUK"):?>
                                            <option <?php if($supplier[$sup]["id_perusahaan"] == $po_core[0]["id_supplier"]) echo "selected"; ?> value = "<?php echo $supplier[$sup]["id_perusahaan"];?>"><?php echo $supplier[$sup]["nama_perusahaan"];?></option>
                                            <?php endif;?>
                                            <?php endfor;?>

                                        </select>
                                    </div>
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">PIC Supplier</h5>
                                        <select class = "form-control" name = "id_cp_supplier" id = "id_pic_supplier">
                                            <option value = "<?php echo $po_core[0]["id_cp_supplier"];?>"><?php echo $po_core[0]["nama_cp_supplier"];?></option>
                                        </select>
                                    </div>
                                    <div class = "form-group col-lg-2">
                                        <h5 style = "opacity:0.5">Phone</h5>
                                        <input type = "text" id = "phone_supplier" readonly class = "form-control" value = "<?php echo $po_core[0]["notelp_shipper"];?>">
                                    </div>
                                    <div class = "form-group col-lg-2">
                                        <h5 style = "opacity:0.5">Fax</h5>
                                        <input type = "text" id = "fax_supplier" readonly class = "form-control" value = "<?php echo $po_core[0]["nofax_shipper"];?>">
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Address</h5>
                                    <textarea readonly id = "alamat_supplier" class = "form-control"><?php echo $po_core[0]["alamat_supplier"];?></textarea>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Currency</h5>
                                    <input type = "text" id = "mata_uang_pembayaran" name = "mata_uang_pembayaran" class = "form-control" value = "<?php echo $po_core[0]["mata_uang_pembayaran"];?>">
                                </div>
                                <div class = "form-group">
                                    <table class = "table table-bordered table-stripped" style = "Width:100%" data-plugin = "dataTable">
                                        <thead>
                                            <th>Add</th>
                                            <th>Delete</th>
                                            <th style = "width:18%">Nama Produk Leiter</th>
                                            <th style = "width:18%">Nama Produk Vendor</th>
                                            <th style = "width:18%">Quantity</th>
                                            <th style = "width:18%">Vendor Price</th>
                                        </thead>
                                        <tbody>
                                            <?php for($a = 0; $a<10; $a++):?>
                                            <?php if($a < count($items)):?>
                                            <tr>
                                                <td>
                                                    <input type = "hidden" name = "id_po_item<?php echo $a;?>" value = "<?php echo $items[$a]["id_po_item"];?>">
                                                    <div class = "checkbox-custom checkbox-primary">
                                                        <input name = "checks[]" value = "<?php echo $a;?>" type = "checkbox" checked>
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if($items[$a]["id_po_item"] != ""):?>
                                                    <div class = "checkbox-custom checkbox-primary">
                                                        <input name = "delete[]" value = "<?php echo $items[$a]["id_po_item"];?>" type = "checkbox">
                                                        <label></label>
                                                    </div>
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                    <input type = "text" class = "form-control" oninput = "getRecommendationProduk(<?php echo $a;?>)" id = "namaproduk<?php echo $a;?>">
                                                    <hr/>
                                                    <select data-plugin = "select2" id = "similarProduk<?php echo $a;?>" class = "form-control" onchange = "getSatuanProduk(<?php echo $a;?>)" name = "id_produk_item<?php echo $a;?>">
                                                    <option value = "<?php echo $items[$a]["id_produk"];?>"><?php echo $items[$a]["deskripsi_produk"];?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <textarea rows = "4" class = "form-control" name = "nama_produk_vendor<?php echo $a;?>" ><?php if($items[$a]["nama_produk_vendor"] != "") echo $items[$a]["nama_produk_vendor"]; else echo "-";?></textarea>
                                                </td>
                                                <td>
                                                    <input type = "text" class = "form-control" name = "jumlah_produk<?php echo $a;?>" value = "<?php echo $items[$a]["jumlah_item"];?> <?php echo $items[$a]["satuan_item"];?>">
                                                </td>

                                                <td>
                                                    <input type = "text" oninput = "commas('harga_satuan_produk<?php echo $a;?>')" id = "harga_satuan_produk<?php echo $a;?>" class = "form-control" name = "harga_satuan_produk<?php echo $a;?>" value = "<?php echo number_format($items[$a]["harga_item"]);?>">
                                                </td>
                                            
                                            </tr>
                                            <?php else:?>
                                            <tr>
                                                <td>
                                                    <input type = "hidden" name = "id_po_item<?php echo $a;?>" value = "">
                                                    <div class = "checkbox-custom checkbox-primary">
                                                        <input onclick = "getDetailHargaVendor(<?php echo $a;?>)" type = "checkbox" name = "checks[]" value = "<?php echo $a;?>">
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td></td>

                                                <td>
                                                    <input type = "text" class = "form-control" oninput = "getRecommendationProduk(<?php echo $a;?>)" id = "namaproduk<?php echo $a;?>">
                                                    <hr/>
                                                    <select data-plugin = "select2" id = "similarProduk<?php echo $a;?>" class = "form-control" onchange = "getSatuanProduk(<?php echo $a;?>)" name = "id_produk_item<?php echo $a;?>">
                                                    </select>
                                                </td>
                                                <td><textarea rows = "4" id = "nama_produk_vendor<?php echo $a;?>" class = "form-control" name = "nama_produk_vendor<?php echo $a;?>" ></textarea></td>

                                                <td><input type = "text" id = "jumlah_produk<?php echo $a;?>" class = "form-control" name = "jumlah_produk<?php echo $a;?>"></td>

                                                <td><input type = "text" oninput = "commas('harga_satuan_produk<?php echo $a;?>')" id = "harga_satuan_produk<?php echo $a;?>" class = "form-control" name = "harga_satuan_produk<?php echo $a;?>"></td>
                                            
                                            </tr>
                                            <?php endif;?>
                                            <?php endfor;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="shipper" role="tabpanel">
                                
                                <div class = "row">
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">Shipper</h5>
                                        <select class = "form-control" name = "id_shipper" data-plugin = "select2" onchange = "getDetailShipper()" id = "id_shipper">
                                            <?php for($sup = 0; $sup<count($supplier);$sup++):?>
                                            <?php if($supplier[$sup]["peran_perusahaan"] == "SHIPPING"):?>
                                            <option <?php if($supplier[$sup]["id_perusahaan"] == $po_core[0]["id_shipper"]) echo "selected"; ?> value = "<?php echo $supplier[$sup]["id_perusahaan"];?>"><?php echo $supplier[$sup]["nama_perusahaan"];?></option>
                                            <?php endif;?>
                                            <?php endfor;?>
                                        </select>
                                    </div>
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">PIC Shipper</h5>
                                        <select class = "form-control" id = "id_pic_shipper" name = "id_cp_shipper">
                                            <option value = "<?php echo $po_core[0]["id_cp_shipper"];?>"><?php echo $po_core[0]["nama_cp_shipper"];?></option>
                                        </select>
                                    </div>
                                    <div class = "form-group col-lg-2">
                                        <h5 style = "opacity:0.5">Phone</h5>
                                        <input type = "text" id = "phone_shipper" readonly class = "form-control" value = "<?php echo $po_core[0]["notelp_shipper"];?>">
                                    </div>
                                    <div class = "form-group col-lg-2">
                                        <h5 style = "opacity:0.5">Fax</h5>
                                        <input type = "text" id = "fax_shipper" readonly class = "form-control" value = "<?php echo $po_core[0]["nofax_shipper"];?>">
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Address</h5>
                                    <textarea readonly id = "alamat_shipper" class = "form-control"><?php echo $po_core[0]["alamat_shipper"];?></textarea>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Shipping Method</h5>
                                    <select class = "form-control" name = "shipping_method" data-plugin = "select2">
                                        <option value = "SEA">SEA</option>
                                        <option value = "AIR" <?php if($po_core[0]["shipping_method"] == "AIR") echo "selected"; ?>>AIR</option>
                                        <option value = "LAND" <?php if($po_core[0]["shipping_method"] == "LAND") echo "selected"; ?>>LAND</option>
                                    </select>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Shipping Term</h5>
                                    <input type = "text" class = "form-control" name = "shipping_term" value = "<?php echo $po_core[0]["shipping_term"];?>">
                                </div>
                                <div class = "row">
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">Requirement Date</h5>
                                        <input type = "date" class = "form-control" name = "requirement_date" value = "<?php echo $po_core[0]["requirement_date"];?>">
                                    </div>
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">Destination</h5>
                                        <input type = "text" class = "form-control" name = "destination" value = "<?php echo $po_core[0]["destination"];?>">
                                    </div>
                                </div>
                                <button class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                </div>
                <a href = "<?php echo base_url();?>crm/po/stock" class = "btn btn-outline btn-primary btn-sm">BACK</a>
            </div>
            <!-- End Example Tabs Left -->
        </div>
    </div>
</div>
