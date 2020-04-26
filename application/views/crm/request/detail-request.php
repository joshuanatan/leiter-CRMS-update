<div class="panel-body col-lg-12">
    <form action = "<?php echo base_url();?>crm/request/update" method = "POST" enctype="multipart/form-data">
        <input required type = "hidden" name = "id_submit_request" value = "<?php echo $id_submit_request;?>">
        <div class = "form-group">
            <h5 style = "opacity:0.5">Price Request ID</h5>
            <input required name = "no_request" type = "text" class = "form-control" value = "<?php echo $price_request["no_request"];?>" readonly>
        </div>
        <div class = "form-group">
            <h5 style = "opacity:0.5">Customer Name</h5>
            <select required id = "idperusahaan" onchange = "getContactPerson()" class = "form-control" name = "id_perusahaan" data-plugin = "select2">
                <?php for($a = 0; $a<count($perusahaan);$a++):?>
                <option value = "<?php echo $perusahaan[$a]["id_perusahaan"];?>" <?php if($perusahaan[$a]["id_perusahaan"] == $price_request["id_perusahaan"]) echo "selected"; ?> ><?php echo $perusahaan[$a]["nama_perusahaan"];?></option>
                <?php endfor;?>
            </select>
            <span class="text-help">Before:<?php echo get1Value("perusahaan","nama_perusahaan",array("id_perusahaan" => $price_request["id_perusahaan"]));?></span>
        </div>
        <div class = "form-group">
            <h5 style = "opacity:0.5">Customer PIC</h5>
            <select required class = "form-control" name = "id_cp" id = "cpperusahaan" onchange = "getDetailContactPerson()" data-plugin="select2">
                <?php for($a = 0; $a<count($cp); $a++):?>
                <option value = "<?php echo $cp[$a]["id_cp"]?>" <?php if($cp[$a]["id_cp"] == $price_request["id_cp"]) echo "selected"; ?> ><?php echo $cp[$a]["jk_cp"];?>. <?php echo $cp[$a]["nama_cp"]?></option>    
                <?php endfor;?>
            </select>
            <span class="text-help">Before:<?php echo get1Value("contact_person","nama_cp",array("id_cp" => $price_request["id_cp"]));?></span>
        </div>
        <div class = "form-group">
            <h5 style = "opacity:0.5">Email PIC</h5>
            <input type = "text" class = "form-control" value = "<?php echo $detail_cp["email_cp"];?>" id = "email_cp" readonly>
        </div>
        <div class = "form-group">
            <h5 style = "opacity:0.5">Phone Number PIC</h5>
            <input type = "text" class = "form-control" value = "<?php echo $detail_cp["nohp_cp"];?>" id = "nohp_cp" readonly>
        </div>
        <div class = "form-group">
            <h5 style = "opacity:0.5">Franco</h5>
            <input required type = "text" name = "franco" value = "<?php echo $price_request["franco"];?>" class = "form-control">
            <span class="text-help">Before:<?php echo $price_request["franco"];?></span>
        </div>
        <div class = "form-group">
            <h5 style = "opacity:0.5">Dateline</h5>
            <?php
            $date = date_create($price_request["tgl_dateline_request"]); 
            ?>
            <input required type = "date" name = "tgl_dateline_request" value = "<?php echo $price_request["tgl_dateline_request"];?>" class = "form-control">
            <span class="text-help">Before: <?php echo date_format($date,"d-m-Y");?></span>
        </div>
        <div class="form-group">
            <h5 style = "opacity:0.5">Ordered Items</h5>
            <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Notes</th>
                        <th>File</th>
                        <th>Attachment</th>
                    </tr>
                </thead>
                <tbody id = "t1">
                    <?php for($a = 0; $a<count($items); $a++):?>
                    <tr>
                        <td>
                            <div class = "checkbox-custom checkbox-primary">
                                <input type = "checkbox" name = "ordered_checks[]" value = "<?php echo $a;?>" checked>
                                <label></label>
                            </div>
                        </td>
                        <td><textarea class = "form-control" name = "ordered_nama<?php echo $a;?>"><?php echo $items[$a]["nama_produk"];?></textarea></td>
                        <td><input type = "text" class = "form-control" value = "<?php echo $items[$a]["jumlah_produk"]." ".$items[$a]["satuan_produk"];?>" name = "ordered_amount<?php echo $a;?>"></td>
                        <td><textarea class = "form-control" name = "ordered_notes<?php echo $a;?>"><?php echo $items[$a]["notes_produk"];?></textarea></td>
                        <td>
                            <input type="text" name="ordered_attachment<?php echo $a;?>" value = "<?php echo $items[$a]["file"];?>" class = "form-control" readonly style = "margin-bottom:10px">
                            <?php if($items[$a]["file"] != "-"):?>
                            <a href = "<?php echo $items[$a]["notes_produk"];?>" class = "btn btn-outline btn-primary btn-sm">See Attachment</a>
                            <?php endif;?>
                        </td>
                        <td>
                            <input type = "file" class = "form-control" name = "ordered_new_attachment<?php echo $a;?>">
                        </td>
                    </tr>
                    <?php endfor;?>
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <h5 style = "opacity:0.5">ITEMS</h5>
            <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Notes</th>
                        <th>Attachment</th>
                    </tr>
                </thead>
                <tbody id = "t1">
                    <?php for($a = 0; $a<10; $a++):?>
                    <tr class='gradeA'>
                        <td>
                            <div class = "checkbox-custom checkbox-primary">
                                <input type = "checkbox" value = "<?php echo $a;?>" name = "checks[]">
                                <label></label>
                            </div>
                        </td>
                        <td>
                            <textarea class = "form-control" name = "item<?php echo $a;?>" placeholder="Item Description"></textarea>
                        </td>
                        <td>
                            <input type='text' class='form-control' name='jumlah_produk<?php echo $a;?>' placeholder = "Amount + Unit of Measure"/>
                        </td>
                        <td> 
                            <textarea class = "form-control" name = "notes<?php echo $a;?>"></textarea>
                        </td>
                        <td> 
                            <input type="file" name="attachment<?php echo $a;?>" class = "form-control">
                        </td>
                    </tr>
                    <?php endfor;?>
                </tbody>
            </table>
        </div>
        <div class = "form-group">
            <button type = "submit" class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
            <a href = "<?php echo base_url();?>crm/request" class = "btn btn-primary btn-outline btn-sm">BACK</a>
        </div>
    </form>
</div>