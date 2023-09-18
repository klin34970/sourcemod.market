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
				/*
				language: {
					lengthMenu: "Display _MENU_ records per pagelll",
					zeroRecords: "Nothing found - sorry",
					info: "Showing page _PAGE_ of _PAGES_",
					infoEmpty: "No records available",
					infoFiltered: "(filtered from _MAX_ total records)",
					search: 'pmpmpm',
					paginate: 
					{
						previous: "Previous page",
						next: "pop"
					}
				}
				*/
            });

        }

    };

}();

// Call to view for translation
//BlankonTable.init(trans_menu, trans_record, trans_info, trans_info_empty, trans_info_filtered, trans_search, trans_previous, trans_next);