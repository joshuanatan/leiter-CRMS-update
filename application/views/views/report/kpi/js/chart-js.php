<?php //print_r($kpi_graph);?>
<?php $backgroundColor = array(
    "rgba(200, 247, 197, 1)",
    "rgba(123, 239, 178, 1)",
    "rgba(228, 241, 254, 1)",
    "rgba(82, 179, 217, 1)",
    "rgba(255, 148, 120, 1)",
    "rgba(207, 0, 15, 1)"
);?>
<?php $hoverBackgroundColor = array(
    "rgba(200, 247, 197, .8)",
    "rgba(123, 239, 178, .8)",
    "rgba(228, 241, 254, .8)",
    "rgba(82, 179, 217, .8)",
    "rgba(255, 148, 120, .8)",
    "rgba(207, 0, 15, .8)"
);?>
<?php $borderColor = array(
    "rgba(200, 247, 197, .6)",
    "rgba(123, 239, 178, .6)",
    "rgba(228, 241, 254, .6)",
    "rgba(82, 179, 217, .6)",
    "rgba(255, 148, 120, .6)",
    "rgba(207, 0, 15, .6)"
);?>


<script>
(function (global, factory) {
    if (typeof define === "function" && define.amd) {
        define("/widgets/chart", ["jquery", "Site"], factory);
    } 
    else if (typeof exports !== "undefined") {
        factory(require("jquery"), require("Site"));
    } 
    else {
        var mod = {
            exports: {}
        };
        factory(global.jQuery, global.Site);
        global.widgetsChart = mod.exports;
    }
})
(this, function (_jquery, _Site) {
    "use strict";

    _jquery = babelHelpers.interopRequireDefault(_jquery);
    
});
</script>
<script>
(function (global, factory) {
    if (typeof define === "function" && define.amd) {
        define("/charts/chartjs", ["jquery", "Site"], factory);
    } 
    else if (typeof exports !== "undefined") {
        factory(require("jquery"), require("Site"));
    } 
    else {
        var mod = {
            exports: {}
        };
        factory(global.jQuery, global.Site);
        global.chartsChartjs = mod.exports;
    }
    })(this, function (_jquery, _Site) {
    "use strict";
    _jquery = babelHelpers.interopRequireDefault(_jquery);
    <?php
    $label_kpi = array();
    for($a = 0; $a<count($week); $a++){
        $label_kpi[$a] = $week[$a];
    }
    ?>
    (function () {
        var barChartData = {
            
            labels: [
                <?php for($a = 0; $a<count($kpi_user); $a++){
                    echo '"'.$kpi_user[$a]["kpi"].'"';
                    if($a+1 != count($kpi_user)){
                        echo ",";
                    }
                }
                ?>
            ],
            datasets: 
            [
                { /*Target*/
                    label: "TARGET",
                    backgroundColor: "<?php echo $backgroundColor[0];?>",
                    borderColor: "<?php echo $borderColor[0];?>",
                    hoverBackgroundColor: "<?php echo $hoverBackgroundColor[0];?>",
                    borderWidth: 2,
                    data: [
                    <?php for($a = 0; $a<count($kpi_user); $a++){
                        echo $kpi_user[$a]["target_kpi"];
                        if($a+1 != count($kpi_user)){
                            echo ",";
                        }
                    }
                    ?>
                    ] /*TARGET KPI1, TARGET KPI2, TARGET KPI3*/
                }, 
                
                <?php for($week = 0; $week < count($kpi_graph); $week++):?>
                { /*week 1- sekian*/
                    label: "Week <?php echo $detail["id_week"]-$week;?>",
                    backgroundColor: "<?php echo $backgroundColor[($week+1)];?>",
                    borderColor: "<?php echo $borderColor[($week+1)];?>",
                    hoverBackgroundColor: "<?php echo $hoverBackgroundColor[($week+1)];?>",
                    borderWidth: 2,
                    data: [
                    <?php 
                    $amount = array();
                    for($kpi = 0; $kpi<count($kpi_user); $kpi++){
                        echo $kpi_graph[$week][$kpi]["report"];
                        if($kpi+1 != count($kpi_user)){
                            echo ",";
                        }
                    }
                    ?>
                    ]
                }, 
                <?php endfor;?>
            ]
        };
        var myBar = new Chart(document.getElementById("kpiGraph").getContext("2d"), {
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