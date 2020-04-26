
<div class="panel-body col-lg-12">
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin="dataTable" style = "width:100%">
        <thead>
            <tr>
                <th>ID User</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>User Phone</th>
                <th>KPI</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($user); $a++):?>
            <tr class="gradeA">
                <td><?php echo $user[$a]["id_user"];?></td>
                <td><?php echo $user[$a]["nama_user"];?></td>
                <td><?php echo $user[$a]["email_user"];?></td>
                <td><?php echo $user[$a]["nohp_user"];?></td>
                <td>
                    <button class = "btn btn-outline btn-sm btn-primary" data-toggle = "modal" data-target = "#kpi<?php echo $a;?>">DETAIL KPI</button>
                    <div class = "modal fade" id = "kpi<?php echo $a;?>">
                        <div class = "modal-dialog modal-xl">
                            <div class ="modal-content">
                                <div class = "modal-header">
                                    <h4 class = "modal-title">KPI</h4>
                                </div>
                                <form action = "<?php echo base_url();?>report/kpi/insertKpi" method = "POST">
                                    <div class = "modal-body">
                                        <input type = "hidden" name = "id_user" value = "<?php echo $user[$a]["id_user"];?>">
                                        <table class = "table table-stripped table-bordered" style = "width:100%" data-plugin = "dataTable">
                                            <thead>
                                                <th>Add</th>
                                                <th>Delete</th>
                                                <th>KPI</th>
                                                <th>TARGET</th>
                                            </thead>
                                            <tbody>
                                                <?php for($b = 0; $b<count($user[$a]["kpi"]); $b++): ?>
                                                <tr>
                                                    <td>
                                                        <input type = "hidden" name = "id_kpi_user<?php echo $b;?>" value = "<?php echo $user[$a]["kpi"][$b]["id_kpi_user"];?>">
                                                        <div class = "checkbox-custom checkbox-primary">
                                                            <input type = "checkbox" value = "<?php echo $b?>" name = "check[]" <?php if($user[$a]["kpi"][$b]["status_aktif_kpi"] == 0) echo "checked";?>>
                                                            <label></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class = "checkbox-custom checkbox-primary">
                                                            <input type = "checkbox" value = "<?php echo $user[$a]["kpi"][$b]["id_kpi_user"];?>" name = "delete[]">
                                                            <label></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input value = "<?php echo $user[$a]["kpi"][$b]["kpi"]?>" type = "text" class = "form-control" name = "kpi<?php echo $b;?>">
                                                    </td>
                                                    <td>
                                                        <input value = "<?php echo $user[$a]["kpi"][$b]["target_kpi"]?>" type = "text" class = "form-control" name = "target<?php echo $b;?>">
                                                    </td>
                                                </tr>
                                                <?php endfor;?>
                                                <?php for($b = count($user[$a]["kpi"]); $b<10; $b++): ?>
                                                <tr>
                                                    <td>
                                                        <input type = "hidden" name = "id_kpi_user<?php echo $b;?>" value = "">
                                                        <div class = "checkbox-custom checkbox-primary">
                                                            <input type = "checkbox" value = "<?php echo $b?>" name = "check[]">
                                                            <label></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                        <input value = "" type = "text" class = "form-control" name = "kpi<?php echo $b;?>">
                                                    </td>
                                                    <td>
                                                        <input value = "" type = "text" class = "form-control" name = "target<?php echo $b;?>">
                                                    </td>
                                                </tr>
                                                <?php endfor;?>
                                            </tbody>
                                        </table>
                                        <div class ="form-group">
                                            <button type = "submit" class ="btn btn-primary btn-sm btn-outline">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>
    <a href = "<?php echo base_url();?>report/kpi" class = "btn btn-sm btn-primary">BACK</a>
</div>
