var $ = jQuery.noConflict();
// (function($) {
//     "use strict";
//     $('#left_menu').slicknav({
//         label: 'Menu',
//         prependTo: '.dashboard-nav'
//     });

// })(jQuery);

$(document).ready(function() {
    if (('#testi-carousel').length > 0) {
        jQuery("#testi-carousel").owlCarousel({
            autoplay: false,
            autoplayTimeout: 4000,
            autoplayHoverPause: false,
            items: 3,
            loop: true,
            navText: false,
            dots: false,
            nav: true,
            mouseDrag: false,
            lazyLoad: false,
            margin: 30,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });
    }
    if (('#profile-carousel').length > 0) {
        jQuery("#profile-carousel").owlCarousel({
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: false,
            loop: true,
            items: 4,
            navText: false,
            dots: true,
            nav: false,
            mouseDrag: false,
            lazyLoad: false,
            margin: 30,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }
        });
    }

});