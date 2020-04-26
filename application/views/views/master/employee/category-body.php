
<div class="panel-body col-lg-12">
    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_user")) == 0):?>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-15">
                <button data-target="#TambahUser" data-toggle="modal" type="button" class="btn btn-outline btn-primary" type="button">Add Employee</button>
            </div>
        </div>
    </div>
    <?php endif;?>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin="dataTable">
        <thead>
            <tr>
                <th>ID User</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>User Phone</th>
                <th>User Type</th>
                <th style = "width:5%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($employee);$a++): ?> 
            <tr class="gradeA">
                <td><?php echo $employee[$a]["id_user"];?></td>
                <td><?php echo $employee[$a]["nama_user"];?></td>
                <td><?php echo $employee[$a]["email_user"]?></td>
                <td><?php echo $employee[$a]["nohp_user"];?></td>
                <td><?php echo $employee[$a]["jenis_user"];?></td>
                <td class="actions">
                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "edit_user")) == 0):?>
                    <button type="button" data-target = "#DetailUser<?php echo $employee[$a]["id_user"];?>" data-toggle="modal" class="btn btn-outline btn-primary col-lg-12 btn-sm" type="button">EDIT</button>
                    <?php endif;?>

                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "delete_user")) == 0):?>
                    <a href = "<?php echo base_url();?>master/user/employee/delete/<?php echo $employee[$a]["id_user"];?>" class="btn btn-outline btn-danger col-lg-12 btn-sm" data-toggle="tooltip">DELETE</a>
                    <?php endif;?>
                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "edit_user")) == 0):?>
                    <button class="btn btn-outline btn-success col-lg-12 btn-sm" data-toggle="modal" data-target="#Privilege<?php echo $employee[$a]["id_user"];?>">PRIVILEGE</button>
                    <?php endif;?>
                </td>
            </tr>
            <!-- here goes modal -->
            <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "edit_user")) == 0):?>
            <div class="modal fade" id="DetailUser<?php echo $employee[$a]["id_user"];?>" aria-hidden="true" aria-labelledby="DaftarUser" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-simple">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="exampleModalTabs">EMPLOYEE EDIT</h4>
                        </div>

                        <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                            <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab"  href="#primaryData<?php echo $employee[$a]["id_user"];?>"  aria-controls="primaryData<?php echo $employee[$a]["id_user"];?>" role="tab">Primary Data</a></li>
                        </ul>
                        <div class="modal-body">
                            <form action = "<?php echo base_url();?>master/user/employee/editemployee" method = "post">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="primaryData<?php echo $employee[$a]["id_user"];?>" role="tabpanel">
                                        <input type = "hidden" name = "id_user" value = "<?php echo $employee[$a]["id_user"];?>">
                                        <div class = "form-group">
                                            <h4 class="example-title">Full Name</h4>
                                            <input type="text" name = "nama_user" class="form-control" id="inputHelpText" required value = "<?php echo $employee[$a]["nama_user"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <h4 class="example-title">Email</h4>
                                            <input type="text" name = "email_user" class="form-control" id="inputHelpText" required value = "<?php echo $employee[$a]["email_user"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <h4 class="example-title">No HP User</h4>
                                            <input type="text" name = "nohp_user" class="form-control" id="inputHelpText" required value = "<?php echo $employee[$a]["nohp_user"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <h4 class="example-title">Override Password</h4>
                                            <input type="text" name = "password" class="form-control" id="inputHelpText" required value = "-">
                                        </div>
                                        <div class = "form-group">
                                            <h5 class ="example-title">User Type</h5>
                                            <select class = "form-control" name = "jenis_user">
                                                <option value = "USER">USER</option>
                                                <option value = "SALES" <?php if($employee[$a]["jenis_user"] == "SALES") echo "selected";?>>SALES</option>
                                            </select>
                                        </div>
                                        <div class = "form-group">
                                            <div class = "col-md-12 col-lg-12">
                                                <button type = "submit" class = "btn btn-primary btn-outline col-lg-2 col-md-12">SUBMIT</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <!-- End Modal -->
            <?php endfor; ?>
        </tbody>
    </table>
