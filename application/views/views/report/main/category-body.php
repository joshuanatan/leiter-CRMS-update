<div class="panel-body col-lg-12">
<?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_report")) == 0):?>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-15">
                <button type="button" data-target = "#createReport" data-toggle = "modal" class = "btn btn-primary btn-outline btn-sm">Create Report
                </button>
            </div>
        </div>
    </div>
<?php endif;?>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
        <thead>
            <tr>
                <th>ID Report</th> <!-- nanti ini keisi waktu nambahin OC-->
                <th>Week</th>
                <th>Report Type</th>
                <th>PIC Target</th>
                <th>Report</th>
                <th>Next Plan</th>
                <th>Detail</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($kpi_report);$a++):?>
            <tr>
                <td><?php echo $kpi_report[$a]["id_report"];?></td>
                <td><?php echo $kpi_report[$a]["week_name"];?></td>
                <td><?php echo $kpi_report[$a]["kpi"];?></td>
                <td><?php echo $kpi_report[$a]["pic_target"];?></td>
                <td><?php echo $kpi_report[$a]["report"];?></td>
                <td><?php echo $kpi_report[$a]["next_plan"];?></td>
                <td>
                    <button class = "btn btn-primary btn-outline btn-sm" data-target = "#detailReport<?php echo $a;?>" data-toggle = "modal">DETAIL</button>
                    <div class = "modal fade" id = "detailReport<?php echo $a;?>">
                        <div class = "modal-dialog modal-xl">
                            <div class ="modal-content">
                                <div class = "modal-header">
                                    <h4 class = "modal-title">DETAIL REPORT</h4>
                                </div>
                                <div class = "modal-body">
                                    <div class = "form-group">
                                        <h5 style = "opacity:0.5">Location</h5>
                                        <input class = "form-control" type = "text" readonly value = "<?php echo $kpi_report[$a]["location"];?>">
                                    </div>
                                    <div class = "form-group">
                                        <h5 style = "opacity:0.5">Progress Percentage</h5>
                                        <input class = "form-control" type = "text" readonly value = "<?php echo $kpi_report[$a]["progress_percentage"];?>">
                                    </div>
                                    <div class = "form-group">
                                        <h5 style = "opacity:0.5">Report</h5>
                                        <textarea readonly class = "form-control"><?php echo $kpi_report[$a]["report"];?></textarea>
                                    </div>
                                    <div class = "form-group">
                                        <h5 style = "opacity:0.5">Report Submission Date</h5>
                                        <input class = "form-control" type = "text" readonly value = "<?php $date = date_create($kpi_report[$a]["tgl_report"]); echo date_format($date,"d-m-Y");?>">
                                    </div>
                                    <div class = "form-group">
                                        <h5 style = "opacity:0.5">Report</h5>
                                        <textarea readonly class = "form-control"><?php echo $kpi_report[$a]["support_need"];?></textarea>
                                    </div>
                                    <div class = "form-group">
                                        <h5 style = "opacity:0.5">Next Plan</h5>
                                        <textarea readonly class = "form-control"><?php echo $kpi_report[$a]["next_plan"];?></textarea>
                                    </div>
                                    <div class = "form-group">
                                        <a href = "<?php echo base_url();?>assets/dokumen/report/<?php echo $kpi_report[$a]["attachment"];?>" class = "btn btn-primary btn-outline btn-sm" target = "_blank">DOCUMENT</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "edit_report")) == 0):?>
                    <button class = "btn btn-primary btn-outline btn-sm" data-target = "#editReport<?php echo $a;?>" data-toggle = "modal">EDIT</button>

                    <div class = "modal fade" id = "editReport<?php echo $a;?>">
                        <div class = "modal-dialog modal-xl">
                            <div class = "modal-content">
                                <div class = "modal-header">
                                    <h4 class = "modal-title">EDIT REPORT</h4>
                                </div>
                                <form action = "<?php echo base_url();?>report/main/updateReport/<?php echo $kpi_report[$a]["id_report"];?>" method = "POST" enctype = "multipart/form-data">
                                    <div class = "modal-body">
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Report Title</h5>
                                            <input type = "text" name = "judul_report" class = "form-control" value = "<?php echo $kpi_report[$a]["judul_report"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Report Type</h5>
                                            <select name = "tipe_report" class = "form-control">
                                                <?php for($b = 0; $b<count($kpi_user);$b++):?>
                                                <option value = "<?php echo $kpi_user[$b]["kpi"];?>" <?php if($kpi_user[$b]["kpi"] == $kpi_report[$a]["tipe_report"]) echo "selected";?> ><?php echo $kpi_user[$b]["kpi"];?></option>
                                                <?php endfor;?>
                                            </select>
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Target - PIC</h5>
                                            <input type = "text" class = "form-control" name = "pic_target" value = "<?php echo $kpi_report[$a]["pic_target"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Location</h5>
                                            <input type = "text" class = "form-control" name = "location" value = "<?php echo $kpi_report[$a]["location"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Progress</h5>
                                            <input type = "number" class = "form-control" name = "progress_percentage" value = "<?php echo $kpi_report[$a]["progress_percentage"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Report</h5>
                                            <textarea class = "form-control" name = "report"><?php echo $kpi_report[$a]["report"];?></textarea>
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Support Need</h5>
                                            <textarea class = "form-control" name = "support_need"><?php echo $kpi_report[$a]["support_need"];?></textarea>
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Next Plan</h5>
                                            <textarea class = "form-control" name = "next_plan"><?php echo $kpi_report[$a]["next_plan"];?></textarea>
                                        </div>
                                        <div class = "form-group">
                                            <a href = "<?php echo base_url();?>assets/dokumen/report/<?php echo $kpi_report[$a]["attachment"];?>" class = "btn btn-outline btn-sm btn-primary">DOCUMENT</a>
                                            <h5 style = "opacity:0.5">Attachment</h5>
                                            <input type = "file" class = "form-control" name = "attachment">
                                        </div>
                                        <div class = "form-group">
                                            <button class = "btn btn-primary btn-ouline col-lg-3">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
                    <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "delete_report")) == 0):?>
                    <a href = "<?php echo base_url();?>report/main/remove/<?php echo $kpi_report[$a]["id_report"];?>" class = "btn btn-danger btn-outline btn-sm">REMOVE</a> 
                    <?php endif;?>
                </td>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
