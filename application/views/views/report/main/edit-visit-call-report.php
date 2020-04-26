<div class="panel-body col-lg-12">
<div class="row row-lg">
        <div class="col-xl-12">
            <!-- Example Tabs Left -->
            <div class="example-wrap">
                <div class="nav-tabs-vertical" data-plugin="tabs">
                    <ul class="nav nav-tabs mr-25" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#primaryData" aria-controls="primaryData" role="tab">Primary Data</a></li>

                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#items" aria-controls="items" role="tab">Items</a></li>

                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#remarks" aria-controls="produksi" role="tab">Next Action</a></li>

                    </ul>
                    <form action = "<?php echo base_url();?>report/main/updateVisitReport" method = "post" enctype = "multipart/form-data">    
                        <div class="tab-content">
                            <div class="tab-pane active" id="primaryData" role="tabpanel">  
                                <input type = "hidden" name = "id_submit_report" value = "<?php echo $report[0]["id_submit_report"];?>">
                                <div class = "form-group">
                                    <h5>Report Type</h5>
                                    <select class = "form-control" data-plugin = "select2" name = "jenis_report">
                                        <option value = "0">VISIT REPORT</option>
                                        <option value = "1" <?php if($report[0]["jenis_report"] == 1) echo "Selected"; ?>>CALL REPORT</option>
                                    </select>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Perusahaan Customer</h5>
                                    <span id = "customerNotFound" style = "color:red; display:none">CUSTOMER NOT FOUND</span>
                                    <input required value = "<?php echo $report[0]["nama_perusahaan"];?>" type = "text" class = "form-control" oninput = "getRecommendationPerusahaan()" id = "namaperusahaan" placeholder="Ketik Perusahaan"> 
                                    <select data-plugin = "select2" class = "form-control" name = "id_perusahaan" id = "recommendationPerusahaan">
                                        <option value = "<?php echo $report[0]["id_perusahaan"];?>"><?php echo $report[0]["nama_perusahaan"];?></option>
                                    </select>
                                </div>
                                <div class = "form-group">
                                    <span style = "color:red; display:none" id = "customerNotFound">CUSTOMER NOT FOUND</span>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Visit Date</h5>
                                    <input type = "date" name = "action_date" value = "<?php $date = date_create($report[0]["action_date"]); echo date_format($date,"Y-m-d");?>" class = "form-control col-lg-3 col-md-12">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Location</h5>
                                    <input type = "text" name = "action_location" value = "<?php echo $report[0]["action_location"];?>" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Duration (HH:MM)</h5>
                                    <input type = "text" name = "action_duration" value = "<?php echo $report[0]["action_duration"];?>" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Purpose</h5>
                                    <input type = "text" name = "action_purpose" value = "<?php echo $report[0]["action_purpose"];?>" class = "form-control">
                                </div>
                                <div class = "row">
                                    <div class = "form-group col-lg-12 col-sm-12">
                                        <h5 style = "opacity:0.5">PIC & Jabatan </h5>
                                        <textarea name = "action_pic" class = "form-control" placeholder = "1. Ibu Abc (Marketing)"><?php echo $report[0]["action_pic"];?></textarea>
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Dialog</h5> 
                                    <textarea class = "form-control" name = "conversation"><?php echo $report[0]["action_conversation"];?></textarea>
                                </div>  
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Potential Machine</h5>
                                    <textarea class = "form-control" name = "potential_machine"><?php echo $report[0]["potential_machine"];?></textarea>
                                </div>  
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Conclusion</h5>
                                    <textarea class = "form-control" name = "action_conclusion"><?php echo $report[0]["action_conclusion"];?></textarea>
                                </div>  
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Percentage (Isi persennya saja)</h5>
                                    <input type = "number" name = "action_percentage_order" value = "<?php echo $report[0]["action_percentage_order"];?>" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Support Needed</h5>
                                    <textarea class = "form-control" name = "support_need"><?php echo $report[0]["support_need"];?></textarea>
                                </div>  
                                <div class = "form-group">
                                    <h5 style = "opacity:0.5">Follow Up Date</h5>
                                    <input type = "date" name = "followup_date" value = "<?php $date = date_create($report[0]["followup_date"]); echo date_format($date,"Y-m-d");?>" class = "form-control col-md-12 col-lg-3">
                                </div>
                            </div>
                            <div class="tab-pane" id="items" role="tabpanel">
                                <div class = "form-group col-lg-12">
                                    <table class = "table table-bordered table-hover table-stripped col-lg-12" style = "width:100%" data-plugin = "dataTable">
                                        <thead>
                                            <th style = "width:10%">Add</th>
                                            <th style = "width:10%">delete</th>
                                            <th>Image</th>
                                            <th>Update</th>
                                        </thead>
                                        <tbody>
                                        <?php for($a = 0; $a<10; $a++):?>
                                            <?php if($a < count($attachment)):?>
                                            <tr>
                                                <td>
                                                    <input type = "hidden" value = "<?php echo $attachment[$a]["id_submit_attachment"];?>" name = "id_submit_attachment<?php echo $a;?>">
                                                    <div class = "checkbox-custom checkbox-primary">
                                                        <input type = "checkbox" name = "checks[]" value = "<?php echo $a;?>" checked>
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class = "checkbox-custom checkbox-primary">
                                                        <input type = "checkbox" name = "delete[]" value = "<?php echo $attachment[$a]["id_submit_attachment"];?>">
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <img style = "width:100px" src = "<?php echo base_url();?>assets/report/visit/<?php echo $attachment[$a]["attachment"];?>">
                                                </td>
                                                <td>
                                                    <input type = "file" name = "upload<?php echo $a;?>">
                                                </td>
                                            </tr>
                                            <?php else:?>
                                            <tr>
                                                <td>
                                                    <input type = "hidden" value = "" name = "id_submit_attachment<?php echo $a;?>">
                                                    <div class = "checkbox-custom checkbox-primary">
                                                        <input type = "checkbox" name = "checks[]" value = "<?php echo $a;?>">
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td>
                                                </td>
                                                <td>
                                                </td>
                                                <td>
                                                    <input type = "file" name = "upload<?php echo $a;?>">
                                                </td>
                                            </tr>
                                            <?php endif;?>
                                        <?php endfor;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="remarks" role="tabpanel">
                                <table class = "table table-bordered table-hover table-stripped col-lg-12" style = "width:100%" data-plugin = "dataTable">
                                    <thead>
                                        <th style = "width:10%">Add</th>
                                        <th style = "width:10%">delete</th>
                                        <th>Remarks</th>
                                        <th>PIC</th>
                                    </thead>
                                    <tbody>
                                    <?php for($a = 0; $a<10; $a++):?>
                                        <?php if($a < count($next_action)):?>
                                        <tr>
                                            <td>
                                                <input type = "hidden" value = "<?php echo $next_action[$a]["id_submit_next_action"];?>" name = "id_submit_next_action<?php echo $a;?>">
                                                <div class = "checkbox-custom checkbox-primary">
                                                    <input type = "checkbox" name = "checks_next_action[]" value = "<?php echo $a;?>" checked>
                                                    <label></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class = "checkbox-custom checkbox-primary">
                                                    <input type = "checkbox" name = "delete_next_action[]" value = "<?php echo $next_action[$a]["id_submit_next_action"];?>">
                                                    <label></label>
                                                </div>
                                            </td>
                                            <td>
                                                <textarea name = "remarks<?php echo $a;?>" class = "form-control"><?php echo $next_action[$a]["remarks"];?></textarea>
                                            </td>
                                            <td>
                                                <textarea name = "pic<?php echo $a;?>" class = "form-control"><?php echo $next_action[$a]["pic"];?></textarea>
                                            </td>
                                        </tr>
                                        <?php else:?>
                                        <tr>
                                            <td>
                                                <input type = "hidden" value = "" name = "id_submit_next_action<?php echo $a;?>">
                                                <div class = "checkbox-custom checkbox-primary">
                                                    <input type = "checkbox" name = "checks_next_action[]" value = "<?php echo $a;?>">
                                                    <label></label>
                                                </div>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                                <textarea name = "remarks<?php echo $a;?>" class = "form-control"></textarea>
                                            </td>
                                            <td>
                                                <textarea name = "pic<?php echo $a;?>" class = "form-control"></textarea>
                                            </td>
                                        </tr>
                                        <?php endif;?>
                                    <?php endfor;?>
                                    </tbody>
                                </table>
                                <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                            </div>
                        </div>
                        <div class = "form-group">
                            <a href = "<?php echo base_url();?>report/main/report" class = "btn btn-outline btn-primary btn-sm">BACK</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Example Tabs Left -->
        </div>
    </div>
</div>