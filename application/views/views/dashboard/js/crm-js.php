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
    $win_array = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $loss_array = array(0,0,0,0,0,0,0,0,0,0,0,0);

    for($a = 0; $a<count($win); $a++){
        $win_array[$win[$a]["bulan_quotation"]-1] = $win[$a]["quotation_win"];
    }
    for($a = 0; $a<count($loss); $a++){
        $loss_array[$loss[$a]["bulan_quotation"]-1] = $loss[$a]["quotation_loss"];
    }
    ?>
    (function () {
        var barChartData = {
        labels: ["January", "February", "March", "April", "May", "June", "July","Agst","September","October","November","December"],
        datasets: [{
            label: "Quotation",
            backgroundColor: "rgba(204, 213, 219, .2)",
            borderColor: Config.colors("blue-grey", 300),
            hoverBackgroundColor: "rgba(204, 213, 219, .3)",
            borderWidth: 2,
            data: [
                <?php for($a = 0; $a<12; $a++){
                    echo $win_array[$a]+$loss_array[$a];
                    if($a != 11){
                        echo ",";
                    }
                }
                ?>
            ]
        }, {
            label: "Win",
            backgroundColor: "rgba(98, 168, 234, .2)",
            borderColor: Config.colors("primary", 600),
            hoverBackgroundColor: "rgba(98, 168, 234, .3)",
            borderWidth: 2,
            data: [
                <?php for($a = 0; $a<12; $a++){
                    echo $win_array[$a];
                    if($a != 11){
                        echo ",";
                    }
                }
                ?>
            ]
        }, {
            label: "Loss",
            backgroundColor: "rgba(98, 168, 234, .2)",
            borderColor: Config.colors("primary", 600),
            hoverBackgroundColor: "rgba(98, 168, 234, .3)",
            borderWidth: 2,
            data: [
                <?php for($a = 0; $a<12; $a++){
                    echo $loss_array[$a];
                    if($a != 11){
                        echo ",";
                    }
                }
                ?>
            ]
        }]
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
    <?php
    $rfq_array = array(0,0,0,0,0,0,0,0,0,0,0,0);
    for($a = 0; $a<count($rfq);$a++){
        if($rfq[$a]["jumlah_rfq"] != ""){
            $rfq_array[$rfq[$a]["bulan_request"]-1] = $rfq[$a]["jumlah_rfq"];
        }
    }
    ?>
    (function () {
        var barChartData = {
        labels: ["January", "February", "March", "April", "May", "June", "July","Agst","September","October","November","December"],
        datasets: [
            {
                label: "Incoming RFQ",
                backgroundColor: "rgba(204, 213, 219, .2)",
                borderColor: Config.colors("blue-grey", 300),
                hoverBackgroundColor: "rgba(204, 213, 219, .3)",
                borderWidth: 2,
                data: [
                    <?php for($a = 0; $a<12; $a++){
                        echo $rfq_array[$a];
                        if($a != 11){
                            echo ",";
                        }  
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
    

});
</script>