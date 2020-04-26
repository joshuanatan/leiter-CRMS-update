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
                                    <span class="counter-number" style = "font-size:18px"><?php echo $jumlah_reimburse_terima;?> - <?php echo number_format($total_reimburse_terima,2);?></span><br/>
                                    <span class="counter-number-related text-capitalize">Cash Accepted</span>
                                </div>
                                <div class="counter-label text-capitalize font-size-16"><?php echo date("M")."/".date("Y");?></div>
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
                                    <span class="counter-number" style = "font-size:18px"><?php echo $jumlah_reimburse_tunggu;?> - <?php echo number_format($total_reimburse_tunggu,2);?></span><br/>
                                    <span class="counter-number-related text-capitalize">Reimburse Requested</span>
                                </div>
                                <div class="counter-label text-capitalize font-size-16"><?php echo date("M")."/".date("Y");?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-lg">
                    <div class="col-lg-12 col-xl-12">
                    <!-- Example Bar -->
                        <div class="example-wrap">
                            <h4 class="example-title">KPI</h4>
                            <div class="example text-center">
                                <canvas id="exampleChartjsBar" style = "width:100%"></canvas>
                            </div>
                        </div>
                    <!-- End Example Bar -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Panel -->
    </div>
</div>