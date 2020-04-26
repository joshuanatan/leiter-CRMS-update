<div class="panel-body col-lg-12">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-15">
            <button data-target="#AddCustomer" data-toggle="modal" type="button" class="btn btn-sm btn-outline btn-primary" type="button">
                <i class="icon wb-plus" aria-hidden="true"></i> Add Contact Person
            </button>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
        <thead>
            <tr>
                <th>CP Name</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Mobile Number</th>
                <th>Position</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($cp->result() as $a): ?>
            <tr class="gradeA">
                <td><?php echo ucwords($a->nama_cp);?></td>
                <td><?php echo $a->jk_cp;?></td>
                <td><?php echo strtolower($a->email_cp);?></td>
                <td><?php echo $a->nohp_cp;?></td>
                <td><?php echo strtoupper($a->jabatan_cp);?></td>
                <td class="actions">
                    
                    <button type ="button" data-target="#editCustomer<?php echo $a->id_cp;?>" data-toggle="modal" class="btn btn-outline btn-primary" ><i class="icon wb-edit"></i></button>

                    <?php if($is_last == 1):?>
                    <a href = "<?php echo base_url();?>master/vendor/product/removecp/<?php echo $a->id_cp;?>/<?php echo $id_perusahaan;?>" class="btn btn-outline btn-danger"
                    data-toggle="tooltip"><i class="icon wb-trash" aria-hidden="true"></i></a>
                    <?php endif;?>
                </td>
            </tr>
            <div class="modal fade" id="editCustomer<?php echo $a->id_cp;?>" aria-hidden="true" aria-labelledby="DaftarUser" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-simple">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="exampleModalTabs">Contact Person Data</h4>
                        </div>

                        <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                            <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#privilage"
                                aria-controls="privilage" role="tab">Contact Person</a></li>
                        </ul>
                        <form action = "<?php echo base_url();?>master/vendor/product/editcp" method = "post">    
                            <div class="modal-body">
                                <div class="tab-content">
                                    
                                    <div class="tab-pane active" id="privilage" role="tabpanel">
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Nama PIC</h5>
                                            <input type = "text" class ="form-control" value = "<?php echo ucwords($a->nama_cp);?>" name = "nama_cp">
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Gender PIC</h5>
                                            <select class = "form-control" name = "jk_cp" data-plugin = "select2">
                                                <option value = "Mr">Mr</option>
                                                <option value = "Ms" <?php if($a->jk_cp == "Ms") echo "selected"; ?>>Ms</option>
                                                <option value = "Mrs" <?php if($a->jk_cp == "Mrs") echo "selected"; ?>>Mrs</option>
                                            </select>
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Email PIC</h5>
                                            <input type = "text" class = "form-control" value = "<?php echo $a->email_cp;?>" name = "email_cp">
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">No HP PIC</h5>
                                            <input type = "text" class = "form-control" value = "<?php echo $a->nohp_cp;?>" name = "nohp_cp">
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Jabatan PIC</h5>
                                            <input type = "text" class = "form-control" value = "<?php echo $a->jabatan_cp;?>" name = "jabatan_cp">
                                        </div>
                                        <input type = "hidden" name = "id_perusahaan" value = "<?php echo $id_perusahaan ?>">
                                        <input type = "hidden" name = "id_cp" value = "<?php echo $a->id_cp ?>">
                                        <button class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </tbody>
    </table>
        <a href = "<?php echo base_url();?>master/vendor/product" class = "btn btn-sm btn-primary btn-outline">BACK</a>
</div>
<div class="modal fade" id="AddCustomer" aria-hidden="true" aria-labelledby="DaftarUser" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTabs">PIC Data</h4>
            </div>

            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#privilage"
                    aria-controls="privilage" role="tab">Contact Person</a></li>
            </ul>
            <form action = "<?php echo base_url();?>master/vendor/product/registercp" method = "post">    
                <div class="modal-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="privilage" role="tabpanel">
                            <div class = "form-group">
                                <h5 style = "opacity:0.5">Nama PIC</h5>
                                <input type = "text" class ="form-control" name = "nama_cp">
                            </div>
                            <div class = "form-group">
                                <h5 style = "opacity:0.5">Gender PIC</h5>
                                <select class = "form-control" name = "jk_cp" data-plugin = "select2">
                                    <option value = "Mr">Mr</option>
                                    <option value = "Ms">Ms</option>
                                    <option value = "Mrs">Mrs</option>
                                </select>
                            </div>
                            <div class = "form-group">
                                <h5 style = "opacity:0.5">Email PIC</h5>
                                <input type = "text" class = "form-control" name = "email_cp">
                            </div>
                            <div class = "form-group">
                                <h5 style = "opacity:0.5">No HP PIC</h5>
                                <input type = "text" class = "form-control" name = "nohp_cp">
                            </div>
                            <div class = "form-group">
                                <h5 style = "opacity:0.5">Jabatan PIC</h5>
                                <input type = "text" class = "form-control" name = "jabatan_cp">
                            </div>
                            <input type = "hidden" name = "id_perusahaan" value = "<?php echo $id_perusahaan ?>">
                            <button class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>