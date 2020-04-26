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
    $uang_masuk = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $uang_keluar = array(0,0,0,0,0,0,0,0,0,0,0,0);
    for($a = 0; $a<count($uang_masuk_bulanan); $a++){
        $uang_masuk[$uang_masuk_bulanan[$a]["bulan_transaksi"]-1] = abs($uang_masuk_bulanan[$a]["total_pembayaran"]);
        
    }
    for($a = 0; $a<count($uang_keluar_bulanan); $a++){
        $uang_keluar[$uang_keluar_bulanan[$a]["bulan_transaksi"]-1] = abs($uang_keluar_bulanan[$a]["total_pembayaran"]);
    }
    ?>
    (function () {
        var barChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July","Agst","September","October","November","December"],
            datasets: [
                {
                label: "Uang Masuk",
                backgroundColor: "rgba(186, 107, 99, .8)",
                borderColor: "rgba(186, 107, 99, .6)",
                hoverBackgroundColor: "rgba(186, 107, 99, .4)",
                borderWidth: 2,
                data: [
                    <?php 
                    for($a = 0; $a<count($uang_masuk); $a++){
                        echo $uang_masuk[$a];
                        if(($a+1) != count($uang_masuk)){
                            echo ",";
                        }
                    }
                    ?>]
                }, 
                {
                label: "Uang Keluar",
                backgroundColor: "rgba(245, 223, 218, .8)",
                borderColor: "rgba(245, 223, 218, .6)",
                hoverBackgroundColor: "rgba(245, 223, 218, .4)",
                borderWidth: 2,
                data: [
                    <?php 
                    for($a = 0; $a<count($uang_keluar); $a++){
                        echo $uang_keluar[$a];
                        if(($a+1) != count($uang_keluar)){
                            echo ",";
                        }
                    }
                    ?>
                    ]
                },
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
    })(); 
    
    <?php
    $year = date("Y");
    $selisih_1 = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $selisih_2 = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $selisih_3 = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $jual_1 = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $jual_2 = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $jual_3 = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $margin1 = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $margin2 = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $margin3 = array(0,0,0,0,0,0,0,0,0,0,0,0);

    for($a = 0; $a<count($selisih_untuk_margin); $a++){
        if($selisih_untuk_margin[$a]["tahun_transaksi"] == $year-0){
            $selisih_1[$selisih_untuk_margin[$a]["bulan_transaksi"]-1] = $selisih_untuk_margin[$a]["selisih"];
        }
        else if($selisih_untuk_margin[$a]["tahun_transaksi"] == $year-1){
            $selisih_2[$selisih_untuk_margin[$a]["bulan_transaksi"]-1] = $selisih_untuk_margin[$a]["selisih"];
        }
        else if($selisih_untuk_margin[$a]["tahun_transaksi"] == $year-2){
            $selisih_3[$selisih_untuk_margin[$a]["bulan_transaksi"]-1] = $selisih_untuk_margin[$a]["selisih"];
        }
    }
    for($a = 0; $a<count($jual_untuk_margin); $a++){

        if($jual_untuk_margin[$a]["tahun_transaksi"] == $year-0 && $jual_untuk_margin[$a]["bulan_transaksi"]-1 >=0 && $jual_untuk_margin[$a]["bulan_transaksi"]-1 <=11){
            $jual_1[$jual_untuk_margin[$a]["bulan_transaksi"]-1] = $jual_untuk_margin[$a]["jual"];
        }
        else if($jual_untuk_margin[$a]["tahun_transaksi"] == $year-1 && $jual_untuk_margin[$a]["bulan_transaksi"]-1 >=0 && $jual_untuk_margin[$a]["bulan_transaksi"]-1 <=11){
            $jual_2[$jual_untuk_margin[$a]["bulan_transaksi"]-1] = $jual_untuk_margin[$a]["jual"];
        }
        else if($jual_untuk_margin[$a]["tahun_transaksi"] == $year-2 && $jual_untuk_margin[$a]["bulan_transaksi"]-1 >=0 && $jual_untuk_margin[$a]["bulan_transaksi"]-1 <=11){
            $jual_3[$jual_untuk_margin[$a]["bulan_transaksi"]-1] = $jual_untuk_margin[$a]["jual"];
        }
    }
    for($a = 0; $a<12 ; $a++){
        if($jual_1[$a] != 0){
            $margin1[$a] = ($jual_1[$a]+$selisih_1[$a])/$jual_1[$a]*100; // dijumlah karena dari dbnya udah mines
        }
        if($jual_2[$a] != 0){
            $margin2[$a] = ($jual_2[$a]+$selisih_2[$a])/$jual_2[$a]*100; // dijumlah karena dari dbnya udah mines

        }
        if($jual_3[$a] != 0){
            $margin3[$a] = ($jual_3[$a]+$selisih_3[$a])/$jual_3[$a]*100; // dijumlah karena dari dbnya udah mines
        }
    }
    /*
    print_r($selisih_1);
    print_r($selisih_2);
    print_r($jual_1);
    print_r($jual_2);
    print_r($margin1);
    print_r($margin2);
    */
    ?>
    (function () {
        var barChartData = {
        labels: ["January", "February", "March", "April", "May", "June", "July","Agst","September","October","November","December"],
        datasets: [
            {
            label: <?php echo $year-0;?>,
            backgroundColor: "rgba(186, 107, 99, .8)",
            borderColor: "rgba(186, 107, 99, .6)",
            hoverBackgroundColor: "rgba(186, 107, 99, .4)",
            borderWidth: 2,
            data: [
                <?php 
                for($a = 0; $a<count($margin1); $a++){
                    echo $margin1[$a];
                    if(($a+1) != count($margin1)){
                        echo ",";
                    }
                }
                ?>]
            }, 
            {
            label: <?php echo $year-1;?>,
            backgroundColor: "rgba(245, 223, 218, .8)",
            borderColor: "rgba(245, 223, 218, .6)",
            hoverBackgroundColor: "rgba(245, 223, 218, .4)",
            borderWidth: 2,
            data: [
                <?php 
                for($a = 0; $a<count($margin2); $a++){
                    echo $margin2[$a];
                    if(($a+1) != count($margin2)){
                        echo ",";
                    }
                }
                ?>
                ]
            }, 
            {
            label: <?php echo $year-2;?>,
            backgroundColor: "rgba(117, 96, 99, .8)",
            borderColor: "rgba(117, 96, 99, .8)",
            hoverBackgroundColor: "rgba(117, 96, 99, .8)",
            borderWidth: 2,
            data: [
                <?php 
                for($a = 0; $a<count($margin3); $a++){
                    echo $margin3[$a];
                    if(($a+1) != count($margin3)){
                        echo ",";
                    }
                }
                ?>
                ]
            },
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
    })(); // Example Chartjs Radar
    // --------------------

});
</script>