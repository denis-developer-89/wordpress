jQuery(document).ready(function ($) {

  modal();

  document.addEventListener(
    "wpcf7mailsent",
    function (event) {
      //document.location.href = "/thank/";
    },
    false
  );

  $("select").niceSelect();

  $(document.body).on("click", ".wrapper-header__burger a", function (event) {
    event.preventDefault();
    $(this).toggleClass("active");
    $("body").toggleClass("body-show-mobile");
    if ($(this).hasClass("active")) {
      $(".wrapper-header__mobile").remove();
      $(".wrapper-header").append('<div style="display: none" class="wrapper-header__mobile"></div>');
      let $contact = $(".wrapper-footer__info").clone().removeClass("wrapper-footer__info");
      let $nav = $(".wrapper-header-nav").clone().css("display", "block");
      $(".wrapper-header__mobile").append($nav).append($contact).slideDown();
    } else {
      $(".wrapper-header__mobile").slideUp();
    }
  });

  $(window).scroll(function () {
    if ($(this).scrollTop() > 50) {
      $("header").addClass("fix-head");
    } else {
      $("header").removeClass("fix-head");
    }
  });

  var fixed_header = $("header");
  var offset_fixed_header = fixed_header.offset();
  if (offset_fixed_header.top > 50) {
    $("header").addClass("fix-head");
  }

  $(document.body).on("click", ".menu-item-has-children > a", function (event) {
    event.preventDefault();
    $(this).next().slideToggle();
  });

  $(document.body).on("click", 'a[href^="#"]', function (event) {
    var el = $(this).attr("href");
    if ($(el).length > 0) {
      $("html, body")
        .stop()
        .animate(
          {
            scrollTop: $(el).offset().top,
          },
          800
        );
      event.preventDefault();
    }
  });

  $(document).ready(function () {
    if (window.matchMedia("(max-width: 991.98px)").matches) {
      $(".menu-item-has-children>span").on("click", function (event) {
        $(this).next().fadeToggle();
        $(this).toggleClass("active");
        event.preventDefault();
      });
    }
  });

  $(document.body).on("click", ".faq-list__title", function (event) {
    if ($(this).parent().hasClass("open")) {
      $(this).next().slideUp();
      $(this).parent().removeClass("open");
    } else {
      $(this).parent().toggleClass("open");
      $(this).next().slideToggle();
    }
    event.preventDefault();
  });

  function modal(){
    $(document.body).on("click", ".modal-show", function (event) {

    });
    $(document.body).on("click", ".modal-close", function (event) {
      $(this).closest('.modal').hide();
    });
  }

});
