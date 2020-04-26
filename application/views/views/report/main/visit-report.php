
<div class="panel-body col-lg-12">
<?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_visit")) == 0):?>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-15">
                <button type="button" data-target = "#createReport" data-toggle = "modal" class = "btn btn-primary btn-outline">Create Report
                </button>
            </div>
        </div>
    </div>
<?php endif;?>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
        <thead>
            <tr>
                <th>ID Report</th> <!-- nanti ini keisi waktu nambahin OC-->
                <th>Jenis Report</th>
                <th>Nama Perusahaan</th>
                <th>PIC Target</th>
                <th>Location / Duration</th>
                <th>Conversation</th> <!--nanti kasih tombol buat image setelah konten conversationnya selesai-->
                <th>Conclusion</th> 
                <th>Next Action</th>
                <th>Support</th>
                <th>Follow Up Date</th>
                <th>Detail</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($visit);$a++):?>
            <tr>
                <td><?php echo $visit[$a]["id_submit_report"];?></td>
                <td>
                    <?php if($visit[$a]["jenis_report"] == 0):?>
                    <button type = "button" class = "btn btn-primary btn-sm">VISIT REPORT</button>
                    <?php else:?>
                    <button type = "button" class = "btn btn-warning btn-sm">CALL REPORT</button>
                    <?php endif;?>
                </td>
                <td><?php echo $visit[$a]["nama_perusahaan"];?></td>
                <td><?php echo nl2br($visit[$a]["action_pic"]);?></td>
                <td>
                    <?php echo ucwords($visit[$a]["action_location"]);?> <br/>
                    <?php $split = explode(":",$visit[$a]["action_duration"]);echo $split[0] ." Jam ". $split[1]. " Menit";?>
                </td>
                <td><?php echo nl2br($visit[$a]["action_conversation"]);?><br/><a href = "<?php echo base_url();?>assets/report/visit/<?php echo $visit[$a]["conversation_image"];?>" target = "_blank" class = "btn btn-sm btn-primary">Attachment</a></td>
                <td><?php echo nl2br($visit[$a]["action_conclusion"]);?></td>
                <td><button class = "btn btn-sm btn-primary" data-toggle = "modal" data-target = "#nextAction<?php echo $a;?>">Next Action</button></td>
                <td><?php echo nl2br($visit[$a]["support_need"]);?></td>
                <td><?php $date = date_create($visit[$a]["followup_date"]); echo date_format($date,"D d-m-Y");?></td>
                <td>
                    <button class = "btn btn-primary btn-outline btn-sm" data-target = "#detailReport<?php echo $a;?>" data-toggle = "modal">DETAIL</button>
                </td>
                <td>
                <?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "edit_visit")) == 0):?>
                    <a href = "<?php echo base_url();?>report/main/editVisitCallReport/<?php echo $visit[$a]["id_submit_report"];?>" class = "col-lg-12 btn btn-primary btn-outline btn-sm">EDIT</a>
<?php endif;?>
<?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "delete_visit")) == 0):?>
                    <a href = "<?php echo base_url();?>report/main/removeVisitReport/<?php echo $visit[$a]["id_submit_report"];?>" class = "col-lg-12 btn btn-danger btn-outline btn-sm">REMOVE</a> 
<?php endif;?>
                    <a target = "_blank" href = "<?php echo base_url();?>report/main/pdfVisitReport/<?php echo $visit[$a]["id_submit_report"];?>" class = "col-lg-12 btn btn-primary btn-outline btn-sm">PDF</a> 
                    
                </td>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