</div>


<?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "edit_user")) == 0):?>
<?php for($a = 0; $a<count($employee);$a++): ?> 
<div class="modal fade" id="Privilege<?php echo $employee[$a]["id_user"];?>" aria-hidden="true" aria-labelledby="Privilege" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTabs">EMPLOYEE PRIVILEGE</h4>
            </div>

            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab"  href="#primaryData<?php echo $employee[$a]["id_user"];?>"  aria-controls="primaryData<?php echo $employee[$a]["id_user"];?>" role="tab">Primary Data</a></li>
            </ul>
            <div class="modal-body">
                
                <form action = "<?php echo base_url();?>master/user/employee/editprivilege/<?php echo $employee[$a]["id_user"];?>" method = "post">
                    <div class="tab-content">
                        <div class="tab-pane active" id="privilege<?php echo $employee[$a]["id_user"];?>" role="tabpanel">
                            <table class = "table table-striped table-hover table-bordered">
                                <thead>
                                    <th>Subject</th>
                                    <th>Menu Access</th>
                                    <th>Create</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    <th>View</th>
                                    <th>View All</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo strtoupper("Dashboard Main") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "main_dashboard")) == 0) echo "checked"; ?> value = "main_dashboard">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("Dashboard Order Processing") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "crm_dashboard")) == 0) echo "checked"; ?> value = "crm_dashboard">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("Dashboard Finance") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "finance_dashboard")) == 0) echo "checked"; ?> value = "finance_dashboard">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("Dashboard Personal") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "user_dashboard")) == 0) echo "checked"; ?> value = "user_dashboard">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("product") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "product")) == 0) echo "checked"; ?> value = "product">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_product")) == 0) echo "checked"; ?> value = "insert_product">
                                                <label></label>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "update_product")) == 0) echo "checked"; ?> value = "update_product">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_product")) == 0) echo "checked"; ?> value = "delete_product">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_product")) == 0) echo "checked"; ?> value = "view_created_product">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_product")) == 0) echo "checked"; ?> value = "view_all_product">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("customer") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "customer")) == 0) echo "checked"; ?> value = "customer">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_customer")) == 0) echo "checked"; ?> value = "insert_customer">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_customer")) == 0) echo "checked"; ?> value = "edit_customer">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_customer")) == 0) echo "checked"; ?> value = "delete_customer">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_customer")) == 0) echo "checked"; ?> value = "view_created_customer">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_customer")) == 0) echo "checked"; ?> value = "view_all_customer">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php if(false):?>
                                    <tr>
                                        <td><?php echo strtoupper("uom") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "uom")) == 0) echo "checked"; ?> value = "uom">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_uom")) == 0) echo "checked"; ?> value = "insert_uom">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_uom")) == 0) echo "checked"; ?> value = "edit_uom">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_uom")) == 0) echo "checked"; ?> value = "delete_uom">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_uom")) == 0) echo "checked"; ?> value = "view_created_uom">
                                                <label></label>
                                            </div>
                                        </td>                                        
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_uom")) == 0) echo "checked"; ?> value = "view_all_uom">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endif;?>
                                    <tr>
                                        <td><?php echo strtoupper("expanses") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "expanses")) == 0) echo "checked"; ?> value = "expanses">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_expanses")) == 0) echo "checked"; ?> value = "insert_expanses">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_expanses")) == 0) echo "checked"; ?> value = "edit_expanses">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_expanses")) == 0) echo "checked"; ?> value = "delete_expanses">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_expanses")) == 0) echo "checked"; ?> value = "view_created_expanses">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_expanses")) == 0) echo "checked"; ?> value = "view_all_expanses">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("supplier") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "supplier")) == 0) echo "checked"; ?> value = "supplier">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_supplier")) == 0) echo "checked"; ?> value = "insert_supplier">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_supplier")) == 0) echo "checked"; ?> value = "edit_supplier">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_supplier")) == 0) echo "checked"; ?> value = "delete_supplier">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_supplier")) == 0) echo "checked"; ?> value = "view_created_supplier">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_supplier")) == 0) echo "checked"; ?> value = "view_all_supplier">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("shipping") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "shipping")) == 0) echo "checked"; ?> value = "shipping">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_shipping")) == 0) echo "checked"; ?> value = "insert_shipping">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_shipping")) == 0) echo "checked"; ?> value = "edit_shipping">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_shipping")) == 0) echo "checked"; ?> value = "delete_shipping">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_shipping")) == 0) echo "checked"; ?> value = "view_created_shipping">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_shipping")) == 0) echo "checked"; ?> value = "view_all_shipping">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("user") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "user")) == 0) echo "checked"; ?> value = "user">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_user")) == 0) echo "checked"; ?> value = "insert_user">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_user")) == 0) echo "checked"; ?> value = "edit_user">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_user")) == 0) echo "checked"; ?> value = "delete_user">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_user")) == 0) echo "checked"; ?> value = "view_created_user">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_user")) == 0) echo "checked"; ?> value = "view_all_user">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("rfq") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "rfq")) == 0) echo "checked"; ?> value = "rfq">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_rfq")) == 0) echo "checked"; ?> value = "insert_rfq">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_rfq")) == 0) echo "checked"; ?> value = "edit_rfq">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_rfq")) == 0) echo "checked"; ?> value = "delete_rfq">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_rfq")) == 0) echo "checked"; ?> value = "view_created_rfq">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_rfq")) == 0) echo "checked"; ?> value = "view_all_rfq">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("quotation") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "quotation")) == 0) echo "checked"; ?> value = "quotation">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_quotation")) == 0) echo "checked"; ?> value = "insert_quotation">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_quotation")) == 0) echo "checked"; ?> value = "edit_quotation">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_quotation")) == 0) echo "checked"; ?> value = "delete_quotation">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_quotation")) == 0) echo "checked"; ?> value = "view_created_quotation">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_quotation")) == 0) echo "checked"; ?> value = "view_all_quotation">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("oc") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "oc")) == 0) echo "checked"; ?> value = "oc">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_oc")) == 0) echo "checked"; ?> value = "insert_oc">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_oc")) == 0) echo "checked"; ?> value = "edit_oc">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_oc")) == 0) echo "checked"; ?> value = "delete_oc">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_oc")) == 0) echo "checked"; ?> value = "view_created_oc">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_oc")) == 0) echo "checked"; ?> value = "view_all_oc">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("po") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "po")) == 0) echo "checked"; ?> value = "po">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_po")) == 0) echo "checked"; ?> value = "insert_po">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_po")) == 0) echo "checked"; ?> value = "edit_po">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_po")) == 0) echo "checked"; ?> value = "delete_po">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_po")) == 0) echo "checked"; ?> value = "view_created_po">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_po")) == 0) echo "checked"; ?> value = "view_all_po">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("od") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "od")) == 0) echo "checked"; ?> value = "od">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_od")) == 0) echo "checked"; ?> value = "insert_od">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_od")) == 0) echo "checked"; ?> value = "edit_od">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_od")) == 0) echo "checked"; ?> value = "delete_od">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_od")) == 0) echo "checked"; ?> value = "view_created_od">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_od")) == 0) echo "checked"; ?> value = "view_all_od">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("receivable") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "receivable")) == 0) echo "checked"; ?> value = "receivable">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_receivable")) == 0) echo "checked"; ?> value = "insert_receivable">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_receivable")) == 0) echo "checked"; ?> value = "edit_receivable">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_receivable")) == 0) echo "checked"; ?> value = "delete_receivable">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_receivable")) == 0) echo "checked"; ?> value = "view_created_receivable">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_receivable")) == 0) echo "checked"; ?> value = "view_all_receivable">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("payable") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "payable")) == 0) echo "checked"; ?> value = "payable">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_payable")) == 0) echo "checked"; ?> value = "insert_payable">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_payable")) == 0) echo "checked"; ?> value = "edit_payable">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_payable")) == 0) echo "checked"; ?> value = "delete_payable">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_payable")) == 0) echo "checked"; ?> value = "view_created_payable">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_payable")) == 0) echo "checked"; ?> value = "view_all_payable">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("reimburse") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "reimburse")) == 0) echo "checked"; ?> value = "reimburse">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_reimburse")) == 0) echo "checked"; ?> value = "insert_reimburse">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                             <!--
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_reimburse")) == 0) echo "checked"; ?> value = "edit_reimburse">
                                                <label></label>
                                            </div>
