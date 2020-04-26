<div class="panel-body col-lg-12">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-15">
                <button type="button" data-target = "#insertweek" data-toggle = "modal" class = "btn btn-sm btn-primary btn-outline">Insert Week
                </button>
                <a href = "<?php echo base_url();?>report/kpi/user" class = "btn btn-sm btn-outline btn-primary">Set Target</a>
                
            </div>
        </div>
    </div>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0" data-plugin = "dataTable">
        <thead>
            <tr>
                <th>WEEK</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($week); $a++):?>
            <tr>
                <td>WEEK - <?php echo $week[$a]["id_weeks"];?></td>
                <td><?php echo $week[$a]["tgl_mulai"];?></td>
                <td><?php echo $week[$a]["tgl_selesai"];?></td>
                <td>
                    <button type = "button" class = "btn btn-outline btn-primary btn-sm" data-target = "#weeklyReport<?php echo $a;?>" data-toggle = "modal">Reports</button>
                    <div class = "modal fade" id = "weeklyReport<?php echo $a;?>">
                        <div class = "modal-xl modal-dialog">
                            <form action = "<?php echo base_url();?>report/kpi/weekly/<?php echo $week[$a]["id_weeks"];?>" method = "POST">
                                <div class = "modal-content">
                                    <div class = "modal-header">
                                        <h4 class = "modal-title">CHECK WEEKLY REPORT</h4>
                                    </div>
                                    <div class = "modal-body">
                                        <div class = "row">
                                            <div class = "col-lg-9">
                                                <div class = "form-group">
                                                    <select class = "form-control" name = "user">
                                                        <option>Select Employee</option>
                                                        <?php for($b = 0; $b<count($employee); $b++):?>
                                                        <option value = "<?php echo $employee[$b]["id_user"];?>"><?php echo $employee[$b]["nama_user"];?></option>
                                                        <?php endfor;?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class = "col-lg-2">
                                                <div class = "form-group">
                                                    <button class = "btn btn-primary btn-outline" type = "submit">SEE REPORT</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </td>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
</div>
<div class = "modal fade" id = "insertweek">
    <div class = "modal-dialog modal-xl">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">REGISTER NEW WEEK</h4>
            </div>
            <form action = "<?php echo base_url();?>report/kpi/insertWeek" method = "POST">
                <div class = "modal-body">
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">New Week</h5>
                        <input type = "text" class = "form-control" readonly value = "WEEK <?php echo $maxId;?>">
                        <input type = "hidden" class = "form-control" readonly value = "<?php echo $maxId;?>" name = "week_id">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">Start Date</h5>
                        <input type = "date" class = "form-control" name = "start_date">
                    </div>
                    <div class = "form-group">
                        <h5 style = "opacity:0.5">End Date</h5>
                        <input type = "date" class = "form-control" name = "end_date">
                    </div>
                    <div class = "form-group">
                        <button class = "btn btn-primary btn-ouline col-lg-3">NEW WEEK</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>