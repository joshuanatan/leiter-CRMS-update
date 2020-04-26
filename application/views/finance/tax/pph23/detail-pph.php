
<div class="panel-body col-lg-12">
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
        <thead>
            <tr>
                <th>No Faktur Pajak</th>
                <th>Jumlah Pajak</th>
                <th>ID Tagihan</th>
                <th>Attachment Faktur</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $jumlahMasukan = 0;for($a =0; $a<count($tax); $a++):?>
            
            <tr>
                <td><?php echo $tax[$a]["no_faktur_pajak"];?></td>
                <td><?php echo number_format($tax[$a]["jumlah_pajak"]);?></td>
                <td>
                    <?php if($tax[$a]["is_pib"] != 0):?>
                    <a class = "btn btn-primary btn-sm" target = "_blank" href = "<?php echo base_url();?>finance/payable/"><?php echo $tax[$a]["id_refrensi"];?></a>
                    <?php else:?>
                    <a class = "btn btn-primary btn-sm" target = "_blank" href = "<?php echo base_url();?>finance/tax/pib/"><?php echo $tax[$a]["id_refrensi"];?></a>
                    <?php endif;?>
                </td>
                <td>
                    <a target = "_blank" href = "<?php echo base_url();?>assets/dokumen/ppn/<?php echo $tax[$a]["attachment"];?>" class = "btn btn-primary btn-sm">ATTACHMENT FAKTUR</a>
                </td>
                <td>
                    <button class = "btn btn-primary btn-sm" type = "button" data-toggle = "modal" data-target = "#updateFakturBaru<?php echo $a;?>">UPDATE ATTACHMENT</button>
                    <div class = "modal fade" id = "updateFakturBaru<?php echo $a;?>">
                        <div class = "modal-dialog">
                            <div class = "modal-content">
                                <div class = "modal-header">
                                    <h4 class = "modal-title">UPDATE ATTACHMENET</h4>
                                </div>
                                <div class = "modal-body">
                                    <span style = "color:red">WARNING.</span>
                                    <h5>Jumlah pajak, refrensi tidak diizinkan untuk dirubah.</h5>
                                    <hr/>
                                    <form action = "<?php echo base_url();?>finance/tax/pph23/updateFaktur" method = "POST" enctype="multipart/form-data">
                                        <input name = "id_tax" type = "hidden" value = "<?php echo $tax[$a]["id_tax"];?>">
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">BULAN FAKTUR</h5>
                                            <select name = "bulan_pajak" class = "form-control">
                                                <?php foreach($bulan as $key=>$value):?>
                                                <option value = "<?php echo $key;?>" <?php if($tax[$a]["bulan_pajak"] == $key) echo "selected"; ?>><?php echo $value;?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">TAHUN FAKTUR</h5>
                                            <input class = "form-control" type = "text" name = "tahun_pajak" value = "<?php echo $tax[$a]["tahun_pajak"];?>" required>
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">NOMOR FAKTUR</h5>
                                            <input class = "form-control" type = "text" name = "no_faktur_pajak" value = "<?php echo $tax[$a]["no_faktur_pajak"];?>" required>
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">ATTACHMENT BARU FAKTUR</h5>
                                            <input type = "file" name = "attachment">
                                        </div>
                                        <div class = "form-group">
                                            <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
    <div class = "form-group">
        <a href = "<?php echo base_url();?>finance/tax/pph23" class = "btn btn-primary btn-sm">BACK</a>
        <?php if(count($tax) > 0):?>
        <a target = "_blank" href = "<?php echo base_url();?>finance/tax/pph23/excel/<?php echo $tax[0]["bulan_pajak"];?>/<?php echo $tax[0]["tahun_pajak"];?>" class = "btn btn-success btn-sm">EXCEL</a>
        <?php endif;?>
    </div>
</div>