var BlankonGalleryType4 = function () {

    return {

        // =========================================================================
        // CONSTRUCTOR APP
        // =========================================================================
        init: function () {
            BlankonGalleryType4.CubeportfolioGallery();
        },

        // =========================================================================
        // CUBEPORTFOLIO GALLERY
        // =========================================================================
        CubeportfolioGallery: function () {
            (function($, window, document, undefined) {
                'use strict';

                // init cubeportfolio
                $('#js-grid-masonry').cubeportfolio({
                    filters: '#js-filters-masonry',
                    layoutMode: 'grid',
                    defaultFilter: '*',
                    animationType: 'slideDelay',
                    gapHorizontal: 20,
                    gapVertical: 20,
                    gridAdjustment: 'responsive',
                    mediaQueries: [{
                        width: 800,
                        cols: 3
                    }, {
                        width: 480,
                        cols: 2
                    }, {
                        width: 320,
                        cols: 1
                    }],
                    caption: 'overlayBottomAlong',
                    displayType: 'bottomToTop',
                    displayTypeSpeed: 100,

                    // lightbox
                    lightboxDelegate: '.cbp-lightbox',
                    lightboxGallery: true,
                    lightboxTitleSrc: 'data-title',
                    lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',
                });
            })(jQuery, window, document);
        }

    };

}();

// Call main app init
BlankonGalleryType4.init();