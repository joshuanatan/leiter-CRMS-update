<?php
$tahun = date("Y");
?>
<div class="page">
    <div class="page-content">
        <!-- Panel -->
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card p-30 flex-row justify-content-between">
                            <div class="white">
                                <i class="icon icon-circle icon-2x wb-order bg-green-600" aria-hidden="true"></i>
                            </div>
                            <div class="counter counter-md counter text-right">
                                <div class="counter-number-group">
                                    <span class="counter-number" style = "font-size:18px"><?php echo $rfq_no_quotation[0]["jumlah_request_belom_quotation"];?></span><br/>
                                    <span class="counter-number-related text-capitalize">Not-Quoted RFQ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card p-30 flex-row justify-content-between">
                            <div class="white">
                                <i class="icon icon-circle icon-2x wb-clipboard bg-purple-600" aria-hidden="true"></i>
                            </div>
                            <div class="counter counter-md counter text-right">
                                <div class="counter-number-group">
                                    <span class="counter-number" style = "font-size:18px"><?php echo $followup_quotation[0]["jumlah_quotation_followup"];?></span><br/>
                                    <span class="counter-number-related text-capitalize">Follow Up Quotation</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row row-lg">
                    <div class="col-lg-12 col-xl-12">
                    <!-- Example Bar -->
                        <div class="example-wrap">
                            <h4 class="example-title">Quotation Win-Loss <?php echo $tahun;?></h4>
                            <div class="example text-center">
                                <canvas id="exampleChartjsBar" style = "width:100%"></canvas>
                            </div>
                        </div>
                    <!-- End Example Bar -->
                    </div>

                    <div class="col-lg-12 col-xl-12">
                    <!-- Example Bar -->
                        <div class="example-wrap">
                            <h4 class="example-title">INCOMING RFQ <?php echo $tahun;?></h4>
                            <div class="example text-center">
                                <canvas id="exampleChartjsBar2" style = "width:100%"></canvas>
                            </div>
                        </div>
                    <!-- End Example Bar -->
                    </div>
                    
                </div>
                <div class="row row-lg">
                    <div class="col-lg-12 col-xl-12">
                    <!-- Example Bar -->
                        <div class="example-wrap">
                            <h4 class="example-title">Quotation Mendekati Jatuh Tempo</h4>
                            <table class = "table table-striped table-hover table-bordered" data-plugin = "DataTable">
                                <thead>
                                    <th>No Quotation</th>
                                    <th>Customer Name</th>
                                    <th>Harga Quotation</th>
                                    <th>Tanggal Buat</th>
                                    <th>Days Remaining</th>
                                    <th>Dateline Quotation</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php for($a = 0; $a<count($quotation); $a++):?>
                                    <tr>
                                        <td>
                                            <?php echo $quotation[$a]["no_quotation"];?>
                                        </td>
                                        <td><?php echo $quotation[$a]["nama_perusahaan"];?></td>
                                        <td><?php echo number_format($quotation[$a]["total_quotation_price"],2);?></td>
                                        <td><?php $date = date_create($quotation[$a]["date_quotation_add"]); echo date_format($date,"d-m-Y");?></td>
                                        <td>
                                            <?php if($quotation[$a]["waktu_jatuh_tempo"] < 0):?>
                                            <button class = "btn col-lg-12 btn-danger btn-sm"><?php echo abs($quotation[$a]["waktu_jatuh_tempo"]);?> Days</button>
                                            <?php else:?>
                                            <button class = "btn col-lg-12 btn-warning btn-sm"><?php echo abs($quotation[$a]["waktu_jatuh_tempo"]);?> Days</button>
                                            <?php endif;?>
                                        </td>
                                        <form action = "<?php echo base_url();?>welcome/updateJatuhTempoQuotationCustomer" method = "POST">
                                        <td>
                                            <input type = "hidden" name = "id_submit_quotation" value = "<?php echo $quotation[$a]["id_submit_quotation"];?>">
                                            <input type = "date" class = "form-control" name = "updateTanggal<?php echo $quotation[$a]["id_submit_quotation"]; ?>" value = "<?php echo $quotation[$a]["dateline_quotation"];?>">
                                        </td>
                                        <td>
                                            <button type = "submit" class = "btn btn-primary btn-sm col-lg-12">Extend</button>
                                        </td>
                                        </form>
                                    </tr>
                                    <?php endfor;?>
                                </tbody>
                            </table>
                        </div>
                    <!-- End Example Bar -->
                    </div>

                    <div class="col-lg-12 col-xl-12">
                    <!-- Example Bar -->
                        <div class="example-wrap">
                            <h4 class="example-title">PO Mendekati Jatuh Tempo</h4>
                            <table class = "table table-striped table-hover table-bordered" data-plugin = "DataTable">
                                <thead>
                                    <th>No PO</th>
                                    <th>Nama Supplier</th>
                                    <th>Nama Shipper</th>
                                    <th>Destination</th> 
                                    <th>Tanggal Buat PO</th> 
                                    <th>Days Remaining</th>
                                    <th>Requirement Date</th>
                                    <th>Update</th>
                                </thead>
                                <tbody>
                                    <?php for($a = 0; $a<count($po); $a++):?>
                                    <tr>
                                        <td><?php echo $po[$a]["no_po"];?></td>
                                        <td><?php echo $po[$a]["nama_supplier"];?></td>
                                        <td><?php echo $po[$a]["nama_shipper"];?></td>
                                        <td><?php echo $po[$a]["destination"];?></td>
                                        <td><?php $date = date_create($po[$a]["date_po_core_add"]); echo date_format($date,"d-m-Y");?></td>
                                        <td>
                                            <?php if($po[$a]["waktu_jatuh_tempo"] < 0):?>
                                            <button class = "btn col-lg-12 btn-danger btn-sm"><?php echo abs($po[$a]["waktu_jatuh_tempo"]);?> Days</button>
                                            <?php else:?>
                                            <button class = "btn col-lg-12 btn-warning btn-sm"><?php echo abs($po[$a]["waktu_jatuh_tempo"]);?> Days</button>
                                            <?php endif;?>
                                        </td>
                                        <form action = "<?php echo base_url();?>welcome/updateJatuhTempoPo" method = "POST">
                                        <td>
                                            <input type = "hidden" name = "id_submit_po" value = "<?php echo $po[$a]["id_submit_po"];?>">
                                            <input type = "date" class = "form-control" name = "updateTanggal<?php echo $po[$a]["id_submit_po"];?>" value = "<?php echo $po[$a]["requirement_date"];?>"></td>
                                        <td>
                                            <button type = "submit" class = "btn btn-primary btn-sm col-lg-12">EXTEND</button>
                                        </td>
                                        </form>
                                    </tr>
                                    <?php endfor;?>
                                </tbody>
                            </table>
                        </div>
                    <!-- End Example Bar -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Panel -->
    </div>
</div>