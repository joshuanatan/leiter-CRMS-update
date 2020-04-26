<script>
function add() {
    $("#t1").append('<tr class="grade"><td><select class = "form-control" id = "items" data-plugin="select2"><option disabled selected>Choose Vendor ID</option><option>PT Mitra Abc</option></select></td> <td><input type="text" class="form-control" name="touchSpinVertical" data-plugin="TouchSpin"  data-verticalbuttons="true" value="0" /></td> <td><input type="text" class="form-control" name="touchSpinVertical" data-plugin="TouchSpin"  data-verticalbuttons="true" value="0" /></td> <td><input type="text" class="form-control" name="touchSpinVertical" data-plugin="TouchSpin"  data-verticalbuttons="true" value="0" /></td><td> <button class = "btn btn-sm btn-success col-lg-12">Use</button></td></tr>');

    $("#items").select2({});
}
var count = 1;
var mata_uang = "";
function addVariable(){
    $(document).ready(function(){
        $("#shippingVariablePrice").append("<tr><td><input type = 'text' class = 'form-control' name = 'variable[]'></td><td><input type = 'text' class = 'form-control' id ='biaya"+count+"' oninput = commas('biaya"+count+"') name = 'biaya[]'></td><td><input oninput = commas('kurs"+count+"') type = 'text' class = 'form-control' id ='kurs"+count+"' name = 'kurs[]'></td><td><input onfocus = 'countKurs("+count+")' type = 'text' class = 'form-control' id = 'total"+count+"' name = 'total[]'></td><td><select class = 'form-control' id ='matauang"+count+"' name = 'mata_uang[]'></select></td><td><button class = 'btn btn-sm btn-primary btn-danger' onclick = 'deleteRow(this)'>REMOVE</button></td></tr>");
        
        $.ajax({
            url:"<?php echo base_url();?>crm/vendor/getcurrency",
            data:{result:"html"},
            type:"POST",
            dataType:"JSON",
            success:function(respond){
                //alert(respond);
                $("#matauang"+count).html(respond);
            }
        });
    });
    count++;
}

function deleteRow(e,v) {
    var tr = e.parentElement.parentElement;
    var tbl = e.parentElement.parentElement.parentElement;
    tbl.removeChild(tr);
    count--;

}
</script>
