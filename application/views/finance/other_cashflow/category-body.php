<div class="panel-body col-lg-12">
<?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_margin")) == 0):?>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-15">
                <button class="btn btn-outline btn-primary btn-sm" data-toggle = "modal" data-target = "#insertPetty">
                    <i class="icon wb-plus" aria-hidden="true"></i> Insert Transaction
                </button>
            </div>
        </div>
    </div>
<?php endif;?>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
        <thead>
            <tr>
                <th>Subject Transaksi</th>
                <th>Tipe Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Nominal Transaksi</th>
                <th>Attachment</th>
                <th>Jenis Pembayaran</th>
                <th>Notes</th>
                <th>Nama User Input</th> 
                <th>Last Update Date</th> <!-- catetan aja seperti nomor rekening, dsb -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($cashflow); $a++):?>
            <tr>
                <td><?php echo $cashflow[$a]["subject_tagihan"];?></td>
                <td><?php echo $cashflow[$a]["name_type"];?></td>
                <td><?php $date = date_create($cashflow[$a]["tanggal_pembayaran"]); echo date_format($date, "D d-m-Y");?></td>
                <td><?php if($cashflow[$a]["jenis_pembayaran"] == 0) echo "-";?><?php echo number_format($cashflow[$a]["nominal_tagihan"],2);?></td>
                <td><a target = "_blank" href = "<?php echo base_url();?>assets/dokumen/othercashflow/<?php echo $cashflow[$a]["attachment"];?>" class = "btn btn-primary btn-sm">ATTACHMENT</a></td>
                <td><?php if($cashflow[$a]["jenis_pembayaran"] == 0) echo "TRANSAKSI KELUAR"; else echo "TRANSAKSI MASUK";?></td>
                <td><?php echo nl2br($cashflow[$a]["notes"]);?></td>
                <td><?php echo ucwords($cashflow[$a]["nama_user"]);?></td>
                <td><?php $date = date_create($cashflow[$a]["tgl_input_transaksi"]); echo date_format($date, "D d-m-Y");?></td>
                <td>
                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "edit_margin")) == 0):?>
                    <button type = "button" class = "btn btn-primary btn-sm col-lg-12" data-toggle="modal" data-target = "#editCashflow<?php echo $a;?>">EDIT</button>
                    <?php endif;?>
                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "delete_margin")) == 0):?>
                    <button type = "button" class = "btn btn-danger btn-sm col-lg-12" data-toggle="modal" data-target = "#konfirmasiDelete<?php echo $a;?>"> DELETE</button>
                    <?php endif;?>
                </td>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
</div>
<div class = "modal fade" id = "insertPetty">
    <div class = "modal-dialog modal-xl">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class ="modal-title">INSERT TRANSACTION</h4>
            </div>
            <div class = "modal-body">
                <form action = "<?php echo base_url();?>finance/othercashflow/insert" enctype = "multipart/form-data" method = "post">
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Subject Transaksi</h5>
                        <input required type = "text" class = "form-control" name = "subject_tagihan">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Kategori Transaksi</h5>
                        <select data-plugin = "select2" class = "form-control" name = "id_type">
                            <?php for($a = 0; $a<count($expanses_type); $a++):?>
                            <option value = "<?php echo $expanses_type[$a]["id_type"];?>"><?php echo $expanses_type[$a]["name_type"];?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Nominal Transaksi</h5>
                        <input required id = "nominal_tagihan" type = "text" class = "form-control" name = "nominal_tagihan" oninput = "commas('nominal_tagihan')">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Tanggal Transaksi</h5>
                        <input required type = "date" class = "form-control" name = "tanggal_pembayaran">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Attachment</h5>
                        <input type = "file" name = "attachment">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Notes Transaksi</h5>
                        <textarea class = "form-control" rows = "5" name = "notes"></textarea>
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Kategori Transaksi</h5>
                        <select class = "form-control" name = "jenis_pembayaran">
                            <option value = "1">Transaksi Uang Masuk</option>
                            <option value = "0" selected>Transaksi Uang Keluar</option>
                        </select>
                    </div>
                    <div class = "form-group">
                        <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php for($a = 0; $a<count($cashflow); $a++):?>
