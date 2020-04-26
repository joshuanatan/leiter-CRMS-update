<script>
function oc_detail(){ /*kepake di add invoice*/
    var id_submit_oc = $("#id_submit_oc").val(); //id_submit_invoice
    var split = id_submit_oc.split("-");
    var id_submit_oc = split[0];
    var id_perusahaan = split[1];
    console.log(id_perusahaan);
    /*Cek Payment Type*/
    /*Cek Detail Perusahaan Customer Type*/
    $.ajax({
        url:"<?php echo base_url();?>interface/oc/getOcPaymentMethod/"+id_submit_oc,
        dataType:"JSON",
        success:function(respond){
            var html = "<option selected disabled>TIPE PEMBAYARAN</option>";
            /*
            kalau ada transaksi 1 = berdp - pelunasan (dp - lunas)
            kalau ga ada transaksi 1 = tidak dp - langsung lunas (lunas)
            */
            if(respond["is_ada_transaksi"] == 0){ //kalau transaksi pertama ada, berarti persen dp gak 0, berarti ada dp
                if(respond["status_bayar"] == 1){ //kalau DP belum dibayar
                    html += "<option value = '2'>Down Payment (DP)</option>";
                }
                else{ //kalau DP sudah dibayar
                    html += "<option disabled value = '2'>Down Payment (DP)</option>";
                }
                if(respond["status_bayar2"] == 1){ //keluarin kalau yang sudah bayar DP
                    var status_pay = "";
                    if(respond["status_bayar"] == 1){
                        status_pay = "disabled";
                    }
                    html += "<option "+status_pay+" value = '3'>Pelunasan Tagihan (Ada DP)</option>";
                }
            }
            else{ //kalau ga ada transaksi 1
                if(respond["status_bayar2"] == 1){
                    html += "<option value = '1'>Pelunasan Utuh</option>";
                }
            }
            $("#payment_type").html(html);
            $("#persen_dp").val(respond["persentase_pembayaran"]);
            $("#persen_sisa").val(100-respond["persentase_pembayaran"]);
        }
    });
    $.ajax({
        url:"<?php echo base_url();?>interface/perusahaan/getDetailPerusahaan/"+id_perusahaan,
        dataType:"JSON",
        success:function(respond){
            $("#alamat_penagihan").val(respond["alamat_perusahaan"]);
        }
    });
    $.ajax({
        url:"<?php echo base_url();?>interface/oc/getOcDetail/"+id_submit_oc,
        dataType:"JSON",
        success:function(respond){
            $("#franco").val(respond["franco"]);
            $("#durasi_pembayaran").val(respond["durasi_pembayaran"]);
            $("#att").val(respond["up_cp"]);
        }
    })
}
</script>
<script>
function changePayment(){
    var id_submit_oc = $("#id_submit_oc").val(); //id_submit_invoice
    var payment_type = $("#payment_type").val();
    var split_oc = id_submit_oc.split("-");
    console.log(payment_type);
    switch(parseInt(payment_type)){

        case 1://pelunasan no dp
        case 3: //pelunasan with dp
        
            $(".dp").css("display","none"); //hilangkan yang berkaitan dengan DP
            $.ajax({ 
            url:"<?php echo base_url();?>interface/oc/getOcPaymentMethod/"+split_oc[0],
            dataType:"JSON",
            success:function(respond){
                console.log(respond["trigger_pembayaran2"]);
                if(respond["trigger_pembayaran2"] == "2"){ //nunggu OD
                
                    $("#od").css("display","block");
                    $("#boxes").css("display","block");
                    $.ajax({
                        url:"<?php echo base_url();?>interface/od/getListOdForPelunasan",
                        data:{id_submit_oc:split_oc[0]},
                        type:"POST",
                        dataType:"JSON",
                        success:function(respondOd){
                            var html = "<option>Choose OD</option>";
                            for(var od = 0; od < respondOd.length; od++){
                                html += "<option value = '"+respondOd[od]["id_submit_od"]+"'>"+respondOd[od]["no_od"]+"</option>";
                            }
                            $("#od").html(html);
                        }
                    });
                    //nanti nembak ke OD, pake id_submit_oc
                }
                else{ //tidak tunggu OD4
                    $("#od").css("display","none");//hilangkan dropdown OD
                    $("#od_container").css("display","none");
                    $("#boxes").css("display","none");
                    $.ajax({ //dp
                        url:"<?php echo base_url();?>interface/oc/getOcItem",
                        data:{id_submit_oc:id_submit_oc},
                        type:"POST",
                        dataType:"JSON",
                        success:function(respond){
                            var html = "";
                            var total_tagihan = 0;
                            for(var a = 0; a<respond.length; a++){
                                var final_selling = parseInt(respond[a]["final_selling_price"])*parseInt(respond[a]["final_amount"]);
                                total_tagihan += final_selling;
                                html += "<tr><td>"+(a+1)+"</td><td>"+respond[a]["nama_oc_item"]+"</td><td>"+respond[a]["final_amount"]+" "+respond[a]["satuan_produk"]+"</td><td>"+addCommas(respond[a]["final_selling_price"])+"</td><td>"+addCommas(final_selling)+"</td></tr>";
                            }
                            $("#list_item_oc").html(html); //masukin item Oc ke tabel di items
                            $("#total_tagihan_po").val(addCommas(total_tagihan)); //masukin value tagihan semuanya di total tagihan

                            $(".pelunasan").css("display","block"); //munculin yang berkaitan dengan DP
                            
                            var persen_sisa = $("#persen_sisa").val(); //ngambil persen DP
                            $("#total_sisa").val(addCommas(total_tagihan*parseInt(persen_sisa)/100)); //dapetin berapa DPnya
                            $("#nominal_pembayaran").val(addCommas(total_tagihan*parseInt(persen_sisa)/100)); //siap masuk DB
                        }
                    });    
                    //ambil tagihan sisa
                }
            }
        });    
        break;
        case 2: //dp
            $("#od").css("display","none");//hilangkan dropdown OD
            $("#od_container").css("display","none");
            $("#boxes").css("display","none");
            $.ajax({ //dp
                url:"<?php echo base_url();?>interface/oc/getOcItem",
                data:{id_submit_oc:id_submit_oc},
                type:"POST",
                dataType:"JSON",
                success:function(respond){
                    var html = "";
                    var total_tagihan = 0;
                    for(var a = 0; a<respond.length; a++){
                        var final_selling = parseInt(respond[a]["final_selling_price"])*parseInt(respond[a]["final_amount"]);
                        total_tagihan += final_selling;
                        html += "<tr><td>"+(a+1)+"</td><td>"+respond[a]["nama_oc_item"]+"</td><td>"+respond[a]["final_amount"]+" "+respond[a]["satuan_produk"]+"</td><td>"+addCommas(respond[a]["final_selling_price"])+"</td><td>"+addCommas(final_selling)+"</td></tr>";
                    }
                    test = respond[0]["satuan_produk"];
                    $("#list_item_oc").html(html); //masukin item Oc ke tabel di items
                    $("#total_tagihan_po").val(addCommas(total_tagihan)); //masukin value tagihan semuanya di total tagihan

                    $(".dp").css("display","block"); //munculin yang berkaitan dengan DP
                    
                    var persen_dp = $("#persen_dp").val(); //ngambil persen DP
                    $("#total_dp").val(addCommas(total_tagihan*parseInt(persen_dp)/100)); //dapetin berapa DPnya
                    $("#nominal_pembayaran").val(addCommas(total_tagihan*parseInt(persen_dp)/100)); //siap masuk DB
                }
            });    
        break;
        
    }
}
</script>
<script>

