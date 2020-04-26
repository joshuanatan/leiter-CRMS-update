
<div class="panel-body col-lg-12">
    <div class = "form-group">
        <h5 style = "opacity:0.5">Nama Customer</h5>
        <input type = "text" readonly value = "<?php echo $detail_request["nama_perusahaan"];?>" class = "form-control">
    </div>
    <div class = "form-group">
        <h5 style = "opacity:0.5">Alamat Pengiriman</h5>
        <textarea readonly class = "form-control"><?php echo $detail_request["alamat_pengiriman"];?></textarea>
    </div>
    <div class = "form-group">
        <div class = "col-lg-6" style = "margin-left:0px; padding-left:0px" style = "z-index:1">
            <h5 style = "opacity:0.5">RFQ Item</h5>
            <select class = "form-control col-lg-6" id = "items" onchange = "getDetailPriceRequestItem()" data-plugin="select2" style="z-index: 1 !important;">
                <option selected disabled>Choose Item List</option>
                <?php for($a = 0 ; $a<count($request_item); $a++): ?> 
                <option value = "<?php echo $request_item[$a]["id_request_item"];?>"><?php echo $request_item[$a]["nama_produk"];?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>
    <div>
        <div class = "form-group">
            <h5 style = "opacity:0.5">Product Name</h5>
            <textarea class = "form-control nama_produk" readonly id = ""></textarea>
        </div>
        <div class = "form-group">
            <h5 style = "opacity:0.5">Product Quantity</h5>
            <input type ="text" class = "form-control" readonly id = "jumlah_produk">
        </div>
        <div class = "form-group">
            <h5 style = "opacity:0.5">Product Request Note</h5>
            <textarea class = "form-control" readonly id = "note_produk"></textarea>
        </div>
        <div class = "form-group">
            <a href = "#" id ="file_produk" target = "_blank" class = "btn btn-primary btn-outline btn-sm">ATTACHMENT</a>
        </div>
    </div>
    <hr/>
    <button class = "btn btn-primary btn-outline btn-sm" data-toggle = "modal" data-target = "#addSupplier">ADD SUPPLIER</button>
    <button class = "btn btn-primary btn-outline btn-sm" data-toggle = "modal" data-target = "#addShipping">ADD SHIPPING</button>
    <button class = "btn btn-primary btn-outline btn-sm" data-toggle = "modal" data-target = "#viewShipping">VIEW SHIPPING</button>
    <button class = "btn btn-primary btn-outline btn-sm" data-toggle = "modal" data-target = "#addCourier">ADD COURIER</button>
    <button class = "btn btn-primary btn-outline btn-sm" data-toggle = "modal" data-target = "#viewCourier">VIEW COURIER</button>
    <br/><br/>
    <div class = "modal fade" id = "addSupplier">
        <div class = "modal-dialog modal-lg">
            <div class = "modal-content">
                <div class = "modal-header">
                    <h4 class = "modal-title">ADD SUPPLIER PRICE</h4>
                </div>
                <form action = "<?php echo base_url();?>crm/vendor/insertHargaSupplier" method = "POST" enctype = "multipart/form-data">
                    <div class = "modal-body actual-select">
                        <table class = "table table-stripped table-bordered" data-plugin = "dataTable">
                            <thead>
                                <th>#</th>
                                <th>Nama Supplier</th>
                                <th>PIC</th>
                                <th>Supplier Product Name</th>
                                <th>Harga/satuan</th>
                                <th>Rate</th>
                                <th>Currency</th>
                                <th>Notes</th>
                                <th>Attachment</th>
                            </thead>

                        </table>
                        <div class = "form-group">
                            <button class = "btn btn-primary btn-sm" data-toggle = "modal" type = "button" data-target="#supplierBaru">New Supplier</button>
                            
                            <h5 style = "opacity:0.5">Supplier Name</h5>
                            <select class = "form-control actual-select" onchange = "getCp('id_supplier','supplier_cp')" name = "id_perusahaan" id = "id_supplier" data-plugin="select2">
                                <option>Select Supplier</option>
                                <?php for($sup = 0; $sup<count($supplier);$sup++):?>
                                <option value = "<?php echo $supplier[$sup]["id_perusahaan"];?>"><?php echo $supplier[$sup]["nama_perusahaan"];?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">PIC Supplier</h5>
                            <select onchange = "getDetailCp('supplier_cp','email_pic_supplier','phone_pic_supplier')" class = "form-control actual-select" name = "id_cp" data-plugin="select2" id = "supplier_cp">
                                
                            </select>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Email PIC</h5>
                            <input type = "text" class = "form-control" readonly id = "email_pic_supplier">
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">No Handphone PIC</h5>
                            <input type = "text" class = "form-control" readonly id = "phone_pic_supplier">
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Vendor Product Name</h5>
                            <textarea class = "form-control" name = "nama_produk_vendor"></textarea>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Price (Per Satuan)</h5>
                            <input type = "text" class = "form-control" id = "price" name = "price" oninput = "commas('price')">
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Rate</h5>
                            <input type = "text" class = "form-control" id = "rate" name = "rate" oninput = "commas('rate')">
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Currency</h5>
                            <select class = "form-control" name = "currency">
                                <option value = "USD">USD</option>
                                <option value = "EUR">EUR</option>
                                <option value = "IDR">IDR</option>
                            </select>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Notes</h5>
                            <textarea class = "form-control" name = "notes"></textarea>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Attachment</h5>
                            <input type = "file" name = "attachment">
                        </div>
                        <div class = "form-group">
                            <button type = "submit" class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class = "modal fade" id = "addShipping">
        <div class = "modal-dialog modal-xl">
            <div class = "modal-content">
                <div class = "modal-header">
                    <h4 class = "modal-title">ADD SHIPPING PRICE</h4>
                </div>
                <form action = "<?php echo base_url();?>crm/vendor/insertHargaShipping" method = "POST" enctype = "multipart/form-data">
                    <div class = "modal-body">
                        <div class = "form-group">
                            <button class = "btn btn-primary btn-sm" data-toggle = "modal" type = "button" data-target="#shipperBaru">New Shipper</button>
                            <h5 style = "opacity:0.5">Supplier Name</h5>
                            <select class = "form-control actual-select listSupplier" onchange = "getCp('id_supplier_buat_shipping','supplier_cp');getAlamatPerusahaan('id_supplier_buat_shipping','alamat_supplier')" id = "id_supplier_buat_shipping" name = "id_harga_vendor" data-plugin="select2">
                                <option>Select Supplier</option>
                                <?php for($sup = 0; $sup<0;$sup++):?>
                                <option value = "<?php echo $supplier[$sup]["id_perusahaan"];?>"><?php echo $supplier[$sup]["nama_perusahaan"];?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Alamat Supplier</h5>
                            <textarea class = "form-control" id = "alamat_supplier" readonly></textarea>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Shipper Name</h5>
                            <select class = "form-control actual-select" onchange = "getCp('id_shipper','shipper_cp')" name = "id_perusahaan" id = "id_shipper" data-plugin="select2">
                                <option>Select Shipper</option>   
                                <?php for($ship = 0; $ship<count($shipper);$ship++):?>
                                
                                <option value = "<?php echo $shipper[$ship]["id_perusahaan"];?>"><?php echo $shipper[$ship]["nama_perusahaan"];?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Shipper PIC</h5>
                            <select onchange = "getDetailCp('shipper_cp','email_pic_shipper','phone_pic_shipper')" class = "form-control actual-select" name = "id_cp" data-plugin="select2" id = "shipper_cp">
                                
                            </select>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Email PIC</h5>
                            <input type = "text" class = "form-control" readonly id = "email_pic_shipper">
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">No Handphone PIC</h5>
                            <input type = "text" class = "form-control" readonly id = "phone_pic_shipper">
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Shipping Method</h5>
                            <select class = "form-control" name = "metode_pengiriman">
                                <option value = "SEA">SEA</option>
                                <option value = "AIR">AIR</option>
                                <option value = "LAND">LAND</option>
                            </select>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Price (Per Satuan)</h5>
                            <input type = "text" class = "form-control" id = "priceShipping" name = "price" oninput = "commas('priceShipping')">
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Rate</h5>
                            <input type = "text" class = "form-control" id = "rateShipping" name = "rate" oninput = "commas('rateShipping')">
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Currency</h5>
                            <select class = "form-control" name = "currency">
                                <option value = "USD">USD</option>
                                <option value = "EUR">EUR</option>
                                <option value = "IDR">IDR</option>
                            </select>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Notes</h5>
                            <textarea class = "form-control" name = "notes"></textarea>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Attachment</h5>
                            <input type = "file" name = "attachment">
                        </div>
                        <div class = "form-group">
                            <button type = "submit" class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class = "modal fade" id = "viewShipping">
        <div class = "modal-dialog modal-lg">
            <div class = "modal-content">
                <div class = "modal-header">
                    <h4 class = "modal-title">VIEW SHIPPING PRICE</h4>
                </div>
                <div class = "modal-body">
                    <div class = "form-group">
                        <select class = "form-control listSupplier" id = "idhargaSupplierShipper" onchange = "getShipperList()">

                        </select>
                    </div>
                    <table class = "table table-bordered table stripped" style = "width:100%" data-plugin = "dataTable">
                        <thead>
                            <th>Shipper</th>
                            <th>Shipper PIC</th>
                            <th>Price</th>
                            <th>Currency</th>
                            <th>Rate</th>
                            <th>Method</th>
                            <th>Notes</th>
                            <th>Attachment</th>
                            <th style = "width:15%">Actions</th>
                        </thead>
                        <tbody id = "assignedShipperList">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class = "modal fade" id = "addCourier">
        <div class = "modal-dialog modal-xl">
            <div class = "modal-content">
                <div class = "modal-header">
                    <h4 class = "modal-title">ADD COURIER PRICE</h4>
                </div>
                <form action = "<?php echo base_url();?>crm/vendor/insertHargaCourier" method = "POST" enctype = "multipart/form-data">
                    <div class = "modal-body">
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Alamat Pengiriman</h5>
                            <textarea class = "form-control" readonly><?php echo $detail_request["alamat_pengiriman"];?></textarea>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Franco</h5>
                            <input type = "text" class = "form-control" value = "<?php echo $detail_request["franco"];?>" readonly>     
                        </div>
                        <div class = "form-group">
                            <button class = "btn btn-primary btn-sm" data-toggle = "modal" type = "button" data-target="#shipperBaru">New Courier</button>
                            <h5 style = "opacity:0.5">Courier Name</h5>
                            <select class = "form-control actual-select" onchange = "getCp('id_courier','courier_cp')" name = "id_perusahaan" id = "id_courier" data-plugin="select2">
                                <option>Select Courier</option>   
                                <?php for($ship = 0; $ship<count($shipper);$ship++):?>
                                
                                <option value = "<?php echo $shipper[$ship]["id_perusahaan"];?>"><?php echo $shipper[$ship]["nama_perusahaan"];?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Courier PIC</h5>
                            <select onchange = "getDetailCp('courier_cp','email_pic_courier','phone_pic_courier')" class = "form-control actual-select" name = "id_cp" data-plugin="select2" id = "courier_cp">
                                
                            </select>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Email PIC</h5>
                            <input type = "text" class = "form-control" readonly id = "email_pic_courier">
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">No Handphone PIC</h5>
                            <input type = "text" class = "form-control" readonly id = "phone_pic_courier">
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Price (Per Satuan)</h5>
                            <input type = "text" class = "form-control" id = "priceCourier" name = "price" oninput = "commas('priceCourier')">
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Rate</h5>
                            <input type = "text" class = "form-control" id = "rateCourier" name = "rate" oninput = "commas('rateCourier')">
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Shipping Method</h5>
                            <select class = "form-control" name = "metode_pengiriman">
                                <option value = "SEA">SEA</option>
                                <option value = "AIR">AIR</option>
                                <option value = "LAND">LAND</option>
                            </select>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Currency</h5>
                            <select class = "form-control" name = "currency">
                                <option value = "USD">USD</option>
                                <option value = "EUR">EUR</option>
                                <option value = "IDR">IDR</option>
                            </select>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Notes</h5>
                            <textarea class = "form-control" name = "notes"></textarea>
                        </div>
                        <div class = "form-group">
                            <h5 style = "opacity:0.5">Attachment</h5>
                            <input type = "file" name = "attachment">
                        </div>
                        <div class = "form-group">
                            <button type = "submit" class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class = "modal fade" style = "height:800px" id = "viewCourier">
        <div class = "modal-dialog modal-lg">
            <div class = "modal-content">
                <div class = "modal-header">
                    <h4 class = "modal-title">VIEW COURIER PRICE</h4>
                </div>
                <div class = "modal-body">
                    <table class = "table table-bordered table stripped" style = "width:100%" data-plugin = "dataTable">
                        <thead>
                            <th>Courier</th>
                            <th>Courier PIC</th>
                            <th>Price</th>
                            <th>Currency</th>
                            <th>Rate</th>
                            <th>Method</th>
                            <th>Notes</th>
                            <th>Attachment</th>
                            <th style = "width:15%">Actions</th>
                        </thead>
                        <tbody id = "assignedCourierList">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <table data-plugin = "dataTable" class="table table-bordered table-hover table-striped w-full" cellspacing="0">
        <thead>
            <tr>
                <th style = "width:15%">Supplier Name</th>
                <th style = "width:10%">Supplier PIC</th>
                <th style = "width:10%">Price</th>
                <th style = "width:10%">Rate</th>
                <th style = "width:10%">Currency</th>
                <th style = "width:15%">Notes</th>
                <th style = "width:15%">Attachment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id = "t1">
            
        </tbody>
    </table>
    <a href = "<?php echo base_url();?>crm/vendor" class = "btn btn-primary btn-outline">BACK</a>
