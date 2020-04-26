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