function loadOdItem(){
    var id_submit_od = $("#od").val();
    $.ajax({
        data:{id_submit_od:id_submit_od},
        type:"POST",
        dataType:"JSON",
        url:"<?php echo base_url();?>interface/od/getOdItemPayment",
        success:function(respond){
            var html = "";
            for(var a = 0; a<respond["items"].length; a++){
                html += "<tr><td>"+(a+1)+"</td><td>"+respond["items"][a]["nama_produk"]+"</td><td>"+respond["items"][a]["item_qty"]+" / "+respond["items"][a]["final_amount"]+" "+respond["items"][a]["satuan_produk"]+"</td><td>"+addCommas(respond["items"][a]["final_selling_price"])+"</td><td>"+addCommas(respond["items"][a]["final_price"])+"</td></tr>";
            }
            $("#list_item_oc").html(html); 
            $("#nominal_pembayaran").val(addCommas(respond["subtotal"]));
            $("#total_tagihan_po").val(addCommas(respond["harga_po"]));
        }
    })
}
</script>
<script>
function detailPayment(){
    var id_metode_pembayaran = $("#metodepembayaran").val();
    var id_oc = $("#idoc").val();
    $.ajax({
        url:"<?php echo base_url();?>crm/invoice/getDetailMetodePembayaran",
        dataType:"JSON",
        data:{id_metode_pembayaran:id_metode_pembayaran},
        type:"POST",
        success:function(respond){
            var trigger = "";
            if(respond["trigger_pembayaran"] == 1){
                $("#paymentWithOd").css("display","none");
                trigger = "AFTER OC, BEFORE OD";
                $(".method1").css("display","block");
                $(".method2").css("display","none");
                $("#paymentPercentage").val(respond["persentase"]);
                $("#paymentAmount").val(respond["nominal"]);
                $("#paymentTrigger").val(trigger);
            }
            else{
                $(".method2").css("display","block");
                $(".method1").css("display","none");
                trigger = "AFTER OD";
                $.ajax({
                    url:"<?php echo base_url();?>crm/invoice/getPaymentWithOd",
                    data:{id_oc:id_oc,use_od:0},
                    type:"POST",
                    dataType:"JSON",
                    success:function(responde){
                        //alert(responde);
                        var html = "";
                        for(var a = 0 ; a<responde["historyOd"].length; a++){ //length ga kebaca disini
                            html += "<tr><td>"+responde["historyOd"][a]["no_invoice"]+"</td><td>"+responde["historyOd"][a]["no_od"]+"</td><td>"+responde["historyOd"][a]["nominal"]+"</td><td>"+responde["historyOd"][a]["tanggal_keluar"]+"</td></tr>";
                        }
                        $("#paymentWithOdT1").html(html);
                    }
                });
                $.ajax({
                    url:"<?php echo base_url();?>crm/invoice/getOD",
                    data:{id_oc:id_oc,use_od:0},
                    type:"POST",
                    dataType:"JSON",
                    success:function(responde){
                        //alert(responde);
                        var html = "<option>Choose OD</option>";
                        for(var a = 0 ; a<responde["od"].length; a++){
                            html += "<option value = '"+responde["od"][a]["id_od"]+"'>"+responde["od"][a]["no_od"]+"</option>";
                        }
                        $("#orderDelivery").html(html);
                    }
                });
            }
        }
    });
}
</script>
<script>
function detailOd(){
    var id_od = $("#orderDelivery").val();
    $.ajax({
        url:"<?php echo base_url();?>crm/od/getOdItemPayment",
        data:{id_od:id_od},
        dataType:"JSON",
        type:"POST",
        success:function(respond){
            var html = "";
            for(var a = 0 ; a<respond.length; a++){
                html += "<tr><td>"+respond[a]["nama_produk"]+"</td><td>"+respond[a]["item_qty"]+"</td><td>"+respond[a]["paymentAmount"]+"</td></tr>"
                
            }
            $("#paymentWithOdBawah").html(html);
        }
    }); 
}
</script>
<script>