</div>
<div class = "modal fade" id = "supplierBaru" style = "z-index:1000000">
    <form action = "<?php echo base_url();?>crm/vendor/insertNewSupplier" method = "POST">
        <div class = "modal-dialog">
            <div class = "modal-content">
                <div class = "modal-header">
                    <h4 class = modal-title>NEW SUPPLIER</h4>                                     
                </div>
                <div class = "modal-body">
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Supplier Firm</h5>
                        <input type = "text" class = "form-control" name = "add_nama_supplier">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Supplier PIC</h5>
                        <input type = "text" class = "form-control" name = "add_pic">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Gender PIC</h5>
                        <select class = "form-control" name = "add_jk_pic">
                            <option value = "Mr">MR</option>
                            <option value = "Ms">MS</option>
                        </select>
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Email PIC</h5>
                        <input type = "text" class = "form-control" name = "add_email_pic">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Phone Number PIC</h5>
                        <input type = "text" class = "form-control" name = "add_phone_pic">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Company Address</h5>
                        <input type = "text" class = "form-control" name = "add_address_pic">
                    </div>
                    <div class = "form-group">
                        <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class = "modal fade" id = "shipperBaru" style = "z-index:1000000">
    <form action = "<?php echo base_url();?>crm/vendor/insertNewShipper" method = "POST">
        <div class = "modal-dialog">
            <div class = "modal-content">
                <div class = "modal-header">
                    <h4 class = modal-title>NEW SUPPLIER</h4>                                     
                </div>
                <div class = "modal-body">
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Supplier Firm</h5>
                        <input type = "text" class = "form-control" name = "add_nama_supplier">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Supplier PIC</h5>
                        <input type = "text" class = "form-control" name = "add_pic">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Gender PIC</h5>
                        <select class = "form-control" name = "add_jk_pic">
                            <option value = "Mr">MR</option>
                            <option value = "Ms">MS</option>
                        </select>
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Email PIC</h5>
                        <input type = "text" class = "form-control" name = "add_email_pic">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Phone Number PIC</h5>
                        <input type = "text" class = "form-control" name = "add_phone_pic">
                    </div>
                    <div class = "form-group">
                        <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>