<div class="panel-body col-lg-12">
    <div class="row">
        <div class = "col-lg-12">
            <h3>KPI - <?php echo strtoupper($detail["nama_user"]);?> - <?php echo strtoupper($detail["week_name"]); ?></h3>
        </div>
    </div>
    <hr/>
    <br/><br/>
    <div>
        <div class = "row">
            <div class = "col-lg-12">
                <div class="example text-center">
                    <canvas id="kpiGraph" style = "height:50px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <?php for($a = 0; $a<count($kpi_user);$a++):?> <!-- jumlah tabel sebanyak kpi user yang aktif -->
    <hr/>
    <br/><br/>
    <div>
        <div class="row">
            <div class = "col-lg-12">
                <h5>KPI - <?php echo $kpi_user[$a]["kpi"];?></h5>
            </div>
        </div>
        <div class = "row">
            <div class = "col-lg-6">
                <div class = "form-group">
                    
                </div>
            </div>
        </div>
        <table class = "table table-bordered table-stripped col-lg-12" style = "width:100%" data-plugin = "dataTable">
            <thead>
                <th>No Report</th>
                <th>Submission Date</th>
                <th>Activity</th>
                <th>Notes</th>
                <th>Next Plan</th>
                <th>Attachment</th>
            </thead>
            <tbody>
                <?php for($b = 0; $b<count($report); $b++):?>
                <?php if($report[$b]["tipe_report"] == $kpi_user[$a]["id_kpi_user"]):?>
                <tr>
                    <td><?php echo $report[$b]["id_report"];?></td>
                    <td><?php echo $report[$b]["tgl_report"];?></td>
                    <td><?php echo $report[$b]["judul_report"];?></td>
                    <td><?php echo $report[$b]["report"];?></td>
                    <td><?php echo $report[$b]["next_plan"];?></td>
                    <td>
                        <a href = "<?php echo base_url();?>assets/dokumen/report/<?php echo $report[$b]["attachment"];?>" class = "btn btn-sm btn-primary btn-outline" target = "_blank">DOCUMENT</a>
                        <button class = "btn btn-sm btn-primary btn-outline" data-target = "#detailDokumen<?php echo $b;?>" data-toggle = "modal">DETAIL REPORT</button>
                        <div class = "modal fade" id = "detailDokumen<?php echo $b;?>">
                            <div class = "modal-dialog modal-xl">
                                <div class = "modal-content">
                                    <div class = "modal-header">
                                        <h4 class = "modal-title">DOCUMENT DETAIL</h4>
                                    </div>
                                    <div class = "modal-body">
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Report Title</h5>
                                            <input readonly type = "text" class = "form-control" value = "<?php echo $report[$b]["judul_report"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Report Type</h5>
                                            
                                            <input readonly type = "text" class = "form-control" value = "<?php echo $report[$b]["tipe_report"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Target - PIC</h5>
                                            <input readonly type = "text" class = "form-control" value = "<?php echo $report[$b]["pic_target"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Location</h5>
                                            <input readonly type = "text" class = "form-control" value = "<?php echo $report[$b]["location"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Progress</h5>
                                            <input readonly type = "number" class = "form-control" value = "<?php echo $report[$b]["progress_percentage"];?>">
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Report</h5>
                                            <textarea readonly class = "form-control"><?php echo $report[$b]["report"];?></textarea>
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Support Need</h5>
                                            <textarea readonly class = "form-control"><?php echo $report[$b]["support_need"];?></textarea>
                                        </div>
                                        <div class = "form-group">
                                            <h5 style = "opacity:0.5">Next Plan</h5>
                                            <textarea readonly class = "form-control"><?php echo $report[$b]["next_plan"];?></textarea>
                                        </div>
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
    </div>
    <?php endfor;?>
    <div class = "form-group">
        <a href = "<?php echo base_url();?>report/kpi" class = "btn btn-primary btn-sm">BACK</a>
    </div>
</div>