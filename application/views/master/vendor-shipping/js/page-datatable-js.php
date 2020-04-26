<script src="<?php echo base_url();?>global/vendor/datatables.net/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>global/vendor/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="<?php echo base_url();?>global/vendor/datatables.net-fixedheader/dataTables.fixedHeader.js"></script>
<script src="<?php echo base_url();?>global/vendor/datatables.net-fixedcolumns/dataTables.fixedColumns.js"></script>
<script src="<?php echo base_url();?>global/vendor/datatables.net-rowgroup/dataTables.rowGroup.js"></script>
<script src="<?php echo base_url();?>global/vendor/datatables.net-scroller/dataTables.scroller.js"></script>
<script src="<?php echo base_url();?>global/vendor/datatables.net-responsive/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>global/vendor/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>
<script src="<?php echo base_url();?>global/vendor/datatables.net-buttons/dataTables.buttons.js"></script>
<script src="<?php echo base_url();?>global/vendor/datatables.net-buttons/buttons.html5.js"></script>
<script src="<?php echo base_url();?>global/vendor/datatables.net-buttons/buttons.flash.js"></script>
<script src="<?php echo base_url();?>global/vendor/datatables.net-buttons/buttons.print.js"></script>
<script src="<?php echo base_url();?>global/vendor/datatables.net-buttons/buttons.colVis.js"></script>
<script src="<?php echo base_url();?>global/vendor/datatables.net-buttons-bs4/buttons.bootstrap4.js"></script>
<script src="<?php echo base_url();?>global/vendor/asrange/jquery-asRange.min.js"></script>
<script src="<?php echo base_url();?>global/vendor/bootbox/bootbox.js"></script>
<script src="<?php echo base_url();?>global/js/Plugin/datatables.js"></script>
<!--<script src="<?php echo base_url();?>assets/examples/js/tables/datatable.js"></script>-->

<script>
(function (global, factory) {
    if (typeof define === "function" && define.amd) {
        define("/tables/datatable", ["jquery", "Site"], factory);
    } 
    else if (typeof exports !== "undefined") {
        factory(require("jquery"), require("Site"));
    } 
    else {
        var mod = {
        exports: {}
        };
        factory(global.jQuery, global.Site);
        global.tablesDatatable = mod.exports;
    }
})(this, function (_jquery, _Site) {
    "use strict";

    _jquery = babelHelpers.interopRequireDefault(_jquery);
    (0, _jquery.default)(document).ready(function ($$$1) {
        (0, _Site.run)();
    });
    (function () {
        (0, _jquery.default)(document).ready(function () {
        var defaults = Plugin.getDefaults("dataTable");

        var options = _jquery.default.extend(true, {}, defaults, {
            "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': [-1]
            }],
            "iDisplayLength": 15,
            "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            "sDom": '<"dt-panelmenu clearfix"Bfr>t<"dt-panelfooter clearfix"ip>',
            "buttons": ['copy', 'excel', 'csv', 'pdf', 'print']
        });

        (0, _jquery.default)('#exampleAddRow').dataTable(options);
        });
    })();
});
</script>