</div>
<?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_visit")) == 0):?>
<div class = "modal fade" id = "createReport">
    <div class = "modal-dialog modal-lg">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">CREATE VISIT/CALL REPORT</h4>
            </div>
            <form action = "<?php echo base_url();?>report/main/insertVisitCallReport" method = "POST" enctype = "multipart/form-data">
                <div class = "modal-body">
                    <div class = "form-group">
                        <h5>Report Type</h5>
                        <select class = "form-control" data-plugin = "select2" name = "jenis_report">
                            <option value = "0">VISIT REPORT</option>
                            <option value = "1">CALL REPORT</option>
                        </select>
                    </div>
                    <div class = "form-group">
                        <h5 style = "color:darkgrey; opacity:0.8">Perusahaan Customer</h5>
                        <span id = "customerNotFound" style = "color:red; display:none">CUSTOMER NOT FOUND</span>
                        <input required type = "text" class = "form-control" oninput = "getRecommendationPerusahaan()" id = "namaperusahaan" placeholder="Ketik Perusahaan"> 
                        <select class = "form-control" name = "id_perusahaan" id = "recommendationPerusahaan"></select>
                            
                    </div>
                    <div class = "form-group">
                        <span style = "color:red; display:none" id = "customerNotFound">CUSTOMER NOT FOUND</span>
                        <button class = "btn btn-primary" type = "button" data-toggle = "modal" data-target = "#customerBaru">Customer Baru</button>
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Visit Date</h5>
                        <input type = "date" name = "action_date" class = "form-control col-lg-3 col-md-12">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Location</h5>
                        <input type = "text" name = "action_location" class = "form-control">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Duration (HH:MM)</h5>
                        <input type = "text" name = "action_duration" class = "form-control">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Purpose</h5>
                        <input type = "text" name = "action_purpose" class = "form-control">
                    </div>
                    <div class = "row">
                        <div class = "form-group col-lg-12 col-sm-12">
                            <h5 style = "opacity:0.5">PIC & Jabatan </h5>
                            <textarea name = "action_pic" class = "form-control" placeholder = "1. Ibu Abc (Marketing)"></textarea>
                        </div>
                        <?php if(false):?>
                        <div class = "form-group col-lg-6 col-sm-12">
                            <h5 style = "opacity:0.5">Jabatan PIC</h5>
                            <textarea name = "pic_position" class = "form-control"></textarea>
                        </div>
                        <?php endif;?>
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Dialog</h5> 
                        <textarea class = "form-control" name = "conversation"></textarea>
                        <input type = "file" name = "conversation_image[]" multiple>
                    </div>  
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Potential Machine</h5>
                        <textarea class = "form-control" name = "potential_machine"></textarea>
                    </div>  
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Conclusion</h5>
                        <textarea class = "form-control" name = "action_conclusion"></textarea>
                    </div>  
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Percentage (Isi persennya saja)</h5>
                        <input type = "number" name = "action_percentage_order" class = "form-control">
                    </div>
                    <table class = "table table-stripped table-bordered" style = "width:100%" data-plugin = "dataTable">
                        <thead>
                            <th>#</th>
                            <th>Remarks</th>
                            <th>PIC</th>
                        </thead>
                        <tbody>
                            <?php for($a = 0; $a<10; $a++):?>
                            <tr>
                                <td>
                                    <div class = "checkbox-custom checkbox-primary">
                                        <input name = "checks[]" type = "checkbox" value = "<?php echo $a;?>">
                                        <label></label>
                                    </div>
                                </td>
                                <td>
                                    <textarea class = "form-control" name = "remarks<?php echo $a;?>"></textarea>
                                </td>
                                <td>
                                    <textarea class = "form-control" name = "pic<?php echo $a;?>"></textarea>
                                </td>
                            </tr>
                            <?php endfor;?>
                        </tbody>
                    </table>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Support Needed</h5>
                        <textarea class = "form-control" name = "support_need"></textarea>
                    </div>  
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Follow Up Date</h5>
                        <input type = "date" name = "followup_date" class = "form-control col-md-12 col-lg-3">
                    </div>
                    <div class = "form-group">
                        <button class = "btn btn-primary btn-ouline">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif;?>

<?php for($a = 0; $a<count($visit);$a++):?>
<div class = "modal fade" id = "nextAction<?php echo $a;?>">
    <div class = "modal-dialog modal-lg">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">Next Action
            </div>
            <div class = "modal-body">
                <table class = "table table-bordered table-stripped" data-plugin="dataTable" style = "width:100%">
                    <thead>
                        <th>Remarks</th>
                        <th>PIC</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php for($b = 0; $b<count($visit[$a]["next_action"]); $b++):?>
                        <tr>
                            <td><?php echo nl2br($visit[$a]["next_action"][$b]["remarks"]);?></td>
                            <td><?php echo nl2br($visit[$a]["next_action"][$b]["pic"]);?></td>
                            <td><a href = "#" class = "btn btn-danger btn-sm">DELETE</a></td>
                        </tr>
                        <?php endfor;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endfor;?>
<?php if(isExistsInTable("privilage", array("id_user" => $this->session->id_user,"id_menu" => "insert_visit")) == 0):?>
<div class = "modal fade" id = "customerBaru">
    <div class = "modal-dialog modal-xl">
        <div class ="modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">TAMBAH CUSTOMER BARU</h4>
            </div>
            <form action = "<?php echo base_url();?>crm/request/insertNewCustomer" method = "POST">
                <div class = "modal-body">
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Nama Perusahaan Customer</h5>
                        <input type = "text" class = "form-control" name = "add_nama_customer">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Alamat Invoice</h5>
                        <textarea class = "form-control" name = "add_address_customer"></textarea>
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Alamat Pengiriman</h5>
                        <textarea class = "form-control" name = "add_pengiriman_customer"></textarea>
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Segment</h5>
                        <input type = "text" class = "form-control" name = "add_segment_customer">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">PIC Customer</h5>
                        <input type = "text" class = "form-control" name = "add_pic">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Jenis Kelamin PIC</h5>
                        <select class = "form-control" name = "add_jk_pic">
                            <option value = "Mr">MR</option>
                            <option value = "Ms">MS</option>
                        </select>
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Email PIC</h5>
                        <input type = "text" class = "form-control" name = "add_email_pic">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">No Handphone PIC</h5>
                        <input type = "text" class = "form-control" name = "add_phone_pic">
                    </div>
                    <div class = "form-group">
                        <button type = "submit" class = "btn btn-primary btn-outline btn-sm">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif;?>