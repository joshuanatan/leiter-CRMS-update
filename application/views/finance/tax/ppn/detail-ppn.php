<?php $jumlahMasukan = 0; $jumlahKeluaran = 0;
for($a =0; $a<count($tax); $a++){
    if($tax[$a]["tipe_pajak"] == "MASUKAN"){ /*ppn masukan*/
        $jumlahMasukan += $tax[$a]["jumlah_pajak"];
    }
    else{/*ppn keluaran*/
        $jumlahKeluaran += $tax[$a]["jumlah_pajak"];
    }
}
?>
<div class="panel-body col-lg-12">
    <div class = "row">
        <div class="col-lg-3">
            <div class="card card-block p-25 bg-blue-600">
                <div class="counter counter-lg counter-inverse">
                    <div class="counter-label text-uppercase">TOTAL PPN MASUKAN</div>
                    <span class="counter-number"><?php echo number_format($jumlahMasukan);?></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-block p-25 bg-blue-600">
                <div class="counter counter-lg counter-inverse">
                    <div class="counter-label text-uppercase">TOTAL PPN KELUARAN</div>
                    <span class="counter-number"><?php echo number_format($jumlahKeluaran);?></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-block p-25 bg-blue-600">
                <div class="counter counter-lg counter-inverse">
                    <div class="counter-label text-uppercase">SELISIH</div>
                    <span class="counter-number">
                        <?php if($jumlahKeluaran > $jumlahMasukan) echo number_format(($jumlahKeluaran-$jumlahMasukan)); else echo number_format(($jumlahMasukan-$jumlahKeluaran));?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-block p-25 bg-blue-600">
                <div class="counter counter-lg counter-inverse">
                    <div class="counter-label text-uppercase">YANG LEBIH BESAR</div>
                    <span class="counter-number">
                        <?php if($jumlahKeluaran > $jumlahMasukan) echo "KELUARAN"; else echo "MASUKAN";?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class = "col-lg-12">
            <H5>PPN MASUKAN</H5>
        </div>
    </div>
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
            <?php if($tax[$a]["tipe_pajak"] == "MASUKAN"): $jumlahMasukan += $tax[$a]["jumlah_pajak"];?>
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
                                    <form action = "<?php echo base_url();?>finance/tax/ppn/updateFaktur" method = "POST" enctype="multipart/form-data">
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
            <?php endif;?>
            <?php endfor;?>
        </tbody>
    </table>
    <br/><br/>
    <HR/>
    <br/><br/>
    <div class="row">
        <div class = "col-lg-12">
            <H5>PPN KELUARAN</H5>
        </div>
    </div>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
    <thead>
            <tr>
                <th>No Faktur Pajak</th>
                <th>Jumlah Pajak</th> <!-- yang ngelaurin invoice ini -->
                <th>ID Refrensi</th> <!-- ini yang tertulis. backgroundnya karena yang tertulis kadang belum termasuk pph 23-->
                <th>Attachment Faktur</th>
                <th>Action</th>
             
            </tr>
        </thead>
        <tbody>
            <?php for($a =0; $a<count($tax); $a++):?>
            <?php if($tax[$a]["tipe_pajak"] == "KELUARAN"):?>
            <tr>
                <td><?php echo $tax[$a]["no_faktur_pajak"];?></td>
                <td><?php echo number_format($tax[$a]["jumlah_pajak"]);?></td>
                <td>
                    <a class = "btn btn-primary btn-sm" target = "_blank" href = "<?php echo base_url();?>finance/receivable/"><?php echo $tax[$a]["id_refrensi"];?></a>
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
                                    <form action = "<?php echo base_url();?>finance/tax/ppn/updateFaktur" method = "POST" enctype="multipart/form-data">
                                        <input name = "id_tax" type = "hidden" value = "<?php echo $tax[$a]["id_tax"];?>">
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
            <?php endif;?>
            <?php endfor;?>
        </tbody>
    </table>
    <div class = "form-group">
        <a href = "<?php echo base_url();?>finance/tax/ppn" class = "btn btn-outline btn-primary btn-sm">BACK</a>
    </div>
</div>