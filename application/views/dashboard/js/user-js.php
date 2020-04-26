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
    $nama_kpi = array();
    $target_kpi = array();
    $report_array = array();
    for($a = 0; $a<count($kpi); $a++){
        $nama_kpi[$a] = $kpi[$a]["kpi"];
        $target_kpi[$a] = $kpi[$a]["target_kpi"];
        $report_array[$a] = 0;
    }
    for($b = 0; $b<count($report); $b++){
        for($a = 0; $a<count($nama_kpi); $a++){
            if($nama_kpi[$a] == $report[$b]["tipe_report"]){
                $report_array[$a] = $report[$b]["jumlah_report"];
            }
        }
    }
    ?>
    (function () {
        var barChartData = {
        labels: [
            <?php for($a = 0; $a<count($nama_kpi); $a++){
                echo '"'.$nama_kpi[$a].'"';
                if($a+1 != count($nama_kpi)){
                    echo ",";
                }
            }
            ?>
        ],
        datasets: [{
            label: "Target",
            backgroundColor: "rgba(204, 213, 219, .2)",
            borderColor: Config.colors("blue-grey", 300),
            hoverBackgroundColor: "rgba(204, 213, 219, .3)",
            borderWidth: 2,
            data: [
                <?php for($a = 0; $a<count($target_kpi); $a++){
                    echo $target_kpi[$a];
                    if($a+1 != count($target_kpi)){
                        echo ",";
                    }
                }   
                ?> 
            ]
        }, {
            label: "Report",
            backgroundColor: "rgba(98, 168, 234, .2)",
            borderColor: Config.colors("primary", 600),
            hoverBackgroundColor: "rgba(98, 168, 234, .3)",
            borderWidth: 2,
            data: [
                <?php for($a = 0; $a<count($report_array); $a++){
                    echo $report_array[$a];
                    if($a+1 != count($report_array)){
                        echo ",";
                    }
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