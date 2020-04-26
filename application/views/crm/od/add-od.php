<div class="panel-body col-lg-12">
    <div class="row row-lg">
        <div class="col-xl-12">
            <!-- Example Tabs Left -->
            <div class="example-wrap">
                <div class="nav-tabs-vertical" data-plugin="tabs">
                    <ul class="nav nav-tabs mr-25" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#primaryData" aria-controls="primaryData" role="tab">Primary Data</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#items" aria-controls="pengiriman" role="tab">Items</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#dokumen" aria-controls="pengiriman" role="tab">Dokumen</a></li>

                    </ul>
                    <form action = "<?php echo base_url();?>crm/od/createod" method = "post">    
                        <div class="tab-content">
                            <div class="tab-pane active" id="primaryData" role="tabpanel">
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">No Order Delivery</h5>
                                    <input type ="text" value = "<?php echo date("y").date("m").sprintf("%03d",$maxId)?>/LI/SJ/<?php echo date("y");?>" name = "no_od" class = "form-control" readonly>
                                    <input type ="hidden" value = "<?php echo $maxId;?>" name = "id_od" class = "form-control" readonly>
                                </div>
                                <div class = "form-group"> <!-- nanti bentuknya nomorquotation/versi -->
                                    <h5 style = "color:darkgrey; opacity:0.8">Customer PO No.</h5> 
                                    <select name = "id_submit_oc" class = "form-control" onchange = "loadPoDetail()" data-plugin = "select2" id = "id_submit_oc">
                                        <option selected>Choose No PO Customer</option>
                                        <?php for($a = 0; $a<count($oc); $a++): ?>
                                        <option value = "<?php echo $oc[$a]["id_submit_oc"];?>"><?php echo $oc[$a]["no_po_customer"];?> - <?php echo $oc[$a]["nama_perusahaan"];?></option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Courier</h5>
                                    <select name = "courier" class = "form-control" data-plugin = "select2" id = "idcourier">
                                        <option selected>Choose Courier</option>
                                        <?php for($a = 0; $a<count($courier); $a++): ?>
                                        <option value = "<?php echo $courier[$a]["id_perusahaan"];?>"><?php echo $courier[$a]["nama_perusahaan"];?></option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Delivery Method</h5>
                                    <select data-plugin = "select2" name = "method" id = "method" class = "form-control namaCust">
                                        <option value = "SEA">SEA</option>
                                        <option value = "AIR">AIR</option>
                                        <option value = "LAND">LAND</option>
                                    </select>
                                </div>
                            </div>
                            <!-- fungsi -->
                            <div class="tab-pane" id="items" role="tabpanel">
                                
                                <div class = "form-group col-lg-12">
                                    <table class = "table table-stripped col-lg-12" style = "width:100%">
                                        <thead>
                                            <th>Product Name</th>
                                            <th>Order Quantity</th>
                                            <th>Sent Quantity</th>
                                            <th>Send Amount</th>
                                        </thead>
                                        <tbody id ="t1">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="dokumen" role="tabpanel">
                                
                                <div class = "form-group col-lg-12">
                                    <div class = "form-group">
                                        <h5 style = "opacity:0.5">Up CP</h5>
                                        <input type = "text" class = "form-control" id = "up_cp" name = "up_cp">
                                    </div>
                                </div>
                                <div class = "form-group col-lg-12">
                                    <div class = "form-group">
                                        <h5 style = "opacity:0.5">Alamat Pengiriman</h5>
                                        <textarea class = "form-control"id = "alamat_pengiriman" name = "alamat_pengiriman"></textarea>
                                    </div> 
                                </div>
                                <div class = "form-group col-lg-12">
                                    <div class = "form-group">
                                        <button type = "submit" class = "col-lg-2 btn btn-sm btn-outline btn-primary">SUBMIT</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href = "<?php echo base_url();?>crm/od" class = "btn btn-primary btn-sm btn-outline">BACK</a>
                    </form>
                </div>
            </div>
            <!-- End Example Tabs Left -->
        </div>
    </div>
</div>
