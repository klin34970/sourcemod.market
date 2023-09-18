var BlankonFormWizard = function () {

    return {

        // =========================================================================
        // CONSTRUCTOR APP
        // =========================================================================
        init: function () {
            BlankonFormWizard.twitterBootstrapWizard();
        },

        // =========================================================================
        // TWITTER BOOTSTRAP WIZARD
        // =========================================================================
        twitterBootstrapWizard: function () {

            if($('#basic-wizard-horizontal').length){
                $('#basic-wizard-horizontal').bootstrapWizard();
                $('#nextTab').click(function(){
                    $('#navTab').find('.active').next().children().trigger('click');
                });
            }

            if($('#disabled-tab-wizard').length){
                $('#disabled-tab-wizard').bootstrapWizard({onTabClick: function(tab, navigation, index) {
                    alert('on tab click disabled');
                    return false;
                }});
            }
        }

    };

}();

// Call main app init
BlankonFormWizard.init();