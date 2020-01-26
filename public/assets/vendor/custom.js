jQuery(window).ready(function() {
    jQuery('.featured-listing').imagesLoaded(function() {

            jQuery('.grid').isotope({
            itemSelector: '.grid-item',
            percentPosition: true,
            masonry: {
                // use outer width of grid-sizer for columnWidth
                columnWidth: '.grid-sizer'
            }
        });

    });


  
});


//HomePageSlider

$(document).ready(function() {
 
  $("#home-page-slider").owlCarousel({
 
	  navigation : false, // Show next and prev buttons
	  slideSpeed : 1000,
	  autoPlay: true,
	  paginationSpeed : 400,
	  singleItem:true,
	  transitionStyle: "goDown"
 
  });

});
//HomePageSliderEnd



$(document).ready(function() {
 
  var owl = $("#owl-demo");
 
  owl.owlCarousel({
	  pagination: false,
	  items : 3, //10 items above 1000px browser width
	  itemsDesktop : [1200,3], //5 items between 1000px and 901px
	  itemsDesktopSmall : [1000,2], // betweem 900px and 601px
	  itemsTablet: [600,1], //2 items between 600 and 0
	  itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
  });
 
  // Custom Navigation Events
  $(".next").click(function(){
	owl.trigger('owl.next');
  })
  $(".prev").click(function(){
	owl.trigger('owl.prev');
  })
  
	  
});
$(document).ready(function() {
 
  var owl = $("#cat_slider");
 
  owl.owlCarousel({
	  pagination: false,
	  items : 6, //10 items above 1000px browser width
	  itemsDesktop : [1200,3], //5 items between 1000px and 901px
	  itemsDesktopSmall : [1000,2], // betweem 900px and 601px
	  itemsTablet: [600,1], //2 items between 600 and 0
	  itemsMobile : false, // itemsMobile disabled - inherit from itemsTablet option
	  autoPlay: true
  });
 
  // Custom Navigation Events
  $(".next").click(function(){
	owl.trigger('owl.next');
  })
  $(".prev").click(function(){
	owl.trigger('owl.prev');
  })
  
var feature_listing = $("#feature_listing");

feature_listing.owlCarousel({
  pagination: false,
  items : 5, //10 items above 1000px browser width
  itemsDesktop : [1200,3], //5 items between 1000px and 901px
  itemsDesktopSmall : [1000,2], // betweem 900px and 601px
  itemsTablet: [600,1], //2 items between 600 and 0
  itemsMobile : false, // itemsMobile disabled - inherit from itemsTablet option
  autoPlay: true
});


  
	  
});




//Testimonial
$(document).ready(function() {
 
  $("#owl-demo2").owlCarousel({
 
	  navigation : false, // Show next and prev buttons
 
	  slideSpeed : 300,
	  paginationSpeed : 400,
 	
	  items : 2, //10 items above 1000px browser width
	  itemsDesktop : [1000,2], //5 items between 1000px and 901px
	  itemsDesktopSmall : [900,2], // betweem 900px and 601px
	  itemsTablet: [600,1], //2 items between 600 and 0
	  itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
 
  });
 
});



//window-scroll-function

jQuery(window).load(function() {
    var positionFormTop = jQuery(".top-header-palcement").offset().top;
    jQuery(window).scroll(function() {
        var scrollAmount = jQuery(window).scrollTop();
        if (scrollAmount >= positionFormTop) {
            jQuery('#wrap').addClass("sticky");
        } else {
            jQuery('#wrap').removeClass("sticky");
        }
    });
});

jQuery(window).resize(function() {
    var positionFormTop = jQuery(".top-header-palcement").offset().top;
    jQuery(window).scroll(function() {
        var scrollAmount = jQuery(window).scrollTop();
        if (scrollAmount >= positionFormTop) {
            jQuery('#wrap').addClass("sticky");
        } else {
            jQuery('#wrap').removeClass("sticky");
        }
    });
});


//second-scroller

$(function(){
 var shrinkHeader = 300;
  $(window).scroll(function() {
    var scroll = getCurrentScroll();
      if ( scroll >= shrinkHeader ) {
           $('.inner-logo-block').addClass('sticky');
        }
        else {
            $('.inner-logo-block').removeClass('sticky');
        }
  });
function getCurrentScroll() {
    return window.pageYOffset || document.documentElement.scrollTop;
    }
});


//Jquery-step
$(function (){
	
	$("#wizard").steps({
		headerTag: ".header-step",
		bodyTag: ".step-content",
		transitionEffect: "slideLeft",			
			
	});
	$(":file").filestyle({buttonBefore: true, buttonText: "Browse Images", input: true });
});




//Nav hover tab

//(function ($) {
//  $(function () {	  
//    $('.post-rental-add').off('click.bs.tab.data-api', '[data-hover="tab"]');
//    $('.post-rental-add').on('mouseenter.bs.tab.data-api', '[data-toggle="tab"], [data-hover="tab"]', function () {
//      $(this).tab('show');
//    });	
//  });
//})(jQuery);

$('.responsive-tabs').responsiveTabs({
  accordionOn: ['xs', 'sm']
});


//Scroll-smooth
function scrollNav() {
  $('.profile-nav .nav a').click(function(){   	 
    //Toggle Class
	
    $(".profile-nav .active").removeClass("active");      
    $(this).closest('.profile-nav li').addClass("active");
    var theClass = $(this).attr("class");
    $('.'+theClass).parent('.profile-nav li').addClass('active');
    //Animate
    $('html, body').stop().animate({
        scrollTop: $( $(this).attr('href') ).offset().top - 190
    }, 400);
    return false;
  });
  $('.scrollTop a').scrollTop();
}
scrollNav();

$('.profile-nav .nav a').click(function () {
    $('.navbar-collapse').collapse('hide');
});