</div>
<?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_report")) == 0):?>
<div class = "modal fade" id = "createReport">
    <div class = "modal-dialog modal-xl">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">CREATE REPORT</h4>
            </div>
            <form action = "<?php echo base_url();?>report/main/insertReport" method = "POST" enctype = "multipart/form-data">
                <div class = "modal-body">
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Report Title</h5>
                        <input type = "text" name = "judul_report" class = "form-control">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Report Type</h5>
                        <select name = "tipe_report" class = "form-control">
                            <?php for($a = 0; $a<count($kpi_user);$a++):?>
                            <option value = "<?php echo $kpi_user[$a]["id_kpi_user"];?>"><?php echo $kpi_user[$a]["kpi"];?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Target - PIC</h5>
                        <input type = "text" class = "form-control" name = "pic_target">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Location</h5>
                        <input type = "text" class = "form-control" name = "location">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Progress</h5>
                        <input type = "number" class = "form-control" name = "progress_percentage">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Report</h5>
                        <textarea class = "form-control" name = "report"></textarea>
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Support Need</h5>
                        <textarea class = "form-control" name = "support_need"></textarea>
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Next Plan</h5>
                        <textarea class = "form-control" name = "next_plan"></textarea>
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Attachment</h5>
                        <input type = "file" class = "form-control" name = "attachment">
                    </div>
                    <div class = "form-group">
                        <button class = "btn btn-primary btn-ouline col-lg-3">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif;?>