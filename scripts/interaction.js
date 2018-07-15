// Main JavaScript Document

var $ = jQuery; //negates Wordpress from going into noConflict() mode and allow for use of '$' instead of 'jQuery'

$(document).ready(function() {

  // collapse header if user is scrolled
  toggleScrolledClass();

  //set copyright year to current year
  $('.footer span.year').html(new Date().getFullYear());

  var windowWidth = $(window).width();
  hideMenuForMobile(windowWidth, true);

});

$(document).on('click', '.menu-link', function() {
  if($(this).hasClass('opened')) {
    $(this).next().slideUp();
    $(this).removeClass('opened');
  } else {
    $(this).next().slideDown();
    $(this).addClass('opened');
  }
  return false;
});

function hideMenuForMobile(windowWidth, load) {
  if(!$(document).data('resize-width')) {
    $(document).data('resize-width', windowWidth);
  }
  var existingWidth = $(document).data('resize-width');
  var newWidth = $(document).width();
  if(existingWidth !== newWidth || load) {
    if($(window).width() <= 767) {
      $('.header .menu-main-navigation-container, .mobile-menu, .menu-newsroom-links-container').each(function() {
        $(this).hide();
        $(this).prev().removeClass('opened');
      });
    } else {
      $('.header .menu-main-navigation-container, .mobile-menu, .menu-newsroom-links-container').each(function() {
        $(this).show();
        $('.menu-link').addClass('opened');
      });
    }
  }
  $(document).data('resize-width', newWidth);
}

var rtime = new Date(1, 1, 2000, 12,00,00);
var timeout = false;
var delta = 100;

$(window).resize(function() {
  rtime = new Date();
  if (timeout === false) {
    timeout = true;
    setTimeout(resizeend, delta);
  } 
});

function resizeend() {
  if (new Date() - rtime < delta) {
    setTimeout(resizeend, delta);
  } 
  else {
    timeout = false;
    var windowWidth = $(window).width();
    hideMenuForMobile(windowWidth);
  }
}

$(window).scroll(function() {
  toggleScrolledClass();
});

function toggleScrolledClass() {
  var headerHeight = $('.header').outerHeight();
  if($(window).scrollTop() > headerHeight - 10) {
    $('body').addClass('scrolled');
  } else {
    $('body').removeClass('scrolled');
  }
}