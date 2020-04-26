<script>
function isExistsInRefrence(){
    var peruntukan = $("#peruntukan").val();
    var no_refrence = $("#no_refrence").val();
    switch(peruntukan){
        case "SUPPLIER":
        case "SHIPPER":
            $.ajax({
                url:"<?php echo base_url();?>interface/po/isExists/",
                data:{no_refrence:no_refrence},
                type:"POST",
                dataType:"JSON",
                success:function(respond){
                    if(respond == 0){
                        $("#resultMessage").html("REFRENCE FOUND");
                        $("#resultMessage").css("color","green");
                    }
                    else{
                        $("#resultMessage").html("REFRENCE NOT FOUND");
                        $("#resultMessage").css("color","RED");
                    }
                }
            });
        break;
        case "COURIER":
            $.ajax({
                url:"<?php echo base_url();?>interface/od/isExists/"+no_refrence,
                data:{no_refrence:no_refrence},
                type:"POST",
                dataType:"JSON",
                success:function(respond){
                    if(respond == 0){
                        $("#resultMessage").html("REFRENCE FOUND");
                        $("#resultMessage").css("color","green");
                    }
                    else{
                        $("#resultMessage").html("REFRENCE NOT FOUND");
                        $("#resultMessage").css("color","RED");
                    }
                }
            });
        break;
    }
}
</script>
<script>
function countPpn(){
    if($("input[name='is_ppn[]']:checked").length > 0){
        var subtotal = splitter($("#subtotal").val(),",");
        var discount = splitter($("#discount").val(),",");
        $("#afterPpn").val((subtotal-discount)*0.1); /*hitung pajak setelah diskon*/
    }
    else $("#afterPpn").val("0");
    commas("afterPpn");
}
</script>
<script>
function countAfterDiscont(){
    var subtotal = splitter($("#subtotal").val(),",");
    var discount = splitter($("#discount").val(),",");
    $("#afterDiscount").val(subtotal-discount);
    commas("afterDiscount");
}
</script>
<script>
function countPph(){
    if($("input[name='is_pph[]']:checked").length > 0){
        var subtotal = splitter($("#subtotal").val(),",");
        var discount = splitter($("#discount").val(),",");
        $("#afterPph").val((subtotal-discount)*0.02); /*hitung pajak setelah diskon*/
    }
    else $("#afterPph").val("0");
    commas("afterPph");
}
</script>
<script>
function countTotal(){
    /*pokoknya, discount yang tertera di kertas*/
    var subtotal = parseInt(splitter($("#afterDiscount").val(),","));
    var ppn = parseInt(splitter($("#afterPpn").val(),","));
    var pph = parseInt(splitter($("#afterPph").val(),","));
    var total = subtotal+ppn-pph; /*berarti ini diskon setelah ppn dan pph*//*kalau diskon sebelum ppn dan pph, harusnya dikurangi dulu baru dikali 10% di atas*/
    $("#total").val(total);
    commas("total");
}
</script>
