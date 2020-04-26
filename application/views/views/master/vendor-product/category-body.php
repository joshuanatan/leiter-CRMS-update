<div class="panel-body col-lg-12">
    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_supplier")) == 0):?>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-15">
            <button data-target="#AddSupplier" data-toggle="modal" type="button" class="btn btn-sm btn-outline btn-primary" type="button">
                <i class="icon wb-plus" aria-hidden="true"></i> Add Supplier
            </button>
            </div>
        </div>
    </div>
    <?php endif;?>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
        <thead>
            <tr>
                <th>Company ID</th>
                <th>Company Name</th>
                <th>Company Address</th>
                <th>Company Phone</th>
                <th>Main Contact Person</th>
                <th>CP Email / Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($perusahaan); $a++): ?> 
            <tr class="gradeA">
                <td><?php echo $perusahaan[$a]["no_urut"];?></td>
                <td><?php echo $perusahaan[$a]["nama_perusahaan"];?></td>
                <td><?php echo nl2br($perusahaan[$a]["alamat_perusahaan"]);?></td>
                <td><?php echo $perusahaan[$a]["notelp_perusahaan"];?></td>
                <td><?php echo $perusahaan[$a]["nama_cp"];?></td>
                <td><?php echo $perusahaan[$a]["email_cp"]."<br/>".$perusahaan[$a]["nohp_cp"];?></td>
                <td class="actions">
                    
                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "edit_supplier")) == 0):?>
                    <a href = "<?php echo base_url();?>master/vendor/product/contact/<?php echo $perusahaan[$a]["id_perusahaan"];?>" class="btn btn-sm col-lg-12 btn-outline btn-success"
                    data-toggle="tooltip">PIC</a>
                    
                    <a href = "<?php echo base_url();?>master/vendor/product/edit/<?php echo $perusahaan[$a]["id_perusahaan"];?>" class="btn btn-sm col-lg-12 btn-outline btn-primary" >EDIT</a>
                    <?php endif;?>
                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "delete_supplier")) == 0):?>
                    <a href = "<?php echo base_url();?>master/vendor/product/delete/<?php echo $perusahaan[$a]["id_perusahaan"];?>" class="btn btn-sm col-lg-12 btn-outline btn-danger"
                    data-toggle="tooltip">REMOVE</a>
                    <?php endif;?>
                    
                </td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>
<?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_supplier")) == 0):?>
<div class="modal fade" id="AddSupplier" aria-hidden="true" aria-labelledby="DaftarUser" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTabs">Supplier Data</h4>
            </div>

            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#primaryData"
                    aria-controls="primaryData" role="tab">Primary Data</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#privilage"
                    aria-controls="privilage" role="tab">Contact Person</a></li>
            </ul>
            <form action = "<?php echo base_url();?>master/vendor/product/register" method = "post">    
                <div class="modal-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="primaryData" role="tabpanel">
                            <input type = "hidden" name = "no_urut" value = "<?php echo $maxId;?>">
                            <div class = "form-group">
                                <h5 style = "opacity:0.5">Nama Supplier</h5>
                                <input type = "text" class = "form-control" name = "nama_perusahaan">
                            </div>
                            <div class = "form-group">
                                <h5 style = "opacity:0.5">No Fax Supplier</h5>
                                <input type = "text" class = "form-control" name = "nofax_perusahaan">
                            </div>
                            <div class = "form-group">
                                <h5 style = "opacity:0.5">No Telp Supplier</h5>
                                <input type = "text" class = "form-control" name = "notelp_perusahaan">
                            </div>
                            <div class = "form-group">
                                <h5 style = "opacity:0.5">Alamat Perusahaan</h5>
                                <textarea class = "form-control" name = "alamat_perusahaan" rows = "5"></textarea>
                            </div>
                        </div>
                        <div class="tab-pane" id="privilage" role="tabpanel">
                            <div class = "form-group">
                                <h5 style = "opacity:0.5">Nama PIC</h5>
                                <input type = "text" class = "form-control" name = "nama_cp">
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
                            <button class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif;?>