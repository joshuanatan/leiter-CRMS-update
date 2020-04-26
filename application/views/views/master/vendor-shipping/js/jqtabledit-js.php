
<script src="<?php echo base_url();?>global/vendor/jquery-tabledit/jquery.tabledit.min.js"></script>
<script src="<?php echo base_url();?>global/vendor/peity/jquery.peity.min.js"></script>
<script src="<?php echo base_url();?>global/js/Plugin/peity.js"></script>
<!--<script src="<?php echo base_url();?>assets/examples/js/tables/jqtabledit.js"></script>-->
<script>
  /*
(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define("/tables/jqtabledit", ["jquery", "Site"], factory);
  } else if (typeof exports !== "undefined") {
    factory(require("jquery"), require("Site"));
  } else {
    var mod = {
      exports: {}
    };
    factory(global.jQuery, global.Site);
    global.tablesJqtabledit = mod.exports;
  }
})(this, function (_jquery, _Site) {
  "use strict";

  _jquery = babelHelpers.interopRequireDefault(_jquery);
  (0, _jquery.default)(document).ready(function ($$$1) {
    (0, _Site.run)();
  }); // Example Tabledit Toolbars
  // -------------------------------

  (function () {
    (0, _jquery.default)('#tableditLogAllHooks').Tabledit({
      rowIdentifier: 'data-id',
      editButton: true,
      restoreButton: true,
      columns: {
        identifier: [0, 'id'],
        editable: [[1, 'username'], [2, 'email'], [3, 'avatar', '{"1": "Black Widow", "2": "Captain America", "3": "Iron Man"}']]
      },
      buttons: {
        edit: {
          class: 'btn btn-sm btn-icon btn-flat btn-default',
          html: '<span class="icon wb-wrench"></span>',
          action: 'edit'
        },
        delete: {
          class: 'btn btn-sm btn-icon btn-flat btn-default',
          html: '<span class="icon wb-close"></span>',
          action: 'delete'
        }
      },
      onDraw: function onDraw() {
        console.log('onDraw()');
      },
      onSuccess: function onSuccess(data, textStatus, jqXHR) {
        console.log('onSuccess(data, textStatus, jqXHR)');
        console.log(data);
        console.log(textStatus);
        console.log(jqXHR);
      },
      onFail: function onFail(jqXHR, textStatus, errorThrown) {
        console.log('onFail(jqXHR, textStatus, errorThrown)');
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
      },
      onAlways: function onAlways() {
        console.log('onAlways()');
      },
      onAjax: function onAjax(action, serialize) {
        console.log('onAjax(action, serialize)');
        console.log(action);
        console.log(serialize);
      }
    });
  })();
});
*/
</script>