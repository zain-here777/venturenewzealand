(function ($) {
    "use strict";
    $(document).ready(function () {

        /*  [ jQuery Countdown ]
        - - - - - - - - - - - - - - - - - - - - */
        setInterval(function () {
            var obj = $('.countdown-data');
            obj.each(function () {
                var end = $(this).data('end');
                var gmt = $(this).data('gmt');
                var d = new Date();
                var n = d.getTime();
                var n = Math.floor(n / 1000);
                var cd = end - (n + (gmt * 3600));
                var days = hours = minutes = seconds = 0;
                if (cd > 0) {
                    var sec_num = parseInt(cd, 10);
                    var days = Math.floor(sec_num / 86400);
                    var hours = Math.floor(sec_num / 3600) % 24;
                    var minutes = Math.floor(sec_num / 60) % 60;
                    var seconds = sec_num % 60;
                    if (seconds < 10) {
                        var seconds = '0' + seconds;
                    }
                    if (minutes < 10) {
                        var minutes = '0' + minutes;
                    }
                }
                $(this).find('.days').text(days);
                $(this).find('.hours').text(hours);
                $(this).find('.minutes').text(minutes);
                $(this).find('.seconds').text(seconds);
            });
        }, 1000);

        /*  [ Main Menu ]
        - - - - - - - - - - - - - - - - - - - - */
        var sub_menu = $('.sub-menu');
        sub_menu.each(function () {
            $(this).parent().find('> a').addClass('has-child').append(' <i class="la la-angle-down la-12"></i>');
        });

        $('.has-child').on('click', function (e) {
            e.preventDefault();
            $(this).toggleClass('open');
            $('.menu-arrow .has-child').not(this).parents('li').find(' > .sub-menu').slideUp('fast');
            $(this).parents('li').find(' > .sub-menu').slideToggle('fast');
        });

        $('.site__menu__icon').on('click', function (e) {
            e.preventDefault();
            $(this).parents('.site-header').find('.popup-background').fadeToggle();
            $(this).parents('.site-header').find('.popup--left').toggleClass('open');
        });

        $('.minicart__open').on('click', function (e) {
            e.preventDefault();
            $(this).parents('.site-header').find('.popup-background').fadeToggle();
            $(this).parents('.site-header').find('.popup--right').toggleClass('open');
        });

        $('.popup__close').on('click', function (e) {
            console.log('close');
            e.preventDefault();
            $(this).parents('.site-header').find('.popup-background').fadeOut();
            $(this).parent().parent().parent().removeClass('open');
            $(this).closest(".popup--left").removeClass('open');
        });

        $('.popup-background').on('click', function (e) {
            e.preventDefault();
            $(this).fadeOut();
            $(this).parents('.site-header').find('.popup').removeClass('open');
        });

        $(document).on('click', '.open-login', function (e) {
            e.preventDefault();
            $('.popup--left').removeClass('open');
            $(this).parents('#wrapper').find('.nav-login').addClass('active');
            $(this).parents('#wrapper').find('.form-log').fadeIn(0);
            $(this).parents('#wrapper').find('.nav-signup').removeClass('active');
            $(this).parents('#wrapper').find('.form-sign').fadeOut(0);
            $(this).parents('#wrapper').find('.form-forgotpass').fadeOut(0);
            $(this).parents('#wrapper').find('.popup-background').fadeIn(0);
            $(this).parents('#wrapper').find('.popup-form').toggleClass('open');
        });

        $('.open-signup').on('click', function (e) {
            e.preventDefault();
            $('.popup--left').removeClass('open');
            $(this).parents('#wrapper').find('.nav-signup').addClass('active');
            $(this).parents('#wrapper').find('.form-sign').fadeIn(0);
            $(this).parents('#wrapper').find('.nav-login').removeClass('active');
            $(this).parents('#wrapper').find('.form-log').fadeOut(0);
            $(this).parents('#wrapper').find('.form-forgotpass').fadeOut(0);
            $(this).parents('#wrapper').find('.popup-background').fadeIn(0);
            $(this).parents('#wrapper').find('.popup-form').toggleClass('open');
        });

        $('.choose-form a').on('click', function (e) {
            e.preventDefault();
            var id = $(this).attr('href');
            $(this).parents('.popup').find('.form-content').fadeOut(0);
            $(this).parents('.popup').find(id).fadeIn(0);
            $('.choose-form li').removeClass('active');
            $(this).parent().addClass('active');
        });

        $('.search-open').on('click', function (e) {
            e.preventDefault();
            $(this).parents('.site-header').find('.site__search').toggleClass('open');
        });

        $('.search__close').on('click', function (e) {
            e.preventDefault();
            $(this).parents('.site-header').find('.site__search').removeClass('open');
        });

        /*  [ Destinations Popup ]
        - - - - - - - - - - - - - - - - - - - - */
        // $('.right-header__languages > a, .right-header__destinations > a, .site__filter a, .site__sort a').on('click', function (e) {
        //     e.preventDefault();
        //     $(this).parent().find('ul').toggleClass('open');
        // });

        $('.right-header__languages > a, .site__filter a, .site__sort a').on('click', function (e) {
            e.preventDefault();
            $(this).parent().find('ul').toggleClass('open');
        });

        /*  [ Filter ]
        - - - - - - - - - - - - - - - - - - - - */
        // $('.site__filter a').on('click', function (e) {
        //     e.preventDefault();
        //     $(this).toggleClass('active');
        //     $(this).parents('body').find('.golo-menu-filter').slideToggle();
        // });
        //
        // $('.filter-control a').on('click', function (e) {
        //     e.preventDefault();
        //     $(this).parents('li').toggleClass('active');
        //     $('.filter-control a').not(this).parents('li').removeClass('active');
        // });

        $(document).mouseup(function (e) {
            var destinations = $('.right-header__destinations'),
                languages = $('.right-header__languages'),
                site__filter = $('.site__filter'),
                site__sort = $('.site__sort');

            if (!destinations.is(e.target) && destinations.has(e.target).length === 0) {
                destinations.find('ul').removeClass('open');
            }

            if (!languages.is(e.target) && languages.has(e.target).length === 0) {
                languages.find('ul').removeClass('open');
            }

            if (!site__filter.is(e.target) && site__filter.has(e.target).length === 0) {
                site__filter.find('ul').removeClass('open');
            }

            if (!site__sort.is(e.target) && site__sort.has(e.target).length === 0) {
                site__sort.find('ul').removeClass('open');
            }
        });

        /*  [ Slick Slider ]
        - - - - - - - - - - - - - - - - - - - - */

        // Place Grid Slider

        var place_slider = $('.place-slider'),
            place_grid = $('.place-slider__grid');

        place_grid.slick({
            centerMode: true,
            centerPadding: '418px',
            slidesToShow: 1,
            dots: true,
            prevArrow: $('.place-slider__prev'),
            nextArrow: $('.place-slider__next'),
            responsive: [{
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    centerPadding: 0,
                }
            },
            {
                breakpoint: 575,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerPadding: 0,
                    arrows: false,
                    prevArrow: '',
                    nextArrow: '',
                }
            },
            ]
        });

        place_slider.find('.place-slider__prev').hide();

        place_grid.on('afterChange', function (event, slick, currentSlide, nextSlide) {
            if (currentSlide == 0) {
                place_slider.find('.place-slider__prev').hide();
            } else {
                place_slider.find('.place-slider__prev').show();
            }
        });

        // Slick Slider

        $('.slick-sliders').each(function () {
            var item = $(this).find('.slick-slider').data('item'),
                arrows = $(this).find('.slick-slider').data('arrows'),
                itemScroll = $(this).find('.slick-slider').data('itemscroll'),
                dots = $(this).find('.slick-slider').data('dots'),
                autoplay = $(this).find('.slick-slider').data('autoplay'),
                infinite = $(this).find('.slick-slider').data('infinite'),
                centerMode = $(this).find('.slick-slider').data('centermode'),
                centerPadding = $(this).find('.slick-slider').data('centerpadding'),
                tabletItem = $(this).find('.slick-slider').data('tabletitem'),
                tabletScroll = $(this).find('.slick-slider').data('tabletscroll'),
                tabletPadding = $(this).find('.slick-slider').data('tabletpadding'),
                mobileItem = $(this).find('.slick-slider').data('mobileitem'),
                mobileScroll = $(this).find('.slick-slider').data('mobilescroll'),
                mobilearrows = $(this).find('.slick-slider').data('mobilearrows'),
                asNavFor = $(this).find('.slick-slider').data('asNavFor'),
                slick_slider = $(this).find('> .slick-slider'),
                _this = $(this);

            console.log(autoplay);

            slick_slider.slick({
                autoplay: autoplay,
                centerMode: centerMode,
                centerPadding: centerPadding,
                dots: dots,
                infinite: infinite,
                speed: 300,
                arrows: arrows,
                slidesToShow: item,
                slidesToScroll: itemScroll,
                prevArrow: $(this).find('.place-slider__prev'),
                nextArrow: $(this).find('.place-slider__next'),
                asNavFor: asNavFor,
                responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: tabletItem,
                        slidesToScroll: tabletScroll,
                        centerPadding: tabletPadding,
                    }
                },
                {
                    breakpoint: 575,
                    settings: {
                        slidesToShow: mobileItem,
                        slidesToScroll: mobileScroll,
                        arrows: mobilearrows,
                        prevArrow: '',
                        nextArrow: '',
                    }
                },
                ]
            });

            _this.find('.place-slider__prev').hide();

            slick_slider.on('afterChange', function (event, slick, currentSlide, nextSlide) {
                if (currentSlide == 0) {
                    _this.find('.place-slider__prev').hide();
                } else {
                    _this.find('.place-slider__prev').show();
                }
            });
        });

        $('.testimonial-control').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            asNavFor: '.testimonial-slider',
            dots: false,
            // draggable: 'false',
            // swipe: 'false',
            // swipeToSlide: 'false',
            // touchMove: 'false',
            // draggable: 'false',
            centerMode: true,
            focusOnSelect: true,
            // arrows: true,
            // prevArrow: $(this).parents('.testimonial').find('.place-slider__prev'),
            // nextArrow: $(this).parents('.testimonial').find('.place-slider__next'),
        });

        // City Slider

        $('.city-slider').each(function () {

            var city = $(this),
                city_grid = city.find('.city-slider__grid');

            city_grid.slick({
                dots: false,
                infinite: false,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 4,
                prevArrow: city.find('.city-slider__prev'),
                nextArrow: city.find('.city-slider__next'),
                responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                    }
                },
                {
                    breakpoint: 375,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                ]
            });

            city.find('.city-slider__prev').hide();

            city_grid.on('afterChange', function (event, slick, currentSlide, nextSlide) {
                if (currentSlide == 0) {
                    city.find('.city-slider__prev').hide();
                } else {
                    city.find('.city-slider__prev').show();
                }
            });
        });

        // Comment Slider

        // var comment_slider = $( '.comment-slider' );

        // comment_slider.slick({
        // 	slidesToShow: 4,
        // 	dots: false,
        //     		responsive: [
        // 	    {
        // 		    breakpoint: 575,
        // 		    settings: {
        // 		        slidesToShow: 1,
        // 		    }
        // 	    },
        // 	]
        // });

        /*  [ Tabs ]
        - - - - - - - - - - - - - - - - - - - - */
        // $('.tabs').each(function(){
        //
        //     var active, content, links = $(this).find('a');
        //
        //     active = $(links.filter('[href="'+location.hash+'"]')[0] || links[0]);
        //     active.addClass('active');
        //     content = $(active.attr('href'));
        //
        //     links.not(active).each(function () {
        //         $($(this).attr('href')).hide();
        //     });
        //
        //     $(this).on('click', 'a', function(e){
        //
        //         active.parent().removeClass('active');
        //         $( '.choose-form li a' ).not( this ).parent().removeClass('active');
        //         content.hide();
        //
        //         active = $(this);
        //         content = $($(this).attr('href'));
        //
        //         active.parent().addClass('active');
        //         content.show();
        //
        //         e.preventDefault();
        //     });
        // });
        //
        //
        /*  [ Add Socials ]
        - - - - - - - - - - - - - - - - - - - - */
        $('.add-social').on('click', function (e) {
            e.preventDefault();
            var id = $(this).attr('href'),
                clone = $(id).find('.field-clone').html();
            $(id).find('.socials-list').append(clone);
        });
        $(".socials-list").bind("DOMSubtreeModified", function () {
            $('.remove-social').on('click', function (e) {
                e.preventDefault();
                $(this).parents('.field-3col').remove();
            });
        });

        /*  [ Quantity ]
        - - - - - - - - - - - - - - - - - - - - */
        $('.shop-details__quantity').each(function () {
            var adultsminus = $(this).find('.adults-minus'),
                adultsplus = $(this).find('.adults-plus');
            adultsminus.on('click', function () {
                // var mainprice = $('#mainprice').val();
                // var menuid = $('#menuid').val();
                // var existsprice = $('#cart_product_price').text();

                var qty = $(this).parent().find('.qty');
                if (qty.val() == 0) {
                    qty.val(0);
                } else {
                    qty.val((parseInt(qty.val(), 10) - 1));
                }
                Pricecalculation();
            });
            adultsplus.on('click', function () {
                var qty = $(this).parent().find('.qty');
                qty.val((parseInt(qty.val(), 10) + 1));
                Pricecalculation();
            });

            var childminus = $(this).find('.child-minus'),
                childplus = $(this).find('.child-plus');
            childminus.on('click', function () {
                var qty = $(this).parent().find('.qty');
                if (qty.val() == 0) {
                    qty.val(0);
                } else {
                    qty.val((parseInt(qty.val(), 10) - 1));
                }
                Pricecalculation();
            });
            childplus.on('click', function () {
                var qty = $(this).parent().find('.qty');
                qty.val((parseInt(qty.val(), 10) + 1));
                Pricecalculation();
            });

            var carminus = $(this).find('.car-minus'),
                carplus = $(this).find('.car-plus');

            carminus.on('click', function () {
                var qty = $(this).parent().find('.qty');
                if (qty.val() == 0) {
                    qty.val(0);
                } else {
                    qty.val((parseInt(qty.val(), 10) - 1));
                }
                Pricecalculation();
            });
            carplus.on('click', function () {
                var qty = $(this).parent().find('.qty');
                qty.val((parseInt(qty.val(), 10) + 1));
                Pricecalculation();
            });
        });

        function Pricecalculation() {
            const numberAdults = $('#number_of_adult').val();
            const numberChildrens = $('#number_of_children').val();
            const numberCars = $('#number_of_car').val() ?? 0;
            const adultPrice = parseFloat($('#adultprice').val());
            const childrenPrice = parseFloat($('#childprice').val());
            const carPrice = parseFloat($('#carprice').val());

            var total = 0;

            // if(isNaN(childrenPrice) && isNaN(carPrice)){
            //     total = (numberAdults * adultPrice);
            // }else if(isNaN(carPrice)){
            //     total = (numberAdults * adultPrice) ;
            // }
            // else if(isNaN(childrenPrice) && carPrice){
            //     console.log("sadasd");
            //     total = (numberAdults * adultPrice) + (numberCars * carPrice);
            // }else if(isNaN(carPrice) && childrenPrice){
            //     total = (numberAdults * adultPrice) + (numberChildrens * childrenPrice);
            // }else{
            //     total = (numberAdults * adultPrice) + (childrenPrice * numberChildrens) + (numberCars * carPrice);
            // }


            if(childrenPrice == 0 && carPrice == 0){
                total = (numberAdults * adultPrice);
            }
            else if(childrenPrice == 0 && carPrice != 0){
                total = (numberAdults * adultPrice) + (numberCars * carPrice);
            }else if(carPrice == 0 && childrenPrice != 0){
                total = (numberAdults * adultPrice) + (numberChildrens * childrenPrice);
            }else{
                total = (numberAdults * adultPrice) + (childrenPrice * numberChildrens) + (numberCars * carPrice);
            }
            total = Number(total).toFixed(2);
            $('#cart_product_price').text('$' + total);
        }

        /*  [ Isotope ]
        - - - - - - - - - - - - - - - - - - - - */
        $(window).on('load', function () {
            var isotope__grid = $('.isotope__grid');
            isotope__grid.each(function () {
                isotope__grid.isotope({
                    // options
                    itemSelector: '.isotope__grid__item',
                    layoutMode: 'fitRows'
                });

                $('.isotope__nav a').on('click', function (e) {
                    e.preventDefault();
                    $(this).addClass('active');
                    $('.isotope__nav a').not(this).removeClass('active');
                    var selector = $(this).attr('data-filter');
                    isotope__grid.isotope({ filter: selector });
                    return false;
                });
            });
        });

        /*  [ Chosen ]
        - - - - - - - - - - - - - - - - - - - - */
        $('.chosen-select').chosen({
            no_results_text: "Oops, nothing found!"
        });

        /*  [ Filter Show more ]
        - - - - - - - - - - - - - - - - - - - - */
        $('.open-more').on('click', function (e) {
            e.preventDefault();
            var close = $(this).data('close');
            var more = $(this).data('more');
            $(this).parents('.filter-list').toggleClass('open');
            if ($(this).parents('.filter-list').hasClass('open')) {
                $(this).text(close);
            } else {
                $(this).text(more);
            }
        });

        /*  [ Opening Hours ]
        - - - - - - - - - - - - - - - - - - - - */
        $('.accordion-bot').hide();
        $('.accordion-top label').on('click', function (e) {
            e.preventDefault();
            var _this = $(this);

            if ($(this).find('input').is(':checked')) {

                console.log("is unchecked");
                // _this.find('.accordion-top > span').text("Closed111");

                $(this).find('input').prop('checked', false);
            } else {

                console.log("is checked");
                // _this.find('.accordion-top > span').text("Closed222");

                $(this).find('input').prop('checked', 'checked');
            }
            // $('.accordion-top label').not(this).parents('.accordion-top').next().slideUp().parents('.accordion-top').removeClass('open');
            // $('.accordion-top label').not(this).parents('.accordion-top').find('input').prop('checked', false);
            $(this).parents('.accordion-top').next().slideToggle().parent().toggleClass('open');
        });

        $('.accordion-item').each(function () {
            var _this = $(this);
            _this.find('select').change(function () {
                var open_first = _this.find('select[class="open_time"] option:first-child').text();
                var close_first = _this.find('select[class="close_time"] option:first-child').text();
                var open_time = _this.find('select[class="open_time"] option:selected').text();
                var close_time = _this.find('select[class="close_time"] option:selected').text();
                if ((open_time != open_first) && (close_time != close_first)) {
                    _this.addClass('active');
                    // _this.find( '.accordion-bot' ).slideUp();
                    _this.find('.accordion-top > span').text(open_time + ' - ' + close_time);
                }
            });
        });

        /*  [ Input File ]
        - - - - - - - - - - - - - - - - - - - - */
        function readURL(input, _this) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    _this.parents('.field-group').find('.img_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('.field-group input[type="file"]').change(function () {
            var _this = $(this);
            readURL(this, _this);
        });

        var fileInput = $('.upload-file');
        var maxSize = fileInput.data('max-size')  == undefined ? 1000000 : fileInput.data('max-size') ;
        $('.upload-form').submit(function (e) {
            if (fileInput.prop('required') == true) {
                if (fileInput.get(0).files.length) {
                    var fileSize = fileInput.get(0).files[0].size; // in bytes
                    if (fileSize > maxSize) {
                        console.log('fileSizes=>',fileSize,'maxSizes=>',maxSize,fileSize > maxSize);
                        alert('file size is more then' + (maxSize/1000000) + ' MB');
                        return false;
                    }
                    // else {
                    //     alert('file size is correct- ' + fileSize + ' bytes');
                    // }
                } else {
                    alert('choose file, please');
                    return false;
                }
            }
        });

        /*  [ Scroll ]
        - - - - - - - - - - - - - - - - - - - - */
        $(window).scroll(function () {
            if ($(window).scrollTop() > $('.site-header').height()) {
                $('.listing-nav').addClass('on_scroll');
            } else {
                $('.listing-nav').removeClass('on_scroll');
            }
            if ($(window).scrollTop() + window.innerHeight >= $('#footer').offset().top) {
                $('.listing-nav').addClass('is_footer');
            } else {
                $('.listing-nav').removeClass('is_footer');
            }
        });

        $('.nav-scroll a[href^="#"]').on('click', function (event) {

            var target = $(this.getAttribute('href'));

            if (target.length) {
                if ($(window).width() > 767) {
                    var top = target.offset().top - 120;
                } else {
                    var top = target.offset().top - 120;
                }
                event.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: top
                }, 800);
            }

            $('.nav-scroll a').not($(this)).parent().removeClass('active');
            $(this).parent().addClass('active');
        });

        $(window).scroll(function () {
            var scrollDistance = $(window).scrollTop();

            // Assign active class to nav links while scolling
            $('.listing-box').each(function (i) {
                if ($(this).position().top <= scrollDistance + 150) {
                    var href = $(this).attr('id'),
                        id = '#' + href;
                    $('.nav-scroll a').parent().removeClass('active');
                    $('.nav-scroll a').each(function () {
                        var attr = $(this).attr('href');
                        // For some browsers, `attr` is undefined; for others, `attr` is false. Check for both.
                        if (attr == id) {
                            // Element has this attribute
                            $(this).parent().addClass('active');
                        }
                    });
                }
            });
        });

        $('#clear').fadeOut(0);
        $('.field-pin a').on('click', function (e) {
            e.preventDefault();
            $(this).fadeOut(0);
            $('.field-pin a').not(this).fadeIn(0);
        });
        // $('.btn-mapsview').on('click', function () {
        //     var href = $(this).attr('href');
        //     window.location.href = href;
        // });

        // Show More Description
        $('.show-more').on('click', function (e) {
            e.preventDefault();
            $(this).parents('.place__box-overview').find('.place__desc').addClass('open');
            $(this).fadeOut(0);
        });

        $('.stars a').on('click', function (e) {
            e.preventDefault();
            $('.stars a').not(this).removeClass('active');
            $(this).addClass('active');
            $(this).parents('.stars').addClass('selected');
        });

        /*  [ Popup ]
        - - - - - - - - - - - - - - - - - - - - */
        $('.open-popup').on('click', function (e) {
            e.preventDefault();
            var id = $(this).attr('href');
            $(this).parents('body').find(id).fadeIn();
            if ($(id).find('.popup').outerHeight() > $(window).outerHeight()) {
                $(id).addClass('more-height');
                $('body').css('overflow-y', 'hidden');

            } else {
                $(id).removeClass('more-height');
                $('body').css('overflow-y', 'auto');
            }
            $(this).parents('.popup-wrap').fadeOut();
        });
        $('.popupbg-close, .popup-close').on('click', function (e) {
            e.preventDefault();
            $(this).parents('.popup-wrap').fadeOut();
        });

        /*  [ Quill Js ]
        - - - - - - - - - - - - - - - - - - - - */
        if ($('#editor').length) {
            var toolbarOptions = [
                ['bold'],
                ['italic'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                ['link'],
                ['clean'],
            ];

            var quill = new Quill('#editor', {
                modules: {
                    toolbar: toolbarOptions,
                },
                formats: [
                    'bold',
                    'size',
                    'link',
                    'image',
                    'video',
                    'clean',
                ],
                theme: 'snow'
            });

            window.unsavedChanges = false;

            window.addEventListener("beforeunload", function (e) {
                if (window.unsavedChanges) {
                    e.returnValue = 'Unsaved Changes!';
                    return 'Unsaved Changes!';
                }
                return;
            });

            var syncHtml = debounce(function () {
                var contents = $(".ql-editor").html();
                $('#editor_content').val(contents);
                console.log(contents);
                window.unsavedChanges = false;
            }, 500);

            quill.on('text-change', function () {
                window.unsavedChanges = true;
                syncHtml();
            });
        }

        function debounce(func, wait) {
            var timeout;
            return function () {
                var context = this,
                    args = arguments;
                var executeFunction = function () {
                    func.apply(context, args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(executeFunction, wait);
            }
        }

        /*  [ Accordion ]
        - - - - - - - - - - - - - - - - - - - - */
        $('.accordion.first-open > li:first-child').addClass('open');
        $('.accordion-title a').on('click', function (event) {
            event.preventDefault();
            if ($(this).parents('li').hasClass('open')) {
                var ac = $(this).parents('li');
                ac.removeClass('open');
                ac.find('.accordion-content').slideUp(400);
            } else {
                var acc = $(this).parents('.accordion');
                var acd = acc.find('.accordion-content');
                var act = acd.not($(this).parents('li').find('.accordion-content'));
                act.slideUp(400);
                acc.find('> li').not($(this).parents('li')).removeClass('open');
                var al = $(this).parents('li');
                al.addClass('open').find('.accordion-content').slideDown(400);
            }
        });

        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#member_avatar').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        function readURLDrvLicense(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#member_driver').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        function readURLPassport(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#member_passport').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('.open-wg').on('click', function (e) {
            e.preventDefault();
            $(this).parents('.sidebar').toggleClass('open');
            $(this).parents('.sidebar').find('.widget').toggleClass('open');
        });
        $(document).mouseup(function (e) {
            var container = $('.widget');

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.removeClass('open');
                container.parents('.sidebar').removeClass('open');
            }
        });
        if ($('.sidebar').offset()) {
            var fixmeTop = $('.sidebar').offset().top;
        }

        var lastScrollTop = 0;

        $(window).scroll(function () { // assign scroll event listener

            var currentScroll = $(window).scrollTop(); // get current position

            if (currentScroll >= fixmeTop - 40) { // apply position: fixed if you
                $('.sidebar').addClass('fixed');
            } else { // apply position: static
                $('.sidebar').removeClass('fixed');
            }

            var st = $(this).scrollTop();
            if (st > lastScrollTop) {
                $('.widget-reservation-mini').addClass('open');
            } else {
                $('.widget-reservation-mini').removeClass('open');
            }
            lastScrollTop = st;

        });


        if ($('.sidebar').length) {
            var fixmeTop = $('.sidebar').offset().top; // get initial position of the element
            $(window).scroll(function () { // assign scroll event listener
                var currentScroll = $(window).scrollTop(); // get current position
                if (currentScroll >= fixmeTop - 40) { // apply position: fixed if you
                    $('.sidebar').addClass('fixed');
                } else { // apply position: static
                    $('.sidebar').removeClass('fixed');
                }
            });
        }

        $('.mb-open').on('click', function (e) {
            e.preventDefault();
            var id = $(this).attr('href');
            $(this).parents('.archive-city').find('.archive-filter ').fadeIn();
            $(id).fadeIn();
        });

        $('.mb-maps').on('click', function (e) {
            e.preventDefault();
            $(this).parents('.archive-city').find('.col-right').fadeIn();
        });

        $('.close-maps').on('click', function (e) {
            e.preventDefault();
            $(this).parents('.col-right').fadeOut();
        });

        $('.member-avatar input[type="file"]').change(function () {
            readURL1(this);
        });

        $('.member-driver input[type="file"]').change(function () {
            readURLDrvLicense(this);
        });

        $('.member-passport input[type="file"]').change(function () {
            readURLPassport(this);
        });

        $('.member-place-list').each(function () {
            $("#all").on('click', function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
        });

        $('.open-option').on('click', function (e) {
            e.preventDefault();
            $(this).parent().find('.box-option').fadeToggle();
        });

        $(document).mouseup(function (e) {
            var container = $('.box-option');

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.fadeOut();
            }
        });

        $('.account>a').on('click', function (e) {
            e.preventDefault();
            $(this).parent().find('.account-sub').fadeToggle();
        });

        $(document).mouseup(function (e) {
            var container = $('.account');

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.find('.account-sub').fadeOut();
            }
        });

        if ($('.city-content__tabtitle').length) {
            var distance = $('.city-content__tabtitle').offset().top;

            $(window).scroll(function () {

                if ($(window).scrollTop() >= distance) {
                    $('.city-content').addClass("affix");

                } else {
                    $('.city-content').removeClass("affix");
                }
            });
        }

        // Init empty gallery array
        var container = [];

        // Loop over gallery items and push it to the array
        $('.photoswipe').find('.photoswipe-item').each(function () {
            var $link = $(this).find('a'),
                item = {
                    src: $link.attr('href'),
                    w: $link.data('width'),
                    h: $link.data('height'),
                    title: $link.data('caption')
                };
            container.push(item);
        });

        // Define click event on gallery item
        $('.show-gallery').click(function (event) {
            console.log("click,,,");

            // Prevent location change
            event.preventDefault();

            // Define object and gallery options
            var $pswp = $('.pswp')[0],
                options = {
                    index: 1,
                    bgOpacity: 0.85,
                    showHideOpacity: true
                };

            // Initialize PhotoSwipe
            var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
            gallery.init();
        });

        $('.photoswipe-item a').click(function (event) {

            // Prevent location change
            event.preventDefault();

            // Define object and gallery options
            var $pswp = $('.pswp')[0],
                options = {
                    index: $(this).parent().index(),
                    bgOpacity: 0.85,
                    showHideOpacity: true
                };

            // Initialize PhotoSwipe
            var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
            gallery.init();
        });

        // Filter

        $('.filter-box h3').on('click', function () {
            $(this).toggleClass('active');
            $(this).parents('.filter-box').find('.filter-list').slideToggle();
        });

        $('.filter-control .current').on('click', function () {
            $(this).parent().toggleClass('active');
        });

        $(document).mouseup(function (e) {
            var container = $("ul.list");

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.parents('.filter-control').removeClass('active');
            }
        });

        $('.filter-box').each(function () {
            $('.field-check input[type="checkbox"]').change(function () {
                if ($(this).is(':checked')) {
                    $(this).parents('.filterForm').find('.clear-filter').addClass('open');
                } else if ($('.field-check input[type="checkbox"]').not(this).is(':checked')) {
                    $(this).parents('.filterForm').find('.clear-filter').addClass('open');
                } else if ($('.field-check input[type="checkbox"]').not(this).prop('checked') == false) {
                    $(this).parents('.filterForm').find('.clear-filter').removeClass('open');
                }
            });
        });

        $('.clear-filter').on('click', function (e) {
            e.preventDefault();
            $(this).removeClass('open');
            $(this).parents('.filterForm').find('input[type="checkbox"]').prop('checked', false);
        });


        // $('.lity-btn').on('click', '[data-lightbox]', lity);

        $('.share').on('click', function (e) {
            e.preventDefault();
            $(this).parent().find('.social-share').slideToggle();
        });

        $(document).mouseup(function (e) {
            var container = $(".place-share");

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.find('.social-share').slideUp();
            }
        });

        // $(".field-select input").click(function (e) {
        //     $(".field-sub.active").removeClass('active');
        //     $(this).next().next().toggleClass('active')
        // })



        $(window).scroll(function () {
            $('.gj-picker-bootstrap').hide();
        });
        $('.widget-reservation .field-select input').click(function () {
            $('.gj-picker-bootstrap').show();
        });

        // Datepicker
        $('.datepicker').each(function () {
            $(this).datepicker({
                uiLibrary: 'bootstrap4'
            });
        });

        var date_width = $('.datepicker').outerWidth();
        $('.gj-picker-bootstrap').css('width', date_width);

        $('.field-time .field-sub li a').on('click', function (e) {
            e.preventDefault();
            var text = $(this).text();
            $(this).parents('.field-time').find('input').val(text);
        });

        $('.shop-details__quantity span').on('click', function (e) {
            e.preventDefault();
            var text = [];
            if ($('.number_adults').val() > 0) {
                text.push('Adults ' + $('.number_adults').val());
            }
            if ($('.number_childrens').val() > 0) {
                text.push(' Childrens ' + $('.number_childrens').val());
            }
            $(this).parents('.field-guest').find('input[type="text"]').val(text.toString());
        });

        /*  [ Close ]
        - - - - - - - - - - - - - - - - - - - - */
        $('.close').on('click', function (e) {
            e.preventDefault();
            var close = $(this).data('close');
            $('.' + close).fadeOut();
        });

        /*  [ Delete ]
        - - - - - - - - - - - - - - - - - - - - */
        $('.clear-all').on('click', function (e) {
            e.preventDefault();
            $(this).parents('.ob-item').find('.ob-content > *').remove();
            $(this).parents('.ob-item').find('h3 span').text('(0)');
        });
        $('.delete-noti').on('click', function (e) {
            e.preventDefault();
            var number = $(this).parents('.ob-item').find('h3 span').text();
            number = number.replace("(", "");
            number = number.replace(")", "");
            number = number - 1;
            $(this).parents('.ob-item').find('h3 span').text('(' + number + ')');
            $(this).parents('.noti-item').remove();
        });

        $('.delete').on('click', function (e) {
            e.preventDefault();
            $(this).parents('tr').remove();
        })
    });

})(jQuery);
