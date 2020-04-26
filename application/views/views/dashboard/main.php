<?php
$tahun = date("Y");
?>
<div class="page">
    <div class="page-content">
        <!-- Panel -->
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-lg-12 col-xl-12">
                    <!-- Example Bar -->
                        <div class="example-wrap">
                            <h4 class="example-title">SALES <?php echo $tahun-0;?>-<?php echo $tahun-1;?>-<?php echo $tahun-2;?></h4>
                            <div class="example text-center">
                                <canvas id="exampleChartjsBar" style = "width:100%"></canvas>
                            </div>
                        </div>
                    <!-- End Example Bar -->
                    </div>

                    <div class="col-lg-12 col-xl-12">
                    <!-- Example Bar -->
                        <div class="example-wrap">
                            <h4 class="example-title">INCOMING PURCHASE ORDER <?php echo $tahun-0;?>-<?php echo $tahun-1;?>-<?php echo $tahun-2;?></h4>
                            <div class="example text-center">
                                <canvas id="exampleChartjsBar2" style = "width:100%"></canvas>
                            </div>
                        </div>
                    <!-- End Example Bar -->
                    </div>
                    <div class="col-lg-12 col-xl-12">
                    <!-- Example Bar -->
                        <div class="example-wrap">
                            <h4 class="example-title">TOP 10 CUSTOMER</h4>
                            <div class="example text-center">
                                <canvas id="exampleChartjsBar3" style = "width:100%"></canvas>
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