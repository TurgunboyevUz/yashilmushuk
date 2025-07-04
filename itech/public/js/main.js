(function ($) {
    "use strict";

    AOS.init({
        duration: 1000,
        once: true
    });

    $(window).on('load', function () {
        $('#loader').fadeOut(3000, function () {
            $('#content').fadeIn(1500); 
        });
    });

    $(document).ready(function () {

        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
        return false;
    });

    $('.vendor-carousel').owlCarousel({
        loop: true,
        margin: 29,
        nav: false,
        autoplay: true,
        smartSpeed: 1000,
        responsive: {
            0: {
                items: 2
            },
            576: {
                items: 3
            },
            768: {
                items: 4
            },
            992: {
                items: 5
            },
            1200: {
                items: 6
            }
        }
    });

    $('.related-carousel').owlCarousel({
        loop: true,
        margin: 29,
        nav: false,
        autoplay: true,
        smartSpeed: 1000,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 2
            },
            768: {
                items: 3
            },
            992: {
                items: 4
            }
        }
    });

    $('.quantity button').on('click', function () {
        var button = $(this);
        var oldValue = button.parent().parent().find('input').val();
        if (button.hasClass('btn-plus')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        button.parent().parent().find('input').val(newVal);
    });

    // Zoom functionality
    $('.zoom-container').mousemove(function(e) {
        var $zoomImage = $(this).find('.zoom-image');
        var containerOffset = $(this).offset();
        var containerWidth = $(this).width();
        var containerHeight = $(this).height();
        
        var mouseX = e.pageX - containerOffset.left;
        var mouseY = e.pageY - containerOffset.top;

        var posX = (mouseX / containerWidth) * 100;
        var posY = (mouseY / containerHeight) * 100;

        $zoomImage.css({
            'transform': 'scale(2) translate(-' + posX + '%, -' + posY + '%)',
            'transform-origin': posX + '% ' + posY + '%'
        });
    });

    $('.zoom-container').mouseleave(function() {
        var $zoomImage = $(this).find('.zoom-image');
        $zoomImage.css('transform', 'scale(1)');
    });

})(jQuery);
