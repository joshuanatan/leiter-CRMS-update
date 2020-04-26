<div class="panel-body col-lg-12">
    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_expanses")) == 0):?>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-15">
                <button data-target="#addItem" data-toggle="modal" type="button" class="btn btn-outline btn-primary btn-sm" type="button"> Add Finance Report Category </button>
            </div>
        </div>
    </div>
    <?php endif;?>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Type Code</th> <!-- bank / cash -->
                <th>Type Name</th> <!-- income / expanses -->
                <th>Type Status</th>
                <th style = "width:5%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($finance_type); $a++): ?>
            <tr class="gradeA">
                <td><?php echo ($a+1);?></td>
                <td><?php echo $finance_type[$a]["kode_type"];?></td>
                <td><?php echo $finance_type[$a]["name_type"];?></td>
                <td>
                    <?php if($finance_type[$a]["status_type"] == 0):?>
                    <button class = "btn btn-outline btn-primary btn-sm">ACTIVE</button>
                    <?php else:?>
                    <button class = "btn btn-outline btn-danger btn-sm">NOT ACTIVE</button>
                    <?php endif;?>
                </td>
                <td class="actions">
                    <?php if($finance_type[$a]["is_patent"] == 1):?>

                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "edit_expanses")) == 0):?>
                    <button data-target="#editModal<?php echo $a;?>" data-toggle="modal" type="button" class="btn btn-outline btn-primary btn-sm col-lg-12" type="button">EDIT</button>
                    <?php endif;?>
                    
                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "delete_expanses")) == 0):?>
                    <a href = "<?php echo base_url();?>master/expanses/delete/<?php echo $finance_type[$a]["id_type"];?>" class="btn btn-outline btn-danger btn-sm col-lg-12" data-toggle="tooltip">DELETE</a>
                    <?php endif;?>

                    <?php endif;?>

                    <div class="modal fade" id="editModal<?php echo $a;?>" aria-hidden="true" aria-labelledby="AddCatalog" role="dialog" tabindex="-1">
                        <div class="modal-dialog modal-simple modal-center">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Edit Finance Report Category Data</h4>
                                </div>
                                <form action = "<?php echo base_url();?>master/expanses/edit/<?php echo $finance_type[$a]["id_type"];?>" method="post">
                                    <div class="modal-body">
                                        <div class = "form-group">
                                            <h5>Type Name</h5>
                                            <input type = "text" class = "form-control" name = "name_type" value = "<?php echo $finance_type[$a]["name_type"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5>Type Code</h5>
                                            <input type = "text" class = "form-control" name = "kode_type" value = "<?php echo $finance_type[$a]["kode_type"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <button type = "submit" class = "btn btn-primary btn-outline">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </td>
            </tr>
                <?php endfor;?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="addItem" aria-hidden="true" aria-labelledby="AddCatalog" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-center">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Add Finance Report Category Data</h4>
            </div>
            <form action = "<?php echo base_url();?>master/expanses/insert" method="post">
                <div class="modal-body">
                    <div class = "form-group">
                        <h5>Type Name</h5>
                        <input type = "text" class = "form-control" name = "name_type">
                    </div>
                    <div class = "form-group">
                        <h5>Type Code</h5>
                        <input type = "text" class = "form-control" name = "kode_type">
                    </div>
                    <div class = "form-group">
                        <button type = "submit" class = "btn btn-primary btn-outline">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