-->
                                        </td>
                                         <td>
                                             <!--
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_reimburse")) == 0) echo "checked"; ?> value = "delete_reimburse">
                                                <label></label>
                                            </div> -->
                                        </td>
                                         <td>
                                             <!--
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_reimburse")) == 0) echo "checked"; ?> value = "view_created_reimburse">
                                                <label></label>
                                            </div> -->
                                        </td>
                                         <td>
                                             <!--
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_reimburse")) == 0) echo "checked"; ?> value = "view_all_reimburse">
                                                <label></label>
                                            </div> -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("margin") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "margin")) == 0) echo "checked"; ?> value = "margin">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_margin")) == 0) echo "checked"; ?> value = "insert_margin">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                             <?php if(false):?>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_margin")) == 0) echo "checked"; ?> value = "edit_margin">
                                                <label></label>
                                            </div>
                                            <?php endif;?>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_margin")) == 0) echo "checked"; ?> value = "delete_margin">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td></td>
                                         <td></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("ppn") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "ppn")) == 0) echo "checked"; ?> value = "ppn">
                                                <label></label>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("pph23") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "pph23")) == 0) echo "checked"; ?> value = "pph23">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("pib") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "pib")) == 0) echo "checked"; ?> value = "pib">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_pib")) == 0) echo "checked"; ?> value = "insert_pib">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_pib")) == 0) echo "checked"; ?> value = "edit_pib">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_pib")) == 0) echo "checked"; ?> value = "delete_pib">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                             <?php if(false):?>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_pib")) == 0) echo "checked"; ?> value = "view_created_pib">
                                                <label></label>
                                            </div>
                                            <?php endif;?>
                                        </td>
                                         <td>
                                             <?php if(false):?>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_pib")) == 0) echo "checked"; ?> value = "view_all_pib">
                                                <label></label>
                                            </div>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("petty") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "petty")) == 0) echo "checked"; ?> value = "petty">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_petty")) == 0) echo "checked"; ?> value = "insert_petty">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_petty")) == 0) echo "checked"; ?> value = "edit_petty">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_petty")) == 0) echo "checked"; ?> value = "delete_petty">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_petty")) == 0) echo "checked"; ?> value = "view_created_petty">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_petty")) == 0) echo "checked"; ?> value = "view_all_petty">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("kpi") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "kpi")) == 0) echo "checked"; ?> value = "kpi">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <?php if(false):?>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_kpi")) == 0) echo "checked"; ?> value = "insert_kpi">
                                                <label></label>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                         <td>
                                            <?php if(false):?>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_kpi")) == 0) echo "checked"; ?> value = "edit_kpi">
                                                <label></label>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                         <td>
                                            <?php if(false):?>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_kpi")) == 0) echo "checked"; ?> value = "delete_kpi">
                                                <label></label>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                         <td>
                                            <?php if(false):?>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_kpi")) == 0) echo "checked"; ?> value = "view_created_kpi">
                                                <label></label>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                         <td>
                                            <?php if(false):?>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_kpi")) == 0) echo "checked"; ?> value = "view_all_kpi">
                                                <label></label>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("report") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "report")) == 0) echo "checked"; ?> value = "report">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_report")) == 0) echo "checked"; ?> value = "insert_report">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_report")) == 0) echo "checked"; ?> value = "edit_report">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_report")) == 0) echo "checked"; ?> value = "delete_report">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_report")) == 0) echo "checked"; ?> value = "view_created_report">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_report")) == 0) echo "checked"; ?> value = "view_all_report">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("Visit/Call") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "visit")) == 0) echo "checked"; ?> value = "visit">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "insert_visit")) == 0) echo "checked"; ?> value = "insert_visit">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "edit_visit")) == 0) echo "checked"; ?> value = "edit_visit">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "delete_visit")) == 0) echo "checked"; ?> value = "delete_visit">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_created_visit")) == 0) echo "checked"; ?> value = "view_created_visit">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "view_all_visit")) == 0) echo "checked"; ?> value = "view_all_visit">
                                                <label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo strtoupper("order history") ?></td>
                                        <td>
                                            <div class = "checkbox-custom checkbox-primary">
                                                <input type = "checkbox" name = "privileges[]" <?php if(isExistsInTable("privilage", array("id_user" => $employee[$a]["id_user"],"id_menu" => "history")) == 0) echo "checked"; ?> value = "history">
                                                <label></label>
                                            </div>
                                        </td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr/>
                            <div class = "form-group">
                                <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endfor; ?>
