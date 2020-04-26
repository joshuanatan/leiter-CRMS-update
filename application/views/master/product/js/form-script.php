<script>
function showNewUOM(){
    if($("#uom").val() == 0){
        $("#newUom").css("display","block");
        $("uom").attr("name","gakepake");
    }
    else{

        $("#newUom").css("display","none");
        $("uom").attr("name","uom");
    }
}
</script>