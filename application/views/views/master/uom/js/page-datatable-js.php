
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