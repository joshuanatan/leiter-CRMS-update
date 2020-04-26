<script>
function detailPriceRequest(){ //kemungkinan udah ga dipake
    
    var id_submit_request = $("#id_request").val();
    $(document).ready(function(){
        $.ajax({
            data:{id_submit_request:id_submit_request},
            url:"<?php echo base_url();?>interface/request/getRequestDetail",
            type: "POST",
            dataType: "JSON",
            success:function(respond){
                $(".perusahaanCust").val(respond["price_request"]["nama_perusahaan"]);
                $(".namaCust").val(respond["price_request"]["nama_cp"]);
                $("#idCust").val(respond["price_request"]["id_cp"]);
                $("#idPerusahaan").val(respond["price_request"]["id_perusahaan"]);
                $("#alamatCust").val(respond["price_request"]["alamat_perusahaan"]);
                $("#franco").val(respond["price_request"]["franco"]);
                $("#itemsOrdered").html("<option selected>RFQ Item</option>");
                var row = "";
                for(var a = 0; a<respond["price_request_item"].length; a++){
                    row = "<tr><td><div class = 'checkbox-custom checkbox-primary'><input type = 'checkbox' name = 'checks[]' checked value = '"+(jumlah_baris+1)+"' id = 'checks"+(jumlah_baris+1)+"'><label></label></div></td><td><input type = 'text' value = '"+id_request_item+"' readonly class = 'form-control' name = 'id_request_item"+(jumlah_baris+1)+"'></td><td><textarea readonly class = 'form-control' name = 'nama_produk_leiter"+(jumlah_baris+1)+"'>"+nama_produk_leiter+"</textarea></td><td><input type = 'text' value = '"+item_amount+"' readonly class = 'form-control' id = 'jumlah_produk"+(jumlah_baris+1)+"' name = 'item_amount"+(jumlah_baris+1)+"'></td><td><input type = 'text' value = '"+selling_price+"' readonly class = 'form-control' id = 'selling_price"+(jumlah_baris+1)+"'  name = 'selling_price"+(jumlah_baris+1)+"'></td><td><input type = 'text' value = '"+margin_price+"' readonly class = 'form-control' name = 'margin_price"+(jumlah_baris+1)+"'></td><td><input type = 'file' readonly class = 'form-control' name = 'attachment"+(jumlah_baris+1)+"'></td><input type = 'hidden' value = '"+id_harga_vendor+"' name = 'id_harga_vendor"+(jumlah_baris+1)+"'><input type = 'hidden' value = '"+id_harga_shipping+"' name = 'id_harga_shipping"+(jumlah_baris+1)+"'><input type = 'hidden' value = '"+id_harga_courier+"' name = 'id_harga_courier"+(jumlah_baris+1)+"'></tr>";
                    
                    $("#itemsOrdered").append(row);
                }
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
            url:"<?php echo base_url();?>interface/request/getAmountOrders",
            data: {id_request_item:id_request_item},
            dataType: "JSON",
            type: "POST",
            success:function(respond){
                $("#itemamount").val(respond);
            }
        });
        $.ajax({
            url:"<?php echo base_url();?>interface/request/getNamaProduk",
            data: {id_request_item:id_request_item},
            dataType: "JSON",
            type: "POST",
            success:function(respond){
                $("#nama_produk_leiter").val(respond);
            }
        });

        $.ajax({
            url:"<?php echo base_url();?>interface/vendor/getListVendor",
            data: {id_request_item:id_request_item},
            dataType: "JSON",
            type: "POST",
            success:function(respond){
                var html = "<option>Choose Supplier</option>";
                for(var a = 0 ; a<respond.length; a++){
                    html += "<option value = '"+respond[a]["id_harga_vendor"]+"'>"+respond[a]["nama_perusahaan"]+"</option>"
                }
                $("#products").html(html);
            }
        });

        $.ajax({
            url:"<?php echo base_url();?>interface/vendor/getListCourier",
            data: {id_request_item:id_request_item},
            dataType: "JSON",
            type: "POST",
            success:function(respond){
                var html = "<option>Choose Courier</option>";
                for(var a = 0 ; a<respond.length; a++){
                    html += "<option value = '"+respond[a]["id_harga_courier"]+"'>"+respond[a]["nama_perusahaan"]+" - "+respond[a]["metode_pengiriman"]+"</option>"
                }
                $("#courier").html(html);
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
        var id_harga_vendor = $("#products").val();
        $.ajax({
            data:{id_harga_vendor:id_harga_vendor},
            url: "<?php echo base_url();?>interface/vendor/getVendorPrices",
            dataType: "JSON",
            type: "POST",
            success:function(respond){
                $("#hargaProduk").val(addCommas(respond["harga_produk"]*respond["vendor_price_rate"]));
                /*harus ngisi shipper*/
                var id_request_item = $("#itemsOrdered").val();
                $.ajax({
                    data:{id_harga_vendor:id_harga_vendor},
                    url: "<?php echo base_url();?>interface/vendor/getListShipper",
                    dataType: "JSON",
                    type: "POST",
                    success:function(responde){
                        var html = "<option>Choose Shipper</option>";
                        for(var a = 0; a<responde.length; a++){
                            html += "<option value = '"+responde[a]["id_harga_shipping"]+"'>"+responde[a]["nama_perusahaan"]+" - "+responde[a]["metode_pengiriman"]+"</option>";
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
function getCourierPrice(){
    $("#hargaCourier").val("");
    $(document).ready(function(){
        var id_harga_courier = $("#courier").val();
        $.ajax({
            data:{id_harga_courier:id_harga_courier},
            url: "<?php echo base_url();?>interface/vendor/getCourierPrices",
            dataType: "JSON",
            type: "POST",
            success:function(respond){
                $("#hargaCourier").val(addCommas(respond["harga_produk"]*respond["vendor_price_rate"]));
            }
        }); 
    }); 
}
</script>
<script>
function getShippingPrice(){
    $("#hargashipping").val("");
    $(document).ready(function(){
        var id_harga_shipping = $("#shippers").val();
        $.ajax({
            data:{id_harga_shipping:id_harga_shipping},
            url: "<?php echo base_url();?>interface/vendor/getShipperPrice",
            dataType: "JSON",
            type: "POST",
            success:function(respond){
                $("#hargashipping").val(addCommas(respond["harga_produk"]*respond["vendor_price_rate"]));
            }
        }); 
    }); 
}
</script>
<script>
function getMargin(){
    var jumlah_pesan = $("#itemamount").val(); //23 dus
    var detail_pesanan = jumlah_pesan.split(" ");
    var total = $("#totalPrice").val();
    var input = $("#inputNominal").val();
    var totalfinal = splitter(total,",");
    var inputfinal = splitter(input,",");
    var totalQuotationPrice =parseFloat(inputfinal)*parseFloat(detail_pesanan[0]);
    var selisih = totalQuotationPrice- parseFloat(totalfinal);
    var margin = selisih/totalQuotationPrice*100; //biar jadi persen
    var margin2 = parseInt(margin*1000)/1000;
    console.log(margin);

    $("#totalMargin").val(margin2+"%");
}
</script>
<script>
function quotationItem(){
    $(document).ready(function(){
        var jumlah_baris = $("#t1 tr").length;

        var id_submit_quotation = $("#id_submit_quotation").val();
        var id_request_item = $("#itemsOrdered").val();
        var nama_produk_leiter = $("#nama_produk_leiter").val();
        var id_harga_vendor = $("#products").val();
        var id_harga_shipping = $("#shippers").val();
        var id_harga_courier = $("#courier").val();
        var item_amount = $("#itemamount").val();
        var selling_price = $("#inputNominal").val();
        var margin_price = $("#totalMargin").val();
        
        var row = "<tr><td><div class = 'checkbox-custom checkbox-primary'><input type = 'checkbox' name = 'checks[]' checked value = '"+(jumlah_baris+1)+"' id = 'checks"+(jumlah_baris+1)+"'><label></label></div></td><td><input type = 'text' value = '"+id_request_item+"' readonly class = 'form-control' name = 'id_request_item"+(jumlah_baris+1)+"'></td><td><textarea readonly class = 'form-control' name = 'nama_produk_leiter"+(jumlah_baris+1)+"'>"+nama_produk_leiter+"</textarea></td><td><input type = 'text' value = '"+item_amount+"' readonly class = 'form-control' id = 'jumlah_produk"+(jumlah_baris+1)+"' name = 'item_amount"+(jumlah_baris+1)+"'></td><td><input type = 'text' value = '"+selling_price+"' readonly class = 'form-control' id = 'selling_price"+(jumlah_baris+1)+"'  name = 'selling_price"+(jumlah_baris+1)+"'></td><td><input type = 'text' value = '"+margin_price+"' readonly class = 'form-control' name = 'margin_price"+(jumlah_baris+1)+"'></td><td><input type = 'file' readonly class = 'form-control' name = 'attachment"+(jumlah_baris+1)+"'></td><input type = 'hidden' value = '"+id_harga_vendor+"' name = 'id_harga_vendor"+(jumlah_baris+1)+"'><input type = 'hidden' value = '"+id_harga_shipping+"' name = 'id_harga_shipping"+(jumlah_baris+1)+"'><input type = 'hidden' value = '"+id_harga_courier+"' name = 'id_harga_courier"+(jumlah_baris+1)+"'></tr>";
        $("#t1").append(row);
    });
}
</script>
<!------------------------------------------------------------------------------------->

<script>
function getTotal(){ 
    /* awalnya hanya all qty langsung, skrg harga jadi per item*/
    var jumlah_pesan = $("#itemamount").val(); //23 dus
    var detail_pesanan = jumlah_pesan.split(" ");
    var shipper = $("#hargashipping").val();
    var produk = $("#hargaProduk").val();
    var courier = $("#hargaCourier").val();
    var total = $("#itemamount").val();
    var input = $("#inputNominal").val();
    var shipperfinal = splitter(shipper,",");
    var produkfinal = splitter(produk,",");
    var courierfinal = splitter(courier,",");
    var inputfinal = splitter(input,",");

    $("#totalPrice").val(addCommas((parseFloat(shipperfinal)*parseFloat(detail_pesanan[0]))+(parseFloat(produkfinal)*parseFloat(detail_pesanan[0]))+(parseFloat(courierfinal)*parseFloat(detail_pesanan[0]))));
    $("#inputNominal").val(addCommas(parseFloat(shipperfinal)+parseFloat(produkfinal)+parseFloat(courierfinal)));
}
</script>

<script>
function decimal(){
    var number = splitter($("#inputNominal").val(),",");
    $("#inputNominal").val(addCommas(parseFloat(number)));
}
</script>
<!-------- update 14/08/2019 ----------------->
<script>
function countTotalVendorPrice(a){ //baris keberapa
    //var itemAmount = $("#item_amount"+a);
    //var itemSplit = itemAmount.split(" "); //misahin angka dengan satuan
    //var jumlahBarang = splitter(itemSplit[0],","); //takut kedepannya kalau ribuan mau pake koma
    var jumlahBarang = 1; //takut kedepannya kalau ribuan mau pake koma

    var hargaVendor = splitter($("#harga_produk_vendor"+a).val(),","); //supaya jadi angka normal
    var rateVendor = splitter($("#rate_vendor"+a).val(),","); //supaya jadi angka normal
    var totalVendor = parseFloat(hargaVendor)*parseFloat(rateVendor)*parseFloat(jumlahBarang);

    var hargaKurir = splitter($("#harga_produk_kurir"+a).val(),","); //supaya jadi angka normal
    var rateKurir = splitter($("#rate_kurir"+a).val(),","); //supaya jadi angka normal
    var totalKurir = parseFloat(hargaKurir)*parseFloat(rateKurir)*parseFloat(jumlahBarang);

    var hargaShipper = splitter($("#harga_produk_shipper"+a).val(),","); //supaya jadi angka normal
    var rateShipper = splitter($("#rate_shipper"+a).val(),","); //supaya jadi angka normal
    var totalShipper = parseFloat(hargaShipper)*parseFloat(rateShipper)*parseFloat(jumlahBarang);

    var modal = (totalVendor*100)+(totalKurir*100)+(totalShipper*100);
    var finalModal = modal/100;
    $("#modal_vendor"+a).val(addCommas(finalModal));
}
</script>
<script>
function totalJualBarang(a){
    var sellingPrice = splitter($("#selling_price"+a).val(),",");
    
    var itemAmount = $("#item_amount"+a).val();
    var itemSplit = itemAmount.split(" "); //misahin angka dengan satuan
    var jumlahBarang = splitter(itemSplit[0],","); //takut kedepannya kalau ribuan mau pake koma

    var totalSellingPrice = parseFloat(sellingPrice)*parseFloat(jumlahBarang);
    $("#harga_jual"+a).val(addCommas(totalSellingPrice.toFixed(2)));
}
</script>
<script>
function getMarginItem(a){
    //keuntungan / harga jual
    var modal = splitter($("#modal_vendor"+a).val(),",");
    var sellingPrice = splitter($("#selling_price"+a).val(),",");
    
    var margin = ((sellingPrice*100)-(modal*100))/(sellingPrice*100)*100;
    $("#margin_price"+a).val(margin.toFixed(2) +"%");

}
</script>
<script>
function getQuotationPrice(){
    var jumlah_row = $("#quotation_item_table tr").length;
    var jumlah_tagihan = 0;

    for(var a = 0; a<jumlah_row; a++){
        if($('#checks'+(a)).is(":checked")){
            var jumlah = splitter($("#harga_jual"+a).val(),",");
            jumlah_tagihan += parseFloat(jumlah);
            console.log(jumlah);
            console.log(jumlah_tagihan);
        }
    }
    $("#totalQuotation").val(addCommas(jumlah_tagihan.toFixed(2)));
    
}
</script>