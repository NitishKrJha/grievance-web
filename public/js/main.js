var $ = jQuery.noConflict();
(function($) {
    "use strict";
    $('#left_menu').slicknav({
        label: 'Menu',
        prependTo: '.dashboard-nav'
    });

})(jQuery);

$(document).ready(function () {
	
 jQuery(document).ready(function(){
    jQuery(".scrollbar-outer").scrollbar();
});
	
});

$("#dashboardSecSlid").owlCarousel({
        autoplay: false,
        items : 1, 
		navText: true,
		dots: false, 
		loop:false,      
		nav : true,
		mouseDrag:true,
		lazyLoad : false,
		responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        900:{
            items:1
        },
        1000:{
            items:1
        }
    }
      });

$("#dailyMatcheSlid").owlCarousel({
        autoplay: false,
        items : 1, 
		navText: true,
		dots: false, 
		loop:false,      
		nav : true,
		mouseDrag:true,
		lazyLoad : false,
		responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        900:{
            items:1
        },
        1000:{
            items:1
        }
    }
      });

 