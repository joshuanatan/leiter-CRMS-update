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
                    <form action = "<?php echo base_url();?>crm/po/insertPo" method = "post">    
                        <div class="tab-content">
                            <div class="tab-pane active" id="primaryData" role="tabpanel">
                               <div class = "form-group">
                                    <h5 style = "opacity:0.5">No PO Customer</h5>
                                    <select class = "form-control" name = "id_submit_oc" onchange = "getNoPo();getOcItem();getDetailPerusahaanCustomer()" id = "po_info" data-plugin = "select2">
                                        <option>No PO Customer</option>
                                        <?php for($a = 0; $a<count($list_oc); $a++):?>
                                        <option value = "<?php echo $list_oc[$a]["id_submit_oc"];?>-<?php echo $list_oc[$a]["id_perusahaan"];?>-<?php echo $maxId;?>"><?php echo $list_oc[$a]["no_po_customer"];?> - <?php echo $list_oc[$a]["nama_perusahaan"];?></option>
                                        <?php endfor;?>
                                    </select>
                                    <input type = "hidden" name = "id_po" value = "<?php echo $maxId;?>">

                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">No PO</h5>
                                    <input type = "text" class = "form-control" id = "no_po" name = "no_po" readonly>
                                </div>
                            </div>
                            <!-- fungsi -->
                            <div class="tab-pane" id="items" role="tabpanel">
                                <div class = "row">
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">Supplier</h5>
                                        <select class = "form-control" name = "id_supplier" id = "id_supplier" data-plugin = "select2" onchange = "getDetailSupplier()">
                                        <option>Choose Supplier</option>
                                            <?php for($sup = 0; $sup<count($supplier);$sup++):?>
                                            <option value = "<?php echo $supplier[$sup]["id_perusahaan"];?>"><?php echo $supplier[$sup]["nama_perusahaan"];?></option>
                                            <?php endfor;?>
                                        </select>
                                    </div>
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">PIC Supplier</h5>
                                        <select class = "form-control" name = "id_cp_supplier" id = "id_pic_supplier">
                                        
                                        </select>
                                    </div>
                                    <div class = "form-group col-lg-2">
                                        <h5 style = "opacity:0.5">Phone</h5>
                                        <input type = "text" id = "phone_supplier" readonly class = "form-control">
                                    </div>
                                    <div class = "form-group col-lg-2">
                                        <h5 style = "opacity:0.5">Fax</h5>
                                        <input type = "text" id = "fax_supplier" readonly class = "form-control">
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Address</h5>
                                    <textarea readonly class = "form-control" id = "alamat_supplier"></textarea>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Currency</h5>
                                    <input type = "text" id = "mata_uang_pembayaran" name = "mata_uang_pembayaran" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <table class = "table table-bordered table-stripped" style = "Width:100%" data-plugin = "dataTable">
                                        <thead>
                                            <th>#</th>
                                            <th style = "width:18%">Nama Produk Leiter</th>
                                            <th style = "width:18%">Nama Produk Vendor</th>
                                            <th style = "width:18%">Quantity</th>
                                            <th style = "width:18%">Selling Price</th>
                                            <th style = "width:18%">Vendor Price</th>
                                        </thead>
                                        <tbody>
                                            <?php for($a = 0; $a<15; $a++):?>
                                            <tr>
                                                <td>
                                                    <div class = "checkbox-custom checkbox-primary">
                                                        <input onclick = "getDetailHargaVendor(<?php echo $a;?>)" type = "checkbox" name = "checks[]" value = "<?php echo $a;?>">
                                                        <label></label>
                                                    </div>
                                                </td>

                                                <td>
                                                    <textarea readonly rows = "4" id = "nama_produk_leiter<?php echo $a;?>" class = "form-control"></textarea>
                                                    <input type = "hidden" name = "id_oc_item<?php echo $a;?>" value = "" id = "id_oc_item<?php echo $a;?>">
                                                </td>
                                                <td><textarea rows = "4" id = "nama_produk_vendor<?php echo $a;?>" class = "form-control" name = "nama_produk_vendor<?php echo $a;?>" ></textarea></td>

                                                <td><input type = "text" id = "jumlah_produk<?php echo $a;?>" class = "form-control" name = "jumlah_produk<?php echo $a;?>"></td>

                                                <td><input type = "text" readonly id = "harga_jual_satuan_produk<?php echo $a;?>" class = "form-control" name = ""></td>


                                                <td><input type = "text" oninput = "commas('harga_satuan_produk<?php echo $a;?>')" id = "harga_satuan_produk<?php echo $a;?>" class = "form-control" name = "harga_satuan_produk<?php echo $a;?>"></td>
                                            </tr>
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
                                        <option>Choose Shipper</option>
                                            <?php for($sup = 0; $sup<count($shipper);$sup++):?>
                                            <option value = "<?php echo $shipper[$sup]["id_perusahaan"];?>"><?php echo $shipper[$sup]["nama_perusahaan"];?></option>
                                            <?php endfor;?>
                                        </select>
                                    </div>
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">PIC Shipper</h5>
                                        <select class = "form-control" name = "id_cp_shipper" id = "id_pic_shipper"></select>
                                    </div>
                                    <div class = "form-group col-lg-2">
                                        <h5 style = "opacity:0.5">Phone</h5>
                                        <input type = "text" id = "phone_shipper" readonly class = "form-control">
                                    </div>
                                    <div class = "form-group col-lg-2">
                                        <h5 style = "opacity:0.5">Fax</h5>
                                        <input type = "text" id = "fax_shipper" readonly class = "form-control">
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Address</h5>
                                    <textarea readonly id = "alamat_shipper" class = "form-control"></textarea>
                                </div>  
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Shipping Method</h5>
                                    <select class = "form-control" name = "shipping_method" data-plugin = "select2">
                                        <option value = "SEA">SEA</option>
                                        <option value = "AIR">AIR</option>
                                        <option value = "LAND">LAND</option>
                                    </select>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Shipping Term</h5>
                                    <input type = "text" class = "form-control" name = "shipping_term">
                                </div>
                                <div class = "row">
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">Requirement Date</h5>
                                        <input type = "date" class = "form-control" name = "requirement_date">
                                    </div>
                                    <div class = "form-group col-lg-4">
                                        <h5 style = "opacity:0.5">Destination</h5>
                                        <input type = "text" class = "form-control" name = "destination">
                                    </div>
                                </div>
                                <button class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
                            </div>
                            <br/>
                            <div class = "form-group">
                            </div>
                        </div>
                    </form>
                </div>
                
                <a href = "<?php echo base_url();?>crm/po" class = "btn btn-outline btn-sm btn-primary">BACK</a>
            </div>
            <!-- End Example Tabs Left -->
        </div>
    </div>
</div>
