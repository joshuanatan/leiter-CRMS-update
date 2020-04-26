<script>
function quotationDetail(){
    $(document).ready(function(){
        var id_submit_quotation = $("#id_submit_quotation").val();
        $.ajax({
            url:"<?php echo base_url();?>interface/quotation/getQuotationDetail",
            data:{id_submit_quotation:id_submit_quotation},
            dataType:"JSON",
            type:"POST",
            success:function(respond){
                $(".perusahaanCust").val(respond["nama_perusahaan"]);
                $(".namaCust").val(respond["nama_cp"]);
                $("#idCust").val(respond["id_cp"]);
                $("#alamatCust").val(respond["alamat_perusahaan"]);
                $("#up_cp").val(respond["up_cp"]);
                $("#durasi_pengiriman").val(respond["durasi_pengiriman"]);
                $("#durasi_pembayaran").val(respond["durasi_pembayaran"]);
                $("#franco").val(respond["franco"]);
                $("#total_quotation_price").val(addCommas(respond["total_quotation_price"]));
            }
        });
        $.ajax({
            url:"<?php echo base_url();?>interface/quotation/getOrderedItem",
            data:{id_submit_quotation:id_submit_quotation},
            dataType:"JSON",
            type:"POST",
            success:function(respond){
                var html = "";
                /*buat wadahnya*/
                for(var a = 0; a<respond.length; a++){
                    html += "<tr><td id = 'check"+a+"'></td><td id = 'product"+a+"'></td><td id = 'amount"+a+"'></td><td id = 'selling"+a+"'></td><td id = 'final"+a+"'></td></tr>";
                }
                //alert(html);
                $("#t1").html(html);
                
                /*metodenya pake update space yang sudah ada*/
                for(var a = 0; a<respond.length; a++){
                    var check = "";
                    if(respond[a]["status_oc_item"] == 0) check = "checked"; /*ini apakah dia masuk atau engagk*/
                    //alert("hello");
                    $("#check"+a).html('<div class="checkbox-custom checkbox-primary"><input name = "checkbox[]" value = "'+a+'" type="checkbox" id="checks'+a+'" '+check+' /><label for="inputChecked"></label></div>');
                    /* id ini untuk ngitung total pembayaran, semua id harus sesuai dengan urutan*/
                    /* lalu namenya ini untuk tau mana yang diambil valuenya menentukan index array yang aktif di item oc*/

                    /*kalau ini tetep masuk semua ke db, aktif atau tidaknya tunggu dari id yang diatas*/
                    $("#product"+a).html('<textarea name = "nama_oc_item[]" class = "form-control" >'+respond[a]["nama_produk_leiter"]+'</textarea><input type = "hidden" name = "id_quotation_item[]" class = "form-control" value = "'+respond[a]["id_quotation_item"]+'">');
                    
                    $("#amount"+a).html('<input type = "text" id = "jumlah_produk'+a+'" name = "final_amount[]" class = "form-control" value = "'+respond[a]["item_amount"]+' '+respond[a]["satuan_produk"]+'">');

                    $("#selling"+a).html('<input type = "text" class = "form-control" value = "'+respond[a]["selling_price"]+'" readonly>');

                    $("#final"+a).html('<input type = "text" id = "selling_price'+a+'" oninput = "commas(\'selling_price'+a+'\')" name ="final_selling_price[]" class = "form-control" value = "'+respond[a]["selling_price"]+'">');
                    
                }
            }
        });
        $.ajax({
            url:"<?php echo base_url();?>interface/quotation/getMetodePembayaran",
            data:{id_submit_quotation:id_submit_quotation},
            dataType:"JSON",
            type:"POST",
            success:function(respond){    
                $("#persenDp").val(respond["persentase_pembayaran"]+"%");;
                $("#jumlahDp").val(addCommas(respond["nominal_pembayaran"]));
                $("#triggerDp").val(respond["trigger_pembayaran"]);

                $("#persenSisa").val(respond["persentase_pembayaran2"]+"%");
                $("#jumlahSisa").val(addCommas(respond["nominal_pembayaran2"]));
                $("#triggerSisa").val(respond["trigger_pembayaran2"]);

                $("#kurs").val(respond["kurs"]);
            }

        }); 
    });
}
</script>
<script>
function countTotal(){
    var jumlah_row = $("#t1 tr").length;
    var jumlah_tagihan = 0;
    for(var a = 0; a<jumlah_row; a++){
        if($('#checks'+(a)).is(":checked")){
            var jumlah = $("#jumlah_produk"+a).val();
            var split = jumlah.split(" ");
            jumlah_tagihan += parseFloat(splitter($("#selling_price"+a).val(),","))*parseFloat(split[0]);
        }
    }
    $("#totalQuotation").val(addCommas(jumlah_tagihan.toFixed(2)));
    
}
</script>
<script>
function countTotalDataEntry(){
    var jumlah_row = $("#t1 tr").length;
    var jumlah_tagihan = 0;
    for(var a = 0; a<jumlah_row; a++){
        if($('#selling_price'+(a)).val() != ""){
            var jumlah = $("#jumlah_produk"+a).val();
            var split = jumlah.split(" ");
            var biaya = $("#selling_price"+a).val();
            jumlah_tagihan += (parseFloat(splitter(biaya,","))*parseInt(split[0]))*100;
        }
    }
    $("#totalQuotation").val(addCommas(jumlah_tagihan/100));
    
}
</script>
<script>
function paymentWithDP(){
    var persenDp = $("#persenDp").val();
    var persen = splitter(persenDp,"%");
    var totalTagihan = parseFloat(splitter($("#totalQuotation").val(),","));
    $("#persenSisa").val(100-parseFloat(persen)+"%"); /*persenSisa*/
    $("#jumlahSisa").val(addCommas(((100-parseFloat(persen))/100*totalTagihan).toFixed(2)));
    $("#jumlahDp").val(addCommas((parseFloat(persen)/100*totalTagihan).toFixed(2)));
    $("#jumlahSisaClean").val((100-parseFloat(persen))/100*totalTagihan);
    $("#jumlahDpClean").val(parseFloat(persen)/100*totalTagihan);
}
</script>

<script>
function copy(id_source, id_target){
    var text = $("#"+id_source).val();
    $("#"+id_target).val(text);
}
</script>
<script>
function getRecommendationPerusahaan(){
    
    var teks = $("#namaperusahaan").val();
    if(teks != ""){
        $.ajax({
            url:"<?php echo base_url();?>interface/perusahaan/searchCustomerByName",
            type:"POST",
            dataType:"JSON",
            data:{nama_perusahaan:teks},
            success:function(respond){
                var html = "";
                if(respond.length != 0){
                    for(var a =0; a<respond.length; a++){
                        html += "<option value = '"+respond[a]["id_perusahaan"]+"-"+respond[a]["id_cp"]+"'>"+respond[a]["nama_perusahaan"]+" "+respond[a]["nama_cp"]+"</option>";
                    }
                }
                else{
                    html = "<option>CUSTOMER TIDAK DITEMUKAN</option>";
                }
                $("#recommendationPerusahaan").html(html);
            }
        });
    }
    
}

</script>
<script>
function getRecommendationProduk(baris){
    var teks = $("#namaproduk"+baris).val();
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
                $("#similarProduk"+baris).html(html);
                $("#jumlah_produk"+baris).val(" "+respond[0]["satuan_produk"]);
            }
        });
    }
    
}
</script>
<script>
function searchProdukByName(baris){
    var teks = $("#namaproduk"+baris).val();
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
                $("#similarProduk"+baris).html(html);
            }
        });
    }
    
}
</script>