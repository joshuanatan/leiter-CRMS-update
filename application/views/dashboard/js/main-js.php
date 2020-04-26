<script>
    (function (global, factory) {
    if (typeof define === "function" && define.amd) {
        define("/charts/chartjs", ["jquery", "Site"], factory);
    } else if (typeof exports !== "undefined") {
        factory(require("jquery"), require("Site"));
    } else {
        var mod = {
        exports: {}
        };
        factory(global.jQuery, global.Site);
        global.chartsChartjs = mod.exports;
    }
    })(this, function (_jquery, _Site) {
    "use strict";

    _jquery = babelHelpers.interopRequireDefault(_jquery);
    (0, _jquery.default)(document).ready(function ($$$1) {
        (0, _Site.run)();
    });
    Chart.defaults.global.responsive = true; // Example Chartjs Line
    // --------------------

    <?php
    $tahun = date("Y");
    $total_perbulan_1 = array("0,","0,","0,","0,","0,","0,","0,","0,","0,","0,","0,","0");
    for($a = 0; $a<count($po); $a++){
        for($bulan = 1; $bulan<= 12; $bulan++){
            if($po[$a]["bulan_oc"] == sprintf("%02d",$bulan)){
                if($tahun-0 == $po[$a]["tahun_oc"]){
                    $total_perbulan_1[$bulan-1] = $po[$a]["total"].",";
                }
            }
        }
    }
    $total_perbulan_2 = array("0,","0,","0,","0,","0,","0,","0,","0,","0,","0,","0,","0");
    for($a = 0; $a<count($po); $a++){
        for($bulan = 1; $bulan<= 12; $bulan++){
            if($po[$a]["bulan_oc"] == sprintf("%02d",$bulan)){
                if($tahun-1 == $po[$a]["tahun_oc"]){
                    $total_perbulan_2[$bulan-1] = ($po[$a]["total"]).",";
                }
            }
        }
    }
    $total_perbulan_3 = array("0,","0,","0,","0,","0,","0,","0,","0,","0,","0,","0,","0");
    for($a = 0; $a<count($po); $a++){
        for($bulan = 1; $bulan<= 12; $bulan++){
            if($po[$a]["bulan_oc"] == sprintf("%02d",$bulan)){
                if($tahun-2 == $po[$a]["tahun_oc"]){
                    $total_perbulan_3[$bulan-1] = ($po[$a]["total"]).",";
                }
            }
        }
    }
    ?>
    (function () {
        var warna = ["rgba(186, 107, 99, .8)","rgba(245, 223, 218, .8)","rgba(117, 96, 99, .8)"];
        var warna2 = ["rgba(186, 107, 99, .6)","rgba(245, 223, 218, .6)","rgba(117, 96, 99, .6)"];
        var counter = 0;
        var barChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July","Agst","September","October","November","December"],
            datasets: [
                {
                    label: <?php echo $tahun-0;?>,
                    backgroundColor: warna[0],
                    borderColor: warna2[0],
                    hoverBackgroundColor: "rgba(186, 107, 99, .4)",
                    borderWidth: 2,
                    data: [
                        <?php 
                        for($a = 0; $a<count($total_perbulan_1); $a++){
                            echo $total_perbulan_1[$a];
                        }   
                        ?>
                    ]
                },
                {
                    label: <?php echo $tahun-1;?>,
                    backgroundColor: warna[1],
                    borderColor: warna2[1],
                    hoverBackgroundColor: "rgba(245, 223, 218, .4)",
                    borderWidth: 2,
                    data: [
                        <?php 
                        for($a = 0; $a<count($total_perbulan_2); $a++){
                            echo $total_perbulan_2[$a];
                        }   
                        ?>
                    ] 
                }, 
                {
                    label: <?php echo $tahun-2;?>,
                    backgroundColor: warna[2],
                    borderColor: warna2[2],
                    hoverBackgroundColor: "rgba(117, 96, 99, .4)",
                    borderWidth: 2,
                    data: [
                        <?php 
                        for($a = 0; $a<count($total_perbulan_3); $a++){
                            echo $total_perbulan_3[$a];
                        }   
                        ?>
                    ] 
                }
                
            ]
        };
        var myBar = new Chart(document.getElementById("exampleChartjsBar2").getContext("2d"), {
        type: 'bar',
        data: barChartData,
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    display: true
                }],
                yAxes: [{
                    display: true
                }]
            }
        }
        });
    })();
    <?php
    $nama_customer_1 = array("-","-","-","-","-","-","-","-","-","-");
    $nama_customer_2 = array("-","-","-","-","-","-","-","-","-","-");
    $nama_customer_3 = array("-","-","-","-","-","-","-","-","-","-");

    $order_1 = array("0","0","0","0","0","0","0","0","0","0");
    $order_2 = array("0","0","0","0","0","0","0","0","0","0");
    $order_3 = array("0","0","0","0","0","0","0","0","0","0");

    $counter1 = 0;
    $counter2 = 0;
    $counter3 = 0;
    for($a = 0; $a<count($customer_order); $a++){
        if(($tahun-0) == $customer_order[$a]["tahun_oc"]){
            //echo "counter1 ".$counter1."\n";
            $nama_customer_1[$counter1] = $customer_order[$a]["nama_perusahaan"];
            $order_1[$counter1] = ($customer_order[$a]["total_oc"]);
            $counter1++;
        }
        if(($tahun-1) == $customer_order[$a]["tahun_oc"]){
           // echo "counter2 ".$counter2."\n";
            $nama_customer_2[$counter2] = $customer_order[$a]["nama_perusahaan"];
            $order_2[$counter2] = ($customer_order[$a]["total_oc"]);
            $counter2++;
        }
        if(($tahun-2) == $customer_order[$a]["tahun_oc"]){
           // echo "counter3 ".$counter3."\n";
            $nama_customer_3[$counter3] = $customer_order[$a]["nama_perusahaan"];
            $order_3[$counter3] = ($customer_order[$a]["total_oc"]);
            $counter3++;
        }
    }
    /*
    print_r($nama_customer_1);
    print_r($nama_customer_2);
    print_r($nama_customer_3);
    print_r($order_1);
    print_r($order_2);
    print_r($order_3);
    */
    ?>
    (function () {
        var warna = [
            "rgba(186, 107, 99, .8)",
            "rgba(245, 223, 218, .8)",
            "rgba(117, 96, 99, .8)",
            "rgba(34, 49, 63, .8)",
            "rgba(65, 131, 215, .8)",
            "rgba(31, 58, 147, .8)",
            "rgba(77, 175, 124, .8)",
            "rgba(46, 204, 113, .8)",
            "rgba(102, 204, 153, .8)",
            "rgba(104, 195, 163, .8)",
        ];
        var warna2 = [
            "rgba(186, 107, 99, .6)",
            "rgba(245, 223, 218, .6)",
            "rgba(117, 96, 99, .6)",
            "rgba(34, 49, 63, .6)",
            "rgba(65, 131, 215, .6)",
            "rgba(31, 58, 147, .6)",
            "rgba(77, 175, 124, .6)",
            "rgba(46, 204, 113, .6)",
            "rgba(102, 204, 153, .6)",
            "rgba(104, 195, 163, .6)",
        ];
        var warna3 = [
            "rgba(186, 107, 99, .4)",
            "rgba(245, 223, 218, .4)",
            "rgba(117, 96, 99, .4)",
            "rgba(34, 49, 63, .4)",
            "rgba(65, 131, 215, .4)",
            "rgba(31, 58, 147, .4)",
            "rgba(77, 175, 124, .4)",
            "rgba(46, 204, 113, .4)",
            "rgba(102, 204, 153, .4)",
            "rgba(104, 195, 163, .4)",
        ];
        var barChartData = {
        labels: ["<?php echo $tahun;?>","<?php echo $tahun-1;?>","<?php echo $tahun-2;?>"],
        datasets: [
            {
                label: ["<?php echo $nama_customer_1[0];?>", "<?php echo $nama_customer_2[0];?>", "<?php echo $nama_customer_3[0];?>"],
                backgroundColor: warna[0],
                borderColor: warna2[0],
                hoverBackgroundColor: warna3[0],
                borderWidth: 2,
                data: [<?php echo $order_1[0];?>, <?php echo $order_2[0];?>, <?php echo $order_3[0];?>]
            }, 
            {
                label: ["<?php echo $nama_customer_1[1];?>", "<?php echo $nama_customer_2[1];?>", "<?php echo $nama_customer_3[1];?>"],
                backgroundColor: warna[1],
                borderColor: warna2[1],
                hoverBackgroundColor: warna3[1],
                borderWidth: 2,
                data: [<?php echo $order_1[1];?>, <?php echo $order_2[1];?>, <?php echo $order_3[1];?>]
            }, 
            {
                label: ["<?php echo $nama_customer_1[2];?>", "<?php echo $nama_customer_2[2];?>", "<?php echo $nama_customer_3[2];?>"],
                backgroundColor: warna[2],
                borderColor: warna2[2],
                hoverBackgroundColor: warna3[2],
                borderWidth: 2,
                data: [<?php echo $order_1[2];?>, <?php echo $order_2[2];?>, <?php echo $order_3[2];?>]
            }, 
            {
                label: ["<?php echo $nama_customer_1[3];?>", "<?php echo $nama_customer_2[3];?>", "<?php echo $nama_customer_3[3];?>"],
                backgroundColor: warna[3],
                borderColor: warna2[3],
                hoverBackgroundColor: warna3[3],
                borderWidth: 2,
                data: [<?php echo $order_1[3];?>, <?php echo $order_2[3];?>, <?php echo $order_3[3];?>]
            }, 
            {
                label: ["<?php echo $nama_customer_1[4];?>", "<?php echo $nama_customer_2[4];?>", "<?php echo $nama_customer_3[4];?>"],
                backgroundColor: warna[4],
                borderColor: warna2[4],
                hoverBackgroundColor: warna3[4],
                borderWidth: 2,
                data: [<?php echo $order_1[4];?>, <?php echo $order_2[4];?>, <?php echo $order_3[4];?>]
            },
            {
                label: ["<?php echo $nama_customer_1[5];?>", "<?php echo $nama_customer_2[5];?>", "<?php echo $nama_customer_3[5];?>"],
                backgroundColor: warna[5],
                borderColor: warna2[5],
                hoverBackgroundColor: warna3[5],
                borderWidth: 2,
                data: [<?php echo $order_1[5];?>, <?php echo $order_2[5];?>, <?php echo $order_3[5];?>]
            }, 
            {
                label: ["<?php echo $nama_customer_1[6];?>", "<?php echo $nama_customer_2[6];?>", "<?php echo $nama_customer_3[6];?>"],
                backgroundColor: warna[6],
                borderColor: warna2[6],
                hoverBackgroundColor: warna3[6],
                borderWidth: 2,
                data: [<?php echo $order_1[6];?>, <?php echo $order_2[6];?>, <?php echo $order_3[6];?>]
            }, 
            {
                label: ["<?php echo $nama_customer_1[7];?>", "<?php echo $nama_customer_2[7];?>", "<?php echo $nama_customer_3[7];?>"],
                backgroundColor: warna[7],
                borderColor: warna2[7],
                hoverBackgroundColor: warna3[7],
                borderWidth: 2,
                data: [<?php echo $order_1[7];?>, <?php echo $order_2[7];?>, <?php echo $order_3[7];?>]
            }, 
            {
                label: ["<?php echo $nama_customer_1[8];?>", "<?php echo $nama_customer_2[8];?>", "<?php echo $nama_customer_3[8];?>"],
                backgroundColor: warna[8],
                borderColor: warna2[8],
                hoverBackgroundColor: warna3[8],
                borderWidth: 2,
                data: [<?php echo $order_1[8];?>, <?php echo $order_2[8];?>, <?php echo $order_3[8];?>]
            }, 
            {
                label: ["<?php echo $nama_customer_1[9];?>", "<?php echo $nama_customer_2[9];?>", "<?php echo $nama_customer_3[9];?>"],
                backgroundColor: warna[9],
                borderColor: warna2[9],
                hoverBackgroundColor: warna3[9],
                borderWidth: 2,
                data: [<?php echo $order_1[9];?>, <?php echo $order_2[9];?>, <?php echo $order_3[9];?>]
            }
        ]
        };
        var myBar = new Chart(document.getElementById("exampleChartjsBar3").getContext("2d"), {
        type: 'bar',
        data: barChartData,
        options: {
            responsive: true,
            scales: {
            xAxes: [{
                display: true
            }],
            yAxes: [{
                display: true
            }]
            }
        }
        });
    })(); // Example Chartjs Radar
    <?php
    $tahun = date("Y");
    $total_perbulan_1 = array("0,","0,","0,","0,","0,","0,","0,","0,","0,","0,","0,","0");
    for($a = 0; $a<count($penghasilan); $a++){
        for($bulan = 1; $bulan<= 12; $bulan++){
            if($penghasilan[$a]["bulan_invoice"] == sprintf("%02d",$bulan)){
                if($tahun-0 == $penghasilan[$a]["tahun_invoice"]){
                    $total_perbulan_1[$bulan-1] = $penghasilan[$a]["total"].",";
                }
            }
        }
    }
    $total_perbulan_2 = array("0,","0,","0,","0,","0,","0,","0,","0,","0,","0,","0,","0");
    for($a = 0; $a<count($penghasilan); $a++){
        for($bulan = 1; $bulan<= 12; $bulan++){
            if($penghasilan[$a]["bulan_invoice"] == sprintf("%02d",$bulan)){
                if($tahun-1 == $penghasilan[$a]["tahun_invoice"]){
                    $total_perbulan_2[$bulan-1] = ($penghasilan[$a]["total"]).",";
                }
            }
        }
    }
    $total_perbulan_3 = array("0,","0,","0,","0,","0,","0,","0,","0,","0,","0,","0,","0");
    for($a = 0; $a<count($penghasilan); $a++){
        for($bulan = 1; $bulan<= 12; $bulan++){
            if($penghasilan[$a]["bulan_invoice"] == sprintf("%02d",$bulan)){
                if($tahun-2 == $penghasilan[$a]["tahun_invoice"]){
                    $total_perbulan_3[$bulan-1] = ($penghasilan[$a]["total"]).",";
                }
            }
        }
    }
    ?>
    (function () {
        var warna = ["rgba(186, 107, 99, .8)","rgba(245, 223, 218, .8)","rgba(117, 96, 99, .8)"];
        var warna2 = ["rgba(186, 107, 99, .6)","rgba(245, 223, 218, .6)","rgba(117, 96, 99, .6)"];
        var counter = 0;
        var barChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July","Agst","September","October","November","December"],
            datasets: [
                {
                    label: <?php echo $tahun-0;?>,
                    backgroundColor: warna[0],
                    borderColor: warna2[0],
                    hoverBackgroundColor: "rgba(186, 107, 99, .4)",
                    borderWidth: 2,
                    data: [
                        <?php 
                        for($a = 0; $a<count($total_perbulan_1); $a++){
                            echo $total_perbulan_1[$a];
                        }   
                        ?>
                    ]
                },
                {
                    label: <?php echo $tahun-1;?>,
                    backgroundColor: warna[1],
                    borderColor: warna2[1],
                    hoverBackgroundColor: "rgba(245, 223, 218, .4)",
                    borderWidth: 2,
                    data: [
                        <?php 
                        for($a = 0; $a<count($total_perbulan_2); $a++){
                            echo $total_perbulan_2[$a];
                        }   
                        ?>
                    ] 
                }, 
                {
                    label: <?php echo $tahun-2;?>,
                    backgroundColor: warna[2],
                    borderColor: warna2[2],
                    hoverBackgroundColor: "rgba(117, 96, 99, .4)",
                    borderWidth: 2,
                    data: [
                        <?php 
                        for($a = 0; $a<count($total_perbulan_3); $a++){
                            echo $total_perbulan_3[$a];
                        }   
                        ?>
                    ] 
                }
                
            ]
        };
        var myBar = new Chart(document.getElementById("exampleChartjsBar").getContext("2d"), {
        type: 'bar',
        data: barChartData,
        options: {
            responsive: true,
            scales: {
            xAxes: [{
                display: true
            }],
            yAxes: [{
                display: true
            }]
            }
        }
        });
    })(); // Example Chartjs Radar
    // --------------------
});
</script>
