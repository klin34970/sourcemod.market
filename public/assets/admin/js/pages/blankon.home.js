var BlankonBlogType2 = function () {

    return {

        // =========================================================================
        // CONSTRUCTOR APP
        // =========================================================================
        init: function () {
            BlankonBlogType2.CubeportfolioPost();
        },

        // =========================================================================
        // CUBEPORTFOLIO POST
        // =========================================================================
        CubeportfolioPost: function () {
            (function($, window, document, undefined) {
                'use strict';

                // init cubeportfolio
                $('#grid-container').cubeportfolio({
                    animationType: '3dflip',
                    gapHorizontal: 10,
                    gapVertical: 10,
                    gridAdjustment: 'responsive',
                    mediaQueries: [{
                        width: 1500,
                        cols: 4
                    }, {
                        width: 1100,
                        cols: 4
                    }, {
                        width: 800,
                        cols: 2
                    }, {
                        width: 480,
                        cols: 2
                    }, {
                        width: 320,
                        cols: 1
                    }],
                    caption: 'revealBottom',
                    displayType: 'lazyLoading',
                    displayTypeSpeed: 400
                });
            })(jQuery, window, document);
        }

    };

}();

// Call main app init
BlankonBlogType2.init();