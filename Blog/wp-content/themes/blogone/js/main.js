//  Header Mobile Menu
jQuery(document).ready(function($){

  // Assiccibility Ready
  var startTab = function(elem,first_focus,close_button){
      var tabbable = elem.find('select, input, textarea, button, a, [href],[tabindex]:not([tabindex="-1"])').filter(':visible');

      var firstTabbable = tabbable.first();
      var lastTabbable = tabbable.last();
      first_focus.focus();

      lastTabbable.on('keydown', function (e) {
          if ((e.which === 9 && !e.shiftKey)) {
              e.preventDefault();
              firstTabbable.focus();
          }
      });
      firstTabbable.on('keydown', function (e) {
          if ((e.which === 9 && e.shiftKey)) {
              e.preventDefault();
              lastTabbable.focus();
          }
      });

      elem.on('keyup', function (e) {
          if (e.keyCode === 27) {
              close_button.click();
          };
      });
  };

  $('.navbar-toggler').on('click', function(){
    $('.nav-menu').addClass("show");
    $('.body-overlay').addClass('active');
    startTab($('.nav-menu'),$('.primary-menu-list > li:first-of-type a'),$('.navbar-close'));
  });
  $('.navbar-close').on('click', function(){
    $('.nav-menu').removeClass("show");
    $('.body-overlay').removeClass('active');
    $('.navbar-toggler').focus();
  });
  $('.body-overlay').on('click', function () {
    $(".nav-menu").removeClass("show");
    $('.body-overlay').removeClass('active');
    $('.navbar-toggler').focus();
  });
  
  // Info Header

  $('.bs-info-list').on('click', function(e){
    $('.sidebar-one').addClass("active");
    startTab($('.sidebar-one__content'),$('.sidebar-one__logo > li:first-of-type a'),$('.sidebar-one__close'));
    return false;
  });
  $('.sidebar-one__close').on('click', function(){
    $('.sidebar-one').removeClass("active");
    $('.bs-info-list').focus();
  });
  $('.sidebar-one__overlay').on('click', function(){
    $('.sidebar-one').removeClass("active");
    $('.bs-info-list').focus();
  });

  $('.nav-menu').find('.menu-item-has-children > a').each(function(){
      $('<button type="button" class="toggle-menu"><i class="fa fa-angle-down"></i></button>').insertAfter($(this));
  });

  // expands the dropdown menu on each click
  $('.nav-menu').find('li .toggle-menu').on('click', function(e) {
    e.preventDefault();
    $(this).parent('li').children('ul').stop(true, true).slideToggle(350);
    $(document).find('li.active ul.sub-menu').css('display', 'none');
    $(document).find('li.active').removeClass('active');
  });

   // Sticky Header

  if ($(".bs-navigation_wrapper").length > 0) {
    $(window).on('scroll', function() {
      if ($(window).scrollTop() >= 250) {
        $('.is_sticky').addClass('is-sticky-menu');
      }
      else {
        $('.is_sticky').removeClass('is-sticky-menu');
      }
    });
  }

  /*-- OWL Carousel Start --*/
  function ThemeOwlCaousel($elem) {
      $elem.owlCarousel({
          rtl: $("html").attr("dir") == 'rtl' ? true : false,
          items: $elem.data("collg"),
          margin: $elem.data("itemspace"),
          autoHeight: true,
          loop: $elem.data("loop"),
          center: $elem.data("center"),
          thumbs: false,
          thumbImage: false,
          // autoplay: $elem.data("autoplay"),
          autoplay:false,
          autoplayTimeout: $elem.data("autoplaytimeout"),
          animateIn: $elem.data("animatein"),
          animateOut: $elem.data("animateout"),
          autoplayHoverPause: true,
          smartSpeed: $elem.data("smartspeed"),
          dots: $elem.data("dots"),
          nav: $elem.data("nav"),
          navText: ['<i class="fas fa-arrow-left"></i>', '<i class="fas fa-arrow-right"></i>'],
          singleItem: true,
          transitionStyle: "fade",
          touchDrag: true,
          mouseDrag: true,
          responsive: {
              0: {
                  items: $elem.data("colxs"),
              },
              768: {
                  items: $elem.data("colsm"),
              },
              992: {
                  items: $elem.data("colmd"),
              },
              1200: {
                  items: $elem.data("collg"),
              }
          },
      });

      $elem.owlCarousel();
      $elem.on('translate.owl.carousel', function(event) {
        var data_anim = $("[data-animation]");
        data_anim.each(function() {
          var anim_name = $(this).data('animation');
          $(this).removeClass('animated ' + anim_name).css('opacity', '0');
        });
      });
      $("[data-delay]").each(function() {
        var anim_del = $(this).data('delay');
        $(this).css('animation-delay', anim_del);
      });
      $("[data-duration]").each(function() {
        var anim_dur = $(this).data('duration');
        $(this).css('animation-duration', anim_dur);
      });
      $elem.on('translated.owl.carousel', function() {
        var data_anim = $elem.find('.owl-item.active').find("[data-animation]");
        data_anim.each(function() {
          var anim_name = $(this).data('animation');
          $(this).addClass('animated ' + anim_name).css('opacity', '1');
        });
      });
  }

  if ($('.owl-carousel').length) {
      $('.owl-carousel').each(function() {
          new ThemeOwlCaousel($(this));
      });
  }

});

// <!-- ====== SCROLL TO TOP SCRIPT ====== -->
var scrollToTopBtn = document.querySelector(".scrollToTopBtn");
var rootElement = document.documentElement;

function handleScroll() {
  // Do something on scroll - 0.15 is the percentage the page has to scroll before the button appears
  // This can be changed - experiment
  var scrollTotal = rootElement.scrollHeight - rootElement.clientHeight
  if ((rootElement.scrollTop / scrollTotal ) > 0.15) {
    // Show button
    scrollToTopBtn.classList.add("showBtn");
  } else {
    // Hide button
    scrollToTopBtn.classList.remove("showBtn");
  }
}

function scrollToTop() {
  // Scroll to top logic
  rootElement.scrollTo({
    top: 0,
    behavior: "smooth"
  })
}

if( scrollToTopBtn != null ){
  scrollToTopBtn.addEventListener("click", scrollToTop);
}

document.addEventListener("scroll", handleScroll);


jQuery(document).ready(function($){
  var current_url = window.location.href;
  var parts = current_url.split("/");

  var fileName = parts[parts.length - 1];
  var all_tags = $(".primary-menu-list .menu-item a");

  $(all_tags).each(function(ind, ele) {

    var anchor_element = ele.outerHTML;
    var anchor_url = $(anchor_element).attr('href');

    if (anchor_url == fileName ) {
      $(ele).parents('.menu-item').addClass('active');
    }

  });
});