<?php endif;?>
<!-- add user modal -->
<?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_user")) == 0)
:?>
<div class="modal fade" id="TambahUser" aria-hidden="true" aria-labelledby="DaftarUser" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTabs">User Data</h4>
            </div>

            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#primaryData"
                    aria-controls="primaryData" role="tab">Primary Data</a></li>
            </ul>
            <form action = "<?php echo base_url();?>master/user/employee/register" method = "post">    
                <div class="modal-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="primaryData" role="tabpanel">
                            <?php
                            $title = array(
                                "Full Name",
                                "Email",
                                "Mobile Number",
                                "password"
                            );
                            $type = array(
                                "text",
                                "email",
                                "text",
                                "password"
                            );
                            $name = array(
                                "nama_user",
                                "email_user",
                                "nohp_user",
                                "password"
                            );
                            $help = array(
                                "Please capitalize each word ex: Firstname Lastname",
                                "Use the proper email format username@example.com. Email will be used for login and CRM",
                                "Active mobile phone",
                                "Default password:123456"
                            );
                            $value = array(
                                "",
                                "",
                                "",
                                "12345612345",
                            );
                            $placeholder = array(
                                "Full Name",
                                "username@example.com",
                                "089612345678",
                                ""
                            );
                            ?>
                            <?php for($a = 0; $a<count($help); $a++){ ?>
                            <div class = "form-group">
                                <div class="col-md-12 col-lg-12">
                                    <!-- Example With Help -->
                                    <h4 class="example-title"><?php echo $title[$a];?></h4>
                                    <input type="<?php echo $type[$a];?>" name = "<?php echo $name[$a];?>" class="form-control" id="inputHelpText" placeholder = "<?php echo $placeholder[$a];?>" required value = "<?php echo $value[$a];?>">
                                    <span class="text-help"><?php echo $help[$a];?></span>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                            <div class = "form-group">
                                <div class="col-md-12 col-lg-12">
                                    <!-- Example With Help -->
                                    <h4 class="example-title">User Type</h4>
                                    <select class = "form-control" name = "jenis_user">
                                        <option value = "USER">USER</option>
                                        <option value = "SALES">SALES</option>
                                        <option value = "LABOR">LABOR</option>
                                    </select>
                                    <span class="text-help">User Type</span>
                                </div>
                            </div>
                            <div class = "form-group">
                                <div class = "col-md-12 col-lg-12">
                                    <input type = "submit" class = "btn btn-sm btn-outline btn-primary">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif;?>
<!-- end add employee modal -->

