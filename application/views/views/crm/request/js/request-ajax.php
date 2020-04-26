<script>
function getContactPerson(){
    var id_perusahaan = $("#idperusahaan").val();
    console.log(id_perusahaan);
    $(document).ready(function(){
        $.ajax({
            url: "<?php echo base_url();?>interface/contact_person/getContactPerson/"+id_perusahaan,
            dataType:"JSON",
            success:function(respond){
                var html = "<option>Choose CP</option>";
                for(var a = 0; a<respond.length; a++){
                    html += "<option value ='"+respond[a]["id_cp"]+"'>"+respond[a]["jk_cp"]+". "+respond[a]["nama_cp"]+"</option>";
                }
                $("#cpperusahaan").html(html);
            }
        });
    });
    
}
</script>
<script>
function getDetailContactPerson(){
    var id_cp = $("#cpperusahaan").val();
    $(document).ready(function(){
        $.ajax({
            url:"<?php echo base_url();?>interface/contact_person/getDetailContactPerson/"+id_cp,
            dataType:"JSON",
            success:function(respond){
                $("#email_cp").val(respond["email_cp"]);
                $("#nohp_cp").val(respond["nohp_cp"]);
            }
        })
    });
}
</script>
<script>
function getuom(a){
    var id_produk = $("#items"+a).val();
    console.log(id_produk);
    $(document).ready(function(){
        $.ajax({
            url: "<?php echo base_url();?>master/product/getuom",
            data: {id_produk:id_produk},
            type: "POST",
            dataType:"JSON",
            success:function(respond){
                $("#uom"+a).html(respond);
            }
        });
    });
    
}
</script>