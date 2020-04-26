<script>
function getNoPo(){
    /*cari id customer dlu*/    
    var id_submit_oc = $("#po_info").val(); //dapet id_submit_oc - id_perusahaan - maxId
    var split = id_submit_oc.split("-");
    $.ajax({
        url:"<?php echo base_url();?>interface/po/generateNoPO",
        data:{id_perusahaan:split[1],max_id:split[2]},
        type:"POST",
        dataType:"JSON",
        success:function(respond){
            $("#no_po").val(respond);
        }
    });
}
</script>
<script>
function getOcItem(){
    var id_submit_oc = $("#po_info").val(); //dapet id_submit_oc - id_perusahaan - maxId
    var split = id_submit_oc.split("-");
    $.ajax({
        url:"<?php echo base_url();?>interface/oc/getOcItem",
        type:"POST",
        dataType:"JSON",
        data:{id_submit_oc:id_submit_oc},
        success:function(respond){ //item dari oc
            for(var a = 0; a<respond.length; a++){
                $("#nama_produk_leiter"+a).val(respond[a]["nama_oc_item"]);
                $("#jumlah_produk"+a).val(respond[a]["final_amount"] + " " + respond[a]["satuan_produk"]);
                $("#harga_jual_satuan_produk"+a).val(addCommas(respond[a]["final_selling_price"])+"/"+respond[a]["satuan_produk"]);
                $("#id_oc_item"+a).val(respond[a]["id_oc_item"]);
            }
        }
    })
}
</script>
<script>
function getDetailPerusahaanCustomer(){
    var id_submit_oc = $("#po_info").val(); //dapet id_submit_oc - id_perusahaan - maxId
    var split = id_submit_oc.split("-");
    var id_perusahaan = split[1];
    $.ajax({
        url:"<?php echo base_url();?>interface/perusahaan/getDetailPerusahaan/"+id_perusahaan,
        dataType:"POST",
        success:function(respond){
            $("#nama_customer").val(respond["nama_perusahaan"]);
        }

    });
}
</script>
<script>
function getDetailSupplier(){
    var id_supplier = $("#id_supplier").val(); //dapet id_submit_oc - id_perusahaan - maxId
    console.log(id_supplier);
    $.ajax({
        url:"<?php echo base_url();?>interface/perusahaan/getDetailPerusahaan/"+id_supplier,
        dataType:"JSON",
        success:function(respond){
            $("#phone_supplier").val(respond["notelp_perusahaan"]);
            $("#fax_supplier").val(respond["nofax_perusahaan"]);
            $("#alamat_supplier").val(respond["alamat_perusahaan"]);
        }

    });
    $.ajax({
        url:"<?php echo base_url();?>interface/contact_person/getContactPerson/"+id_supplier,
        dataType:"JSON",
        success:function(respond){
            var html = "";
            for(var a =0; a<respond.length; a++){
                html += "<option value = '"+respond[a]["id_cp"]+"'>"+respond[a]["jk_cp"]+". "+respond[a]["nama_cp"]+"</option>";
            }
            $("#id_pic_supplier").html(html);
        }
    })
}
</script>
<script>
function getDetailShipper(){
    var id_shipper = $("#id_shipper").val(); //dapet id_submit_oc - id_perusahaan - maxId
    console.log(id_shipper);
    $.ajax({
        url:"<?php echo base_url();?>interface/perusahaan/getDetailPerusahaan/"+id_shipper,
        dataType:"JSON",
        success:function(respond){
            $("#phone_shipper").val(respond["notelp_perusahaan"]);
            $("#fax_shipper").val(respond["nofax_perusahaan"]);
            $("#alamat_shipper").val(respond["alamat_perusahaan"]);
        }

    });
    $.ajax({
        url:"<?php echo base_url();?>interface/contact_person/getContactPerson/"+id_shipper,
        dataType:"JSON",
        success:function(respond){
            var html = "";
            for(var a =0; a<respond.length; a++){
                html += "<option value = '"+respond[a]["id_cp"]+"'>"+respond[a]["jk_cp"]+". "+respond[a]["nama_cp"]+"</option>";
            }
            $("#id_pic_shipper").html(html);
        }
    })
}
</script>
<script>
function getVendorDetailPrice(counter){
    //alert(counter);
    $("#shipppingprice"+counter).val("");
    var id_supplier = $("#idsupplier"+counter).val();
    var id_request_item = $("#idrequestitem"+counter).val();
    $(document).ready(function(){
        $.ajax({
            data:{id_request_item:id_request_item,id_perusahaan:id_supplier,result:"array"},
            type:"POST",
            dataType:"JSON",
            url:"<?php echo base_url();?>crm/vendor/getSupplierPriceWithResult",
            success:function(respond){
                $("#hargabarang"+counter).val(addCommas(respond[0]));
                $("#ratebarang"+counter).val(addCommas(respond[1]));
                $("#matauangbarang"+counter).val(respond[2]);
                $("#minimumbarang"+counter).val(respond[3]);
                $("#namaperusahaan"+counter).val(respond[4]);
                $("#alamatperusahaan"+counter).val(respond[5]);
            }
        });
        /*abis supplier dirubah, langsung cari shipper yang udah di masukin harganya yang berkaitan denagn orang ini*/
        $.ajax({
            data:{id_request_item:id_request_item,id_supplier:id_supplier,result:"array"},
            type:"POST",
            dataType:"JSON",
            url:"<?php echo base_url();?>crm/vendor/getShipperWithResult",
            success:function(respond){
                var html = "<option>Choose Shipper</option>";
                for(var a= 0; a<respond.length; a++){
                    html += "<option value = '"+respond[a]["id_shipper"]+"-"+respond[a]["metode_pengiriman"]+"'>"+respond[a]["nama_shipper"]+" - "+respond[a]["metode_pengiriman"]+"</option>";
                }
                $("#idshipper"+counter).html(html);
            }
        });
    });
}
</script>
<script>
function getShipperDetailPrice(counter){
    alert(counter);
    var id_request_item = $("#idrequestitem"+counter).val();
    var id_supplier = $("#idsupplier"+counter).val();
    var shipping = $("#idshipper"+counter).val();
    var detailShipper = splitToArray(shipping,"-");
    $("#shippingmethod"+counter).val(detailShipper[1]);
    $(document).ready(function(){
        $.ajax({
            url:"<?php echo base_url();?>crm/vendor/getShipperPriceWithResult",
            type:"POST",
            dataType:"JSON",
            data:{id_supplier:id_supplier,metode_pengiriman:detailShipper[1],id_perusahaan:detailShipper[0],id_request_item:id_request_item,result:"array"},
            success:function(respond){
                $("#hargashipping"+counter).val(addCommas(respond[0]["total"]));
                $("#matauangshipping"+counter).val(addCommas(respond["currency"]));
            }
        })
    })
}
</script>
<script>
function saveItemPO(counter){
    $(document).ready(function(){
        var id_po_setting = $("#idposetting").val();
        var id_request = $("#idrequest").val();
        var id_request_item = $("#idrequestitem"+counter).val();
        var id_supplier = $("#idsupplier"+counter).val();
        var harga_item = splitter($("#hargabarang"+counter).val(),',');
        var kurs = splitter($("#ratebarang"+counter).val(),',');
        var mata_uang = $("#matauangbarang"+counter).val();
        var id_shipper = $("#idshipper"+counter).val();
        var shipping_method = $("#shippingmethod"+counter).val();
        var harga_shipping = splitter($("#hargashipping"+counter).val(),',');
        var mata_uang_shipping = splitter($("#matauangshipping"+counter).val(),',');
        alert(mata_uang_shipping);
        $.ajax({
            url:"<?php echo base_url();?>crm/po/insertItemPO",
            data:{
                id_request:id_request,id_po_setting:id_po_setting,id_request_item:id_request_item,harga_item:harga_item,kurs:kurs,mata_uang:mata_uang,id_supplier:id_supplier,id_shipper:id_shipper,shipping_method:shipping_method,harga_shipping:harga_shipping,mata_uang_shipping:mata_uang_shipping,
            },
            type:"POST",
            success:function(respond){
                alert("DATA RECORDED");
            }
        });
    });
}
</script>
<script>
function loadVendors(){
    $(document).ready(function(){
        $("#itemamount").val("");
        $("#hargaProduk").val("");
        $("#hargashipping").val("");
        $("#hargaCourier").val("");
        $("#totalMargin").val("");
        $("#inputNominal").val("");
        $("#primaryData").attr("disabled","true");
        var id_request_item = $("#itemsOrdered").val();
        $.ajax({
            url:"<?php echo base_url();?>crm/request/getAmountOrders",
            data: {id_request_item:id_request_item},
            dataType: "JSON",
            type: "POST",
            success:function(respond){
                $("#itemamount").val(respond);
            }
        });
        $.ajax({
            url:"<?php echo base_url();?>crm/vendor/getVendors",
            data: {id_request_item:id_request_item},
            dataType: "JSON",
            type: "POST",
            success:function(respond){
                var html = "<option>Choose Supplier</option>";
                for(var a = 0 ; a<respond.length; a++){
                    html += "<option value = '"+respond[a]["id_perusahaan"]+"'>"+respond[a]["nama_perusahaan"]+"</option>"
                }
                $("#products").html(html);
            }
        });
        $.ajax({
            url:"<?php echo base_url();?>crm/vendor/getCouriers",
            data: {id_request_item:id_request_item},
            dataType: "JSON",
            type: "POST",
            success:function(respond){
                $("#courier").html(respond);
            }
        });
        
    });
}
</script>
<script>
function getShippingPrice(){
    $("#hargashipping").val("");
    $(document).ready(function(){
        var id_perusahaan = $("#shippers").val();
        var id_supplier = $("#products").val();
        //alert(id_perusahaan);
        var comp = id_perusahaan.split("-");
        $.ajax({
            data:{id_perusahaan:comp[0],metode_pengiriman:comp[1],id_supplier:id_supplier},
            url: "<?php echo base_url();?>crm/vendor/getShipperPrice",
            dataType: "JSON",
            type: "POST",
            success:function(respond){
                $("#hargashipping").val(respond);
            }
        }); 
    }); 
}
</script>
<script>
function getVendorPrice(){
    $(document).ready(function(){
        $("#hargaProduk").val("");
        $("#hargashipping").val("");
        var id_perusahaan = $("#products").val();
        var id_request_item = $("#itemsOrdered").val();
        $.ajax({
            data:{id_perusahaan:id_perusahaan},
            url: "<?php echo base_url();?>crm/vendor/getVendorPrices",
            dataType: "JSON",
            type: "POST",
            success:function(respond){
                $("#hargaProduk").val([respond["items"]["harga_produk"]]);
                $("#rateHarga").val([respond["items"]["rate"]]);
                $("#matauang").val([respond["items"]["mata_uang"]]);
                /*harus ngisi shipper*/
                $.ajax({
                    data:{id_perusahaan:id_perusahaan,id_request_item:id_request_item},
                    url: "<?php echo base_url();?>crm/vendor/getShipper",
                    dataType: "JSON",
                    type: "POST",
                    success:function(responde){
                        var html = "<option>Choose Shipper</option>";
                        for(var a = 0; a<responde.length; a++){
                            html += "<option value = '"+responde[a]["id_perusahaan"]+"-"+responde[a]["metode_pengiriman"]+"'>"+responde[a]["nama_perusahaan"]+" - "+responde[a]["metode_pengiriman"]+"</option>";
                        }
                        $("#shippers").html(html);
                    }
                });
            }
        }); 
    }); 
}
</script>
<script>
function decimal(){
    var number = splitter($("#inputNominal").val(),",");
    $("#inputNominal").val(addCommas(parseInt(number)));
}
</script>
<script>
function poitem(){
    $(document).ready(function(){
        var shipper = $("#shippers").val();
        var split = shipper.split("-");
        var id_po_setting = $("#id_po_setting").val();
        var id_request_item = $("#itemsOrdered").val();
        var harga_item = $("#inputNominal").val();
        var kurs = $("#rateHarga").val();
        var mata_uang = $("#matauang").val();
        var id_supplier = $("#products").val();
        var id_shipper = split[0];
        var shipping_method = split[1];
        var harga_shipping = $("#hargashipping").val();
        var jumlah_item = $("#itemamount").val();
        $.ajax({
            data:{
                id_po_setting:id_po_setting,id_request_item:id_request_item,harga_item:harga_item,kurs:kurs,mata_uang:mata_uang,id_supplier:id_supplier, id_shipper:id_shipper, shipping_method:shipping_method,harga_shipping:harga_shipping,jumlah_item:jumlah_item
            },
            url:"<?php echo base_url();?>crm/po/addItemToPoItem",
            type:"POST",
            success:function(respond){
                showItem();
            }
        });
    });
}
</script>
<script>
function showItem(){
    var id_po_setting = $("#id_po_setting").val();
    $.ajax({
        data:{id_po_setting:id_po_setting},
        url:"<?php echo base_url();?>crm/po/getpoItem",
        dataType:"JSON",
        type:"POST",
        success:function(respond){
            var html = "";
            for(var a = 0; a<respond.length; a++){
                html += "<tr><td>"+respond[a]["id_request_iten"]+"</td><td>"+respond[a]["nama_produk"]+"</td><td>"+respond[a]["jumlah"]+"</td><td>"+respond[a]["harga_beli"]+"</td><td>"+respond[a]["mata_uang"]+"</td><td>"+respond[a]["shipper"]+"</td><td><button type = 'button' onclick = 'removePOItem("+respond[a]["id_po_item"]+")' class ='btn btn-outline btn-sm btn-danger'>REMOVE</button></td></tr>"
            }
            $("#t1").html(html);
        }
    });
}
</script>
<script>
function removePOItem(id_po_item){
    $.ajax({
        data:{id_po_item:id_po_item},
        url:"<?php echo base_url();?>crm/po/removeitem",
        type:"POST",
        dataType:"JSON",
        success:function(respond){
        }
    });
    
    showItem(); 
}
</script>
<script>
function getDetailHargaVendor(urutan){
    var id_oc_item = $("#id_oc_item"+urutan).val();
    var id_supplier = $("#id_supplier").val();
    $.ajax({
        url:"<?php echo base_url();?>interface/harga_vendor/getVendorPriceForPo",
        data:{id_oc_item:id_oc_item,id_supplier:id_supplier},
        type:"POST",
        dataType:"JSON",
        success:function(respond){
            $("#nama_produk_vendor"+urutan).val(respond["nama_produk_vendor"]);
            $("#harga_satuan_produk"+urutan).val(addCommas(respond["harga_produk"]));
            //$("#currency"+urutan).val(respond["mata_uang"]);
        } 
    });
}

