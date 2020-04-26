<div class="panel-body col-lg-12">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-15">
            <button data-target="#addUom" data-toggle="modal" type="button" class="btn btn-outline btn-primary" type="button">
                <i class="icon wb-plus" aria-hidden="true"></i> Add Catalog
            </button>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
        <thead>
            <tr>
                <th>ID Unit of Measure</th>
                <th>Unit of Measure</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($uom); $a++): ?>
            <tr>
                <td><?php echo $uom[$a]["id_satuan"];?></td>
                <td><?php echo $uom[$a]["nama_satuan"];?></td>
                <td class="actions">
                    
                    <button data-target="#editModal<?php echo $uom[$a]["id_satuan"];?>" data-toggle="modal" type="button" class="btn btn-outline btn-primary" type="button"><i class="icon wb-edit" aria-hidden="true"></i></button>

                    <div class="modal fade" id="editModal<?php echo $uom[$a]["id_satuan"];?>" aria-hidden="true" aria-labelledby="AddCatalog" role="dialog" tabindex="-1">
                        <div class="modal-dialog modal-simple modal-center">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Edit UOM Data</h4>
                                </div>
                                <form action = "<?php echo base_url();?>master/uom/edit/<?php echo $uom[$a]["id_satuan"];?>" method="post">
                                    <div class="modal-body">
                                        <div class = "form-group">
                                            <h5>UOM</h5>
                                            <input type = "text" class = "form-control" name = "nama_satuan" value = "<?php echo $uom[$a]["nama_satuan"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <button type = "submit" class = "btn btn-primary btn-outline">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <a href = "<?php echo base_url();?>master/uom/delete/<?php echo $uom[$a]["id_satuan"];?>" class="btn btn-outline btn-danger"
                    data-toggle="tooltip"><i class="icon wb-trash" aria-hidden="true"></i></a>
                    
                </td>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="addUom" aria-hidden="true" aria-labelledby="AddCatalog" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-center">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Add UOM Data</h4>
            </div>
            <form action = "<?php echo base_url();?>master/uom/insert" method="post">
                <div class="modal-body">
                    <div class = "form-group">
                        <h5>UOM</h5>
                        <input type = "text" class = "form-control" name = "nama_satuan">
                    </div>
                    <div class = "form-group">
                        <button type = "submit" class = "btn btn-primary btn-outline">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
