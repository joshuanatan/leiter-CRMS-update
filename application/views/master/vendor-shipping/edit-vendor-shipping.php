<div class="panel-body col-lg-12">
    <div class="row row-lg">
        <div class="col-xl-12">
            <!-- Example Tabs Left -->
            <div class="example-wrap">
                <div class="nav-tabs-vertical" data-plugin="tabs">
                    <ul class="nav nav-tabs nav-tabs-line mr-25" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#primaryData" aria-controls="primaryData" role="tab">Primary Data</a></li>
                    </ul>
                    <form action = "<?php echo base_url();?>master/vendor/shipping/editvendor" method = "post">    
                        
                        <div class="tab-content">
                            <?php foreach($perusahaan->result() as $a):?>
                            <div class="tab-pane active" id="primaryData" role="tabpanel">
                                <input type = "hidden" name = "id_perusahaan" value = "<?php echo $a->id_perusahaan;?>">
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Nama Shipper</h5>
                                    <input type = "text" class = "form-control" value = "<?php echo $a->nama_perusahaan ?>" name = "nama_perusahaan">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">No Fax Shipper</h5>
                                    <input type = "text" class = "form-control" value = "<?php echo $a->nofax_perusahaan ?>" name = "nofax_perusahaan">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">No Telp Shipper</h5>
                                    <input type = "text" class = "form-control" value = "<?php echo $a->notelp_perusahaan ?>" name = "notelp_perusahaan">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Alamat Perusahaan</h5>
                                    <textarea class = "form-control" name = "alamat_perusahaan" rows = "5"><?php echo $a->alamat_perusahaan ?></textarea>
                                </div>
                                <div class = "form-group">
                                    <button type = "submit" class = "btn btn-primary btn-sm btn-outline col-lg-2 col-md-12">SUBMIT</button>

                                    <a href = "<?php echo base_url();?>master/vendor/shipping" class = "btn btn-primary btn-sm btn-outline col-lg-2 col-md-12">BACK</a>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                        
                    </form>
                </div>
            </div>
            <!-- End Example Tabs Left -->
        </div>
    </div>
</div>
