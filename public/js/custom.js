(function ($) {
    "use strict";
    $(document).ready(function () {

        $(".navbar a").on("click", function (event) {
            if (!$(event.target).closest(".nav-item.dropdown").length) {
                $(".navbar-collapse").collapse('hide');
            }
        });
        $('#back-to-top').fadeOut();
        $(window).on("scroll", function () {
            if ($(this).scrollTop() > 250) {
                $('#back-to-top').fadeIn(1400);
            } else {
                $('#back-to-top').fadeOut(400);
            }
        });
        $('#top').on('click', function () {
            $('top').tooltip('hide');
            $('body,html').animate({scrollTop: 0}, 800);
            return false;
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $('.iq-accordion .iq-ad-block .ad-details').hide();
        $('.iq-accordion .iq-ad-block:first').addClass('ad-active').children().slideDown('slow');
        $('.iq-accordion .iq-ad-block').on("click", function () {
            if ($(this).children('div').is(':hidden')) {
                $('.iq-accordion .iq-ad-block').removeClass('ad-active').children('div').slideUp('slow');
                $(this).toggleClass('ad-active').children('div').slideDown('slow');
            }
        });
        $('.navbar-nav li a').on('click', function (e) {
            var anchor = $(this);
            $('html, body').stop().animate({scrollTop: $(anchor.attr('href')).offset().top - 0}, 1500);
            e.preventDefault();
        });
        $(window).on('scroll', function () {
            if ($(this).scrollTop() > 100) {
                $('header').addClass('menu-sticky');
            } else {
                $('header').removeClass('menu-sticky');
            }
        });
        $('.popup-gallery').magnificPopup({
            delegate: 'a.popup-img',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {enabled: true, navigateByImgClick: true, preload: [0, 1]},
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.', titleSrc: function (item) {
                    return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
                }
            }
        });
        $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });

        var wow = new WOW({boxClass: 'wow', animateClass: 'animated', offset: 0, mobile: false, live: true});
        wow.init();
    });


    $('#contact').submit(function (e) {
        // var form_data = $(this).serialize();
        // var flag = 0;
        // e.preventDefault();
        // $('.require').each(function () {
        //     if ($.trim($(this).val()) == '') {
        //         $(this).css("border", "1px solid red");
        //         e.preventDefault();
        //         flag = 1;
        //     } else {
        //         $(this).css("border", "1px solid grey");
        //         flag = 0;
        //     }
        // });
        // if (grecaptcha.getResponse() == "") {
        //     flag = 1;
        //     alert('Please verify Recaptch');
        // } else {
        //     flag = 0;
        // }
        // if (flag == 0) {
        //     console.log(form_data);
        //     $.ajax({url: 'php/contact-form.php', type: 'POST', data: form_data,}).done(function (data) {
        //         console.log("successfully");
        //         $("#result").html('Form was successfully submitted.');
        //         $('#contact')[0].reset();
        //     }).fail(function () {
        //         alert('Ajax Submit Failed ...');
        //         console.log("fail");
        //     });
        // }
    });
})(jQuery);