<div class = "modal fade" id = "editCashflow<?php echo $a;?>">
    <div class = "modal-dialog modal-xl">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class ="modal-title">EDIT TRANSACTION</h4>
            </div>
            <div class = "modal-body">
                <form action = "<?php echo base_url();?>finance/othercashflow/update" enctype = "multipart/form-data" method = "post">
                    <input type = "hidden" name = "id_submit_tagihan_other" value = "<?php echo $cashflow[$a]["id_submit_tagihan_other"];?>">
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Subject Transaksi</h5>
                        <input value = "<?php echo $cashflow[$a]["subject_tagihan"] ?>" type = "text" class = "form-control" name = "subject_tagihan">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Kategori Transaksi</h5>
                        <select data-plugin = "select2" class = "form-control" name = "id_type">
                            <?php for($b = 0; $b<count($expanses_type); $b++):?>
                            <option <?php if($expanses_type[$b]["id_type"] == $cashflow[$a]["id_type"]) echo "selected"; ?> value = "<?php echo $expanses_type[$b]["id_type"];?>"><?php echo $expanses_type[$b]["name_type"];?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Nominal Transaksi</h5>
                        <input value = "<?php echo number_format($cashflow[$a]["nominal_tagihan"],2);?>" id = "nominal_tagihan<?php echo $a;?>" type = "text" class = "form-control" name = "nominal_tagihan" oninput = "commas('nominal_tagihan<?php echo $a;?>')">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Tanggal Transaksi</h5>
                        <input value = "<?php echo $cashflow[$a]["tanggal_pembayaran"] ?>" type = "date" class = "form-control" name = "tanggal_pembayaran">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Attachment</h5>
                        <input type = "file" name = "attachment">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Notes Transaksi</h5>
                        <textarea class = "form-control" rows = "5" name = "notes"><?php echo $cashflow[$a]["notes"];?></textarea>
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Kategori Transaksi</h5>
                        <select class = "form-control" name = "jenis_pembayaran">
                            <option value = "1">Transaksi Uang Masuk</option>
                            <option value = "0" <?php if($cashflow[$a]["jenis_pembayaran"] == 0) echo "selected";?>>Transaksi Uang Keluar</option>
                        </select>
                    </div>
                    <div class = "form-group">
                        <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class = "modal fade" id = "konfirmasiDelete<?php echo $a;?>">
    <div class = "modal-dialog modal-xl">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class ="modal-title">KONFIRMASI HAPUS</h4>
            </div>
            <div class = "modal-body">
                <form action = "<?php echo base_url();?>finance/othercashflow/remove/<?php echo $cashflow[$a]["id_submit_tagihan_other"];?>" method = "post">
                    
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Subject Transaksi</h5>
                        <input disabled value = "<?php echo $cashflow[$a]["subject_tagihan"] ?>" type = "text" class = "form-control" name = "subject_tagihan">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Kategori Transaksi</h5>
                        <input class = "form-control" type = "text" disabled value = "<?php echo $cashflow[$a]["name_type"];?>">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Nominal Transaksi</h5>
                        <input disabled value = "<?php echo number_format($cashflow[$a]["nominal_tagihan"],2);?>" id = "nominal_tagihan<?php echo $a;?>" type = "text" class = "form-control" name = "nominal_tagihan" oninput = "commas('nominal_tagihan<?php echo $a;?>')">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Tanggal Transaksi</h5>
                        <input disabled value = "<?php echo $cashflow[$a]["tanggal_pembayaran"] ?>" type = "date" class = "form-control" name = "tanggal_pembayaran">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Notes Transaksi</h5>
                        <textarea disabled class = "form-control" rows = "5" name = "notes"><?php echo $cashflow[$a]["notes"];?></textarea>
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Kategori Transaksi</h5>
                        <select disabled class = "form-control" name = "jenis_pembayaran">
                            <option value = "1">Transaksi Uang Masuk</option>
                            <option value = "0" <?php if($cashflow[$a]["jenis_pembayaran"] == 0) echo "selected";?>>Transaksi Uang Keluar</option>
                        </select>
                    </div>
                    <div class = "form-group">
                        <button type = "submit" class = "btn btn-danger btn-sm">DELETE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endfor;?>
