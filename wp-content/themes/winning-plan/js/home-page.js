jQuery(document).ready(function ($) {
    
    function rtl_slick() {
        if ($('body').hasClass("rtl")) {
            return true;
        } else {
            return false;
        }
    }

    const $nextArrow = '<button type="button" class="slick-next"><svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 42"><path fill-rule="evenodd" clip-rule="evenodd" d="M24.748 38.677a1 1 0 0 0 0-1.414L8.485 21.001 24.75 4.736a1 1 0 0 0 0-1.414L21.92.494a1 1 0 0 0-1.414 0L3.567 17.434l-.032.03-2.829 2.829a1 1 0 0 0 0 1.414l19.8 19.799a1 1 0 0 0 1.414 0l2.828-2.829Z" fill="#fff"/></svg></button>';
    const $prevArrow = '<button type="button" class="slick-prev"><svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 42"><path fill-rule="evenodd" clip-rule="evenodd" d="M.678 3.323a1 1 0 0 0 0 1.414L16.94 21 .677 37.263a1 1 0 0 0 0 1.414l2.829 2.829a1 1 0 0 0 1.414 0l16.939-16.94.032-.03 2.828-2.829a1 1 0 0 0 0-1.414L4.92.494a1 1 0 0 0-1.414 0L.678 3.323Z" fill="#fff"/></svg></button>';

    $('.main-gallery__carousel').slick({
        rtl: rtl_slick(),
        infinite: true,
        cssEase: 'linear',
        dots: false,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 2000,
        nextArrow: $nextArrow,
        prevArrow: $prevArrow,
        slidesToShow: 2,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    dots: true,
                    slidesToShow: 1
                }
            }
        ]
    });

    $('.main-reviews__carousel').slick({
        rtl: rtl_slick(),
        infinite: true,
        cssEase: 'linear',
        dots: false,
        arrows: true,
        nextArrow: $nextArrow,
        prevArrow: $prevArrow,
        slidesToShow: 1
    });

});