</script>

<script>
function getRecommendationProduk(baris){
    var teks = $("#namaproduk"+baris).val();
    console.log(teks);
    if(teks != ""){
        $.ajax({
            url:"<?php echo base_url();?>interface/produk/searchProdukByName",
            type:"POST",
            dataType:"JSON",
            data:{deskripsi_produk:teks},
            success:function(respond){
                if(respond.length != 0){
                    var html = "";
                    for(var a = 0; a<respond.length; a++){
                        html += "<option value = '"+respond[a]["id_produk"]+"'>"+respond[a]["deskripsi_produk"]+"</option>";
                    }
                }
                else{
                    var html = "<option value = '0'>PRODUK TIDAK DITEMUKAN</option>"
                }
                $("#similarProduk"+baris).empty();
                $("#similarProduk"+baris).html(html);
                $("#jumlah_produk"+baris).val(" "+respond[0]["satuan_produk"]);
            }
        });
    }
    
}
</script>
<script>
function getSatuanProduk(baris){
    var id_produk = $("#similarProduk"+baris).val();
    console.log(id_produk);
    $.ajax({
        url:"<?php echo base_url();?>interface/produk/searchProdukById",
        type:"POST",
        dataType:"JSON",
        data:{id_produk:id_produk},
        success:function(respond){
            console.log(respond[0]["satuan_produk"]);
            $("#jumlah_produk"+baris).val(" "+respond[0]["satuan_produk"]);
        }
    });
}
</script>