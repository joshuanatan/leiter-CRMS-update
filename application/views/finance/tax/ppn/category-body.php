<div class="panel-body col-lg-12">
    <form action = "<?php echo base_url();?>finance/tax/ppn/report" method = "POST">
        <div class="row">
            <div class = "col-lg-5">
                <div class = "form-group">
                    <h5>MONTH</h5>
                    <select class = "form-control" name = "bulan_pajak">
                        <?php foreach($bulan as $key=>$value): ?>
                        <option value = "<?php echo $key;?>"><?php echo $value;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class = "col-lg-5">
                <div class = "form-group">
                    <h5>YEAR</h5>
                    <select class = "form-control" name = "tahun_pajak">
                        <?php for($a = 0; $a<count($tahun);$a++):?>
                        <option value = "<?php echo $tahun[$a];?>"><?php echo $tahun[$a];?></option>
                        <?php endfor;?>
                    </select>
                </div>
            </div>
            <div class  = "col-lg-2">
                <div class = "form-group">
                    <h5>Go</h5>
                    <button type = "submit" class = "btn btn-primary btn-outline">CHECK PPN STATS</button>
                </div>
            </div>
        </div>
    </form>
    
</div>
<div class="panel-body col-lg-12">
    <div class="row">
    </div>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "DataTable">
        <thead>
            <tr>
                <td>Jumlah Tax</td>
                <td>No Refrensi</td>
                <td>Tanggal Masuk Faktur Pajak</td>
                <td>Nomor Faktur Pajak</td>
                <td>Attachment</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($tax); $a++):?>
            <tr>
                <form action = "<?php echo base_url();?>finance/tax/pph23/insertFaktur" method = "POST" enctype="multipart/form-data">
                    <input type = "hidden" name = "id_tax" value = "<?php echo $tax[$a]["id_tax"];?>">
                    <td><?php echo number_format($tax[$a]["jumlah_pajak"],2);?></td>
                    <td><?php echo $tax[$a]["id_refrensi"];?></td>
                    <td><input required type = "date" name = "tgl_input_faktur" class = "form-control"></td>
                    <td><input required type = "text" name = "no_faktur_pajak" class = "form-control"></td>
                    <td><input type = "file" name = "attachment"></td>
                    <td><button type = "submit" class = "btn btn-primary btn-sm col-lg-12">SUBMIT</button></td>
                </form>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
</div>
