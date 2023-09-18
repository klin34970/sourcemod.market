'use strict';
var BlankonTable = function (trans_menu, trans_record, trans_info, trans_info_empty, trans_info_filtered, trans_search, trans_previous, trans_next) {

    // =========================================================================
    // SETTINGS APP
    // =========================================================================
    var globalPluginsPath = BlankonApp.handleBaseURL()+'/assets/global/plugins/bower_components';

    return {

        // =========================================================================
        // CONSTRUCTOR APP
        // =========================================================================
        init: function (trans_menu, trans_record, trans_info, trans_info_empty, trans_info_filtered, trans_search, trans_previous, trans_next) {
            BlankonTable.datatable(trans_menu, trans_record, trans_info, trans_info_empty, trans_info_filtered, trans_search, trans_previous, trans_next);
        },

        // =========================================================================
        // DATATABLE
        // =========================================================================
        datatable: function (trans_menu, trans_record, trans_info, trans_info_empty, trans_info_filtered, trans_search, trans_previous, trans_next) {
            var responsiveHelperDom = undefined;
            var breakpointDefinition = {
                tablet: 1024,
                phone : 480
            };

            var tableDom = $('#datatable-dom');


            // Using DOM
            // Remove arrow datatable
            tableDom.dataTable({
                autoWidth        : false,
				"paging":   false,
				"ordering": false,
				"info":     false,
				"filter":	false,
                preDrawCallback: function () {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelperDom) {
                        responsiveHelperDom = new ResponsiveDatatablesHelper(tableDom, breakpointDefinition);
                    }
                },
                rowCallback    : function (nRow) {
                    responsiveHelperDom.createExpandIcon(nRow);
                },
                drawCallback   : function (oSettings) {
                    responsiveHelperDom.respond();
                },
				language: {
					lengthMenu: trans_menu,
					zeroRecords: trans_record,
					info: trans_info,
					infoEmpty: trans_info_empty,
					infoFiltered: trans_info_filtered,
					search: trans_search,
					paginate: 
					{
						previous: trans_previous,
						next: trans_next
					}
				}
            });            
			
            var responsiveHelperDom = undefined;
            var breakpointDefinition = {
                tablet: 1024,
                phone : 480
            };
			
			var tableDom = $('#datatable-dom-2');


            // Using DOM
            // Remove arrow datatable
            tableDom.dataTable({
                autoWidth        : false,
				"paging":   false,
				"ordering": false,
				"info":     false,
				"filter":	false,
                preDrawCallback: function () {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelperDom) {
                        responsiveHelperDom = new ResponsiveDatatablesHelper(tableDom, breakpointDefinition);
                    }
                },
                rowCallback    : function (nRow) {
                    responsiveHelperDom.createExpandIcon(nRow);
                },
                drawCallback   : function (oSettings) {
                    responsiveHelperDom.respond();
                },
				language: {
					lengthMenu: trans_menu,
					zeroRecords: trans_record,
					info: trans_info,
					infoEmpty: trans_info_empty,
					infoFiltered: trans_info_filtered,
					search: trans_search,
					paginate: 
					{
						previous: trans_previous,
						next: trans_next
					}
				}
            });
			
			var responsiveHelperDom = undefined;
            var breakpointDefinition = {
                tablet: 1024,
                phone : 480
            };
			
			var tableDom = $('#datatable-dom-3');


            // Using DOM
            // Remove arrow datatable
            tableDom.dataTable({
                autoWidth        : false,
				"paging":   false,
				"ordering": false,
				"info":     false,
				"filter":	false,
                preDrawCallback: function () {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelperDom) {
                        responsiveHelperDom = new ResponsiveDatatablesHelper(tableDom, breakpointDefinition);
                    }
                },
                rowCallback    : function (nRow) {
                    responsiveHelperDom.createExpandIcon(nRow);
                },
                drawCallback   : function (oSettings) {
                    responsiveHelperDom.respond();
                },
				language: {
					lengthMenu: trans_menu,
					zeroRecords: trans_record,
					info: trans_info,
					infoEmpty: trans_info_empty,
					infoFiltered: trans_info_filtered,
					search: trans_search,
					paginate: 
					{
						previous: trans_previous,
						next: trans_next
					}
				}
            });

        }

    };

}();

// Call to view for translation
//BlankonTable.init(trans_menu, trans_record, trans_info, trans_info_empty, trans_info_filtered, trans_search, trans_previous, trans_next);