<script>
function getDetailPriceRequestItem(){
    $(document).ready(function(){
        var id_request_item = $("#items").val();
        $.ajax({
            url:"<?php echo base_url();?>interface/price_request_item/getDetailRequestItem/"+id_request_item,
            dataType:"JSON",
            success:function(respond){
                $(".nama_produk").val(respond["nama_produk"]);
                $("#jumlah_produk").val(respond["jumlah_produk"]+" "+respond["satuan_produk"]);
                $("#note_produk").val(respond["notes_produk"]);
                $("#file_produk").attr("href","<?php echo base_url();?>assets/rfq/"+respond["file"]);
            }
        });
        $.ajax({
            url: "<?php echo base_url();?>interface/harga_vendor/getEachSupplierPrice/"+id_request_item,
            dataType: "JSON",
            success:function(respond){
                var html = "";
                shipperSupplierOption = "<option>Choose Supplier</option>";
                for(var a =0; a<respond.length; a++){
                    
                    var modal = "<div class = 'modal fade' id = 'detailSupplier"+a+"'><div class = 'modal-dialog'><div class = 'modal-content'><div class = 'modal-header'><h4 class = 'modal-title'>EDIT SUPPLIER PRICE</h4></div><div class = 'modal-body'><form action = '<?php echo base_url();?>crm/vendor/editHargaSupplier' method = 'POST' enctype = 'multipart/form-data'><input type = 'hidden' value = '"+respond[a]["id_harga_vendor"]+"' name = 'id_harga_vendor'><div class = 'form-group'><h5 style = 'opacity:0.5'>Supplier Firm</h5><input type = 'text' value = '"+respond[a]["nama_perusahaan"]+"' readonly class = 'form-control'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Supplier PIC</h5><input type = 'text' value = '"+respond[a]["nama_cp"]+"' readonly class = 'form-control'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Price</h5><input type = 'text' value = '"+addCommas(respond[a]["harga_produk"])+"' class = 'form-control' id = 'price_edit_supplier"+a+"' name = 'harga_produk' oninput = 'commas(\"price_edit_supplier"+a+"\")'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Product Vendor Name</h5><textarea class = 'form-control' name = 'nama_produk_vendor'>"+respond[a]["nama_produk_vendor"]+"</textarea></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Rate</h5><input type = 'text' value = '"+addCommas(respond[a]["vendor_price_rate"])+"' class = 'form-control' id = 'rate_edit_supplier"+a+"' name = 'vendor_price_rate' oninput = 'commas(\"rate_edit_supplier"+a+"\")'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Currency</h5><input type = 'text' value = '"+respond[a]["mata_uang"]+"' class = 'form-control' name = 'mata_uang'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Notes</h5><textarea class = 'form-control' name = 'notes'>"+respond[a]["notes"]+"</textarea></div><div class = 'form-group'><a target = '_blank' href = '<?php echo base_url();?>assets/dokumen/hargasupplier/"+respond[a]["attachment"]+"' class = 'btn btn-outline btn-sm'>DOKUMEN</a><h5 style = 'opacity:0.5'>Attachment</h5><input type = 'file' name = 'attachment'></div><div class = 'form-group'><button type = 'submit' class = 'btn btn-sm btn-primary'>SUBMIT</button></div></form></div></div></div>div>";

                    html += "<tr><td>"+respond[a]["nama_perusahaan"]+"</td><td>"+respond[a]["nama_cp"]+"</td><td>"+addCommas(respond[a]["harga_produk"])+"</td><td>"+addCommas(respond[a]["vendor_price_rate"])+"</td><td>"+respond[a]["mata_uang"]+"</td><td>"+respond[a]["notes"]+"</td><td><a target = '_blank' href = '<?php echo base_url();?>assets/dokumen/hargasupplier/"+respond[a]["attachment"]+"' class = 'btn btn-outline btn-primary btn-sm'>DOCUMENT</a></td><td><button type = 'button' class = 'btn btn-primary btn-sm' data-target = '#detailSupplier"+a+"' data-toggle = 'modal'>EDIT</button><a href = '<?php echo base_url();?>crm/vendor/deleteHargaVendor/"+respond[a]["id_harga_vendor"]+"' class = 'btn btn-danger btn-sm'>REMOVE</a>"+modal+"</td></tr>";


                    shipperSupplierOption += "<option value = '"+respond[a]["id_harga_vendor"]+"'>"+respond[a]["nama_perusahaan"]+"</option>";

                }
                $(".listSupplier").html(shipperSupplierOption);
                $("#t1").html(html);
            }
        });
        $.ajax({
            url: "<?php echo base_url();?>interface/harga_vendor/getEachCourierPrice/"+id_request_item,
            dataType: "JSON",
            success:function(respond){
                html = "";
                for(var a =0; a<respond.length; a++){
                    var modal ="<div class = 'modal fade' id = 'detailCourier"+a+"'><div class = 'modal-dialog'><div class = 'modal-content'><div class = 'modal-header'><h4 class = 'modal-title'>EDIT COURIER PRICE</h4></div><form action = '<?php echo base_url();?>crm/vendor/editHargaCourier' method = 'POST' enctype = 'multipart/form-data'><div class = 'modal-body'><input type = 'hidden' value = '"+respond[a]["id_harga_courier"]+"' name = 'id_harga_courier'><div class = 'form-group'><h5 style = 'opacity:0.5'>Courier Name</h5><input type = 'text' class = 'form-control' readonly value = '"+respond[a]["nama_perusahaan"]+"'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Courier PIC</h5><input type = 'text' class = 'form-control' readonly value = '"+respond[a]["nama_cp"]+"'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Price</h5><input type = 'text' class = 'form-control' id = 'price_edit_courier"+a+"' name = 'harga_produk' value = '"+addCommas(respond[a]["harga_produk"])+"' oninput = 'commas(\"price_edit_courier"+a+"\")'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Rate</h5><input type = 'text' class = 'form-control' id = 'rate_edit_courier"+a+"' name = 'vendor_price_rate' value = '"+addCommas(respond[a]["vendor_price_rate"])+"' oninput = 'commas(\"rate_edit_courier"+a+"\")'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Shipping Method</h5><input type = 'text' class = 'form-control' name = 'metode_pengiriman' value = '"+respond[a]["metode_pengiriman"]+"'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Currency</h5><input type = 'text' class = 'form-control' name = 'mata_uang' value = '"+respond[a]["mata_uang"]+"'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Notes</h5><textarea class = 'form-control' name = 'notes'>"+respond[a]["notes"]+"</textarea></div><div class = 'form-group'><a href = '<?php echo base_url();?>assets/dokumen/hargasupplier/"+respond[a]["attachment"]+"' target = '_blank' class = 'btn btn-primary btn-sm'>DOCUMENT</a><h5 style = 'opacity:0.5'>Attachment</h5><input type = 'file' name = 'attachment'></div><div class = 'form-group'><button type = 'submit' class = 'btn btn-primary btn-outline btn-sm'>SUBMIT</button></div></div></form></div></div></div>";

                    html += "<tr><td>"+respond[a]["nama_perusahaan"]+"</td><td>"+respond[a]["nama_cp"]+"</td><td>"+addCommas(respond[a]["harga_produk"])+"</td><td>"+addCommas(respond[a]["vendor_price_rate"])+"</td><td>"+respond[a]["mata_uang"]+"</td><td>"+respond[a]["metode_pengiriman"]+"</td><td>"+respond[a]["notes"]+"</td><td><a target = '_blank' href = '<?php echo base_url();?>assets/dokumen/hargasupplier/"+respond[a]["attachment"]+"' class = 'btn btn-outline btn-primary btn-sm'>DOCUMENT</a></td><td><button class = 'btn btn-primary btn-sm' type = 'button' data-target = '#detailCourier"+a+"' data-toggle = 'modal' >EDIT</button><a href = '<?php echo base_url();?>crm/vendor/deleteHargaCourier/"+respond[a]["id_harga_courier"]+"' class = 'btn btn-danger btn-sm'>REMOVE</a>"+modal+"</td></tr>";
                }
                $("#assignedCourierList").html(html);
            }
        });
    });
}
</script>
<script>
function getShipperList(){
    var id_harga_vendor = $("#idhargaSupplierShipper").val();
    $.ajax({
        url:"<?php echo base_url();?>interface/harga_vendor/getEachShippingPrice/"+id_harga_vendor,
        dataType:"JSON",
        success: function(respond){
            var html = "";
            for(var a = 0; a<respond.length;a++){
                var modal ="<div class = 'modal fade' id = 'detailShipper"+a+"'><div class = 'modal-dialog'><div class = 'modal-content'><div class = 'modal-header'><h4 class = 'modal-title'>EDIT SHIPPER PRICE</h4></div><form action = '<?php echo base_url();?>crm/vendor/editHargaShipper' method = 'POST' enctype = 'multipart/form-data'><div class = 'modal-body'><input type = 'hidden' value = '"+respond[a]["id_harga_shipping"]+"' name = 'id_harga_shipping'><div class = 'form-group'><h5 style = 'opacity:0.5'>Shipper Name</h5><input type = 'text' class = 'form-control' readonly value = '"+respond[a]["nama_perusahaan"]+"'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Shipper PIC</h5><input type = 'text' class = 'form-control' readonly value = '"+respond[a]["nama_cp"]+"'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Price</h5><input type = 'text' class = 'form-control' id = 'price_edit_shipper"+a+"' name = 'harga_produk' value = '"+addCommas(respond[a]["harga_produk"])+"' oninput = 'commas(\"price_edit_shipper"+a+"\")'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Rate</h5><input type = 'text' class = 'form-control' id = 'rate_edit_courier"+a+"' name = 'vendor_price_rate' value = '"+addCommas(respond[a]["vendor_price_rate"])+"' oninput = 'commas(\"rate_edit_courier"+a+"\")'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Shipping Method</h5><input type = 'text' class = 'form-control' name = 'metode_pengiriman' value = '"+respond[a]["metode_pengiriman"]+"'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Currency</h5><input type = 'text' class = 'form-control' name = 'mata_uang' value = '"+respond[a]["mata_uang"]+"'></div><div class = 'form-group'><h5 style = 'opacity:0.5'>Notes</h5><textarea class = 'form-control' name = 'notes'>"+respond[a]["notes"]+"</textarea></div><div class = 'form-group'><a href = '<?php echo base_url();?>assets/dokumen/hargasupplier/"+respond[a]["attachment"]+"' target = '_blank' class = 'btn btn-primary btn-sm'>DOCUMENT</a><h5 style = 'opacity:0.5'>Attachment</h5><input type = 'file' name = 'attachment'></div><div class = 'form-group'><button type = 'submit' class = 'btn btn-primary btn-outline btn-sm'>SUBMIT</button></div></div></form></div></div></div>";

                html += "<tr><td>"+respond[a]["nama_perusahaan"]+"</td><td>"+respond[a]["nama_cp"]+"</td><td>"+addCommas(respond[a]["harga_produk"])+"</td><td>"+addCommas(respond[a]["vendor_price_rate"])+"</td><td>"+respond[a]["mata_uang"]+"</td><td>"+respond[a]["metode_pengiriman"]+"</td><td>"+respond[a]["notes"]+"</td><td><a href = '<?php echo base_url();?>assets/dokumen/hargasupplier/"+respond[a]["attachment"]+"' target = '_blank' class = 'btn btn-sm btn-primary btn-outline'>DOCUMENT</a></td><td><button class = 'btn btn-primary btn-sm' type = 'button' data-toggle = 'modal' data-target = '#detailShipper"+a+"'>EDIT</button><a href = '<?php echo base_url();?>crm/vendor/deleteHargaShipping/"+respond[a]["id_harga_shipping"]+"' class = 'btn btn-sm btn-danger'>REMOVE</a>"+modal+"</td></tr>";
            }
            $("#assignedShipperList").html(html);
        }
    })
}
</script>
<script>
function getCp(get_data_from, put_data_from){
    var id_supplier = $("#"+get_data_from).val();
    $.ajax({
        url:"<?php echo base_url();?>interface/contact_person/getContactPerson/"+id_supplier,
        dataType:"JSON",
        success:function(respond){
            var html = "<option>Choose CP</option>";
            for(var a = 0; a<respond.length; a++){
                html +="<option value = '"+respond[a]["id_cp"]+"'>"+respond[a]["jk_cp"]+". "+respond[a]["nama_cp"]+"</option>";
            }
            $("#"+put_data_from).html(html);
        }
    })
}
</script>
<script>
function getAlamatPerusahaan(id_perusahaan, alamat_perusahaan){
    var id_harga_vendor = $("#"+id_perusahaan).val(); /*value seletnya itu id_harga_vendor*/
    $.ajax({
        url:"<?php echo base_url();?>interface/perusahaan/getAlamatPerusahaan/"+id_harga_vendor,
        data: {tipe_variable:"id_harga_vendor"},
        type: "POST",
        dataType:"JSON",
        success:function(respond){
            console.log("alamat_supplier");
            $("#"+alamat_perusahaan).val(respond);
        }
    })
}
</script>
<script>
function getDetailCp(get_data_from,email_pic,nohp_pic){
    var id_cp = $("#"+get_data_from).val();
    $.ajax({
        url:"<?php echo base_url();?>interface/contact_person/getDetailContactPerson/"+id_cp,
        dataType:"JSON",
        success:function(respond){
            $("#"+email_pic).val(respond["email_cp"]);
            $("#"+nohp_pic).val(respond["nohp_cp"]);
        }
    })
}
</script>
<script>
function loadItemData(){
    loadVendorPrice();
    var id_request_item = $("#items").val();
    $.ajax({
        data:{id_request_item:id_request_item},
        dataType: "JSON",
        type: "POST",
        url: "<?php echo base_url();?>crm/vendor/getitemdimension",
        success:function(respond){
            $("#dimension").val(respond);
        }
    });
}
</script>
<script>
function countKurs(a){
    var price = $("#biaya"+a).val();
    var kurs = $("#kurs"+a).val();
    $("#total"+a).val(addCommas(splitter(price,",")*splitter(kurs,",")));
}
</script>
<script>
function submitData(counterId){
    var id_perusahaan = "";
    var id_cp = "";
    $(document).ready(function(){
        var id_supplier = $("#supplier"+counterId).val();
        if(id_supplier == 0){ /*option value 0, new supplier*/
            /*insert supplier here*/
            alert($("#supplier_add_name"+counterId).val());
            var data = {
                nama_perusahaan: $("#supplier_add_name"+counterId).val(),
                peran_perusahaan: "PRODUK",
                permanent:"1"
            };
            $.ajax({
                url:"<?php echo base_url();?>interface/perusahaan/insertSupplier",
                data: {supplier_data:data},
                dataType:"JSON",
                type:"POST",
                success:function(respond){
                    id_perusahaan = respond;
                }
            });

            var data = {
                nama_cp: $("#supplier_add_pic"+counterId).val(),
                jk_cp: $("#supplier_add_jk"+counterId).val(),
                email_cp:$("#supplier_add_email"+counterId).val(),
                nohp_cp:$("#supplier_add_phone"+counterId).val(),
            };
            $.ajax({
                url:"<?php echo base_url();?>interface/contact_person/insertContactPerson",
                data: {cp_data:data},
                dataType:"JSON",
                type:"POST",
                success:function(respond){
                    id_cp = respond
                }

            });
            /*load id_supplier & id_cp*/
        }
        else{
            id_perusahaan = id_supplier;
            id_cp = $("#pic"+counterId).val();
            /*load id_supplier & id_cp*/
        }
        /*
        Ambil price, rate, mata uang, notes
        */
        var data = {
            nama_cp: $("#supplier_add_pic"+counterId).val(),
            jk_cp: $("#supplier_add_jk"+counterId).val(),
            email_cp:$("#supplier_add_email"+counterId).val(),
            nohp_cp:$("#supplier_add_phone"+counterId).val(),
        };
        var datas = {
            id_request_item: $("#items").val(),
            id_perusahaan:id_perusahaan,
            id_cp:id_cp,
            harga_produk: splitter($("#price"+counterId).val(),","),
            satuan_harga_produk: 1,
            vendor_price_rate:splitter($("#rate"+counterId).val(),","),
            mata_uang:$("#kurs"+counterId).val(),
            notes:$("#notes"+counterId).val()
        };
        $.ajax({
            url:"<?php echo base_url()?>interface/harga_vendor/insertVendorPrice/",
            data:{harga_vendor_data:datas},
            type: "POST",
            success:function(respond){

                alert("Data Recorded Successfully");
            }
        });
        
    });
}
</script>
<script>
function loadShippingMethod(){
    var id_perusahaan = $("#shipper").val();
    $(document).ready(function(){
        $.ajax({
            url:"<?php echo base_url();?>crm/vendor/getshippingmethod",
            data:{id_perusahaan:id_perusahaan},
            type: "POST",
            dataType: "JSON",
            success:function(respond){
                $("#metodePengiriman").html(respond);
            }
        });
    });
    $(document).ready(function(){
        $.ajax({
            url:"<?php echo base_url();?>crm/vendor/getContactPerson",
            data:{id_perusahaan:id_perusahaan},
            type: "POST",
            dataType: "JSON",
            success:function(respond){
                $("#cp").html(respond);
            }
        });
    });
}
</script>
<script>
function loadShippingPrice(){
    var id_perusahaan = $("#shipper").val();
    var metode_pengiriman = $("#metodePengiriman").val();
    var id_request_item = $("#items").val();
    var purpose = $("#purpose").val();
    console.log("1. "+id_perusahaan);
    console.log("2. "+metode_pengiriman);
    console.log("3. "+id_request_item);
    console.log("4. "+purpose);
    $(document).ready(function(){
        $.ajax({
            url:"<?php echo base_url();?>crm/vendor/getShippingPrice",
            type: "POST",
            dataType: "JSON",
            data:{id_perusahaan:id_perusahaan,metode_pengiriman:metode_pengiriman,id_request_item:id_request_item,purpose:purpose},
            success:function(respond){
                $("#shippingVariablePrice").html(respond);
            }
        });
    });
}
</script>
<script>
function loadCourierPrice(){
    var id_perusahaan = $("#shipper").val();
    var metode_pengiriman = $("#metodePengiriman").val();
    var id_request_item = $("#items").val();
    var purpose = $("#purpose").val();
    $(document).ready(function(){
        $.ajax({
            url:"<?php echo base_url();?>crm/vendor/getCourierPrice",
            type: "POST",
            dataType: "JSON",
            data:{id_perusahaan:id_perusahaan,metode_pengiriman:metode_pengiriman,id_request_item:id_request_item,purpose:purpose},
            success:function(respond){
                $("#shippingVariablePrice").html(respond);
            }
        });
    });
}
</script>