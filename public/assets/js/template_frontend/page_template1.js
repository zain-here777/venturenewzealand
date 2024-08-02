var route_url = window.location.origin;

        // $(".cloudbar i").click(function(){
        //   $(".html-marquee").toggle();
        //   $(".site-main").css("margin-top","0");
        //   $(".site-header").css("top","0");
        // });


        // $(".form-sign .btn-google").click(function () {
        //     $(".custom-dialog").removeClass('open')
        // })

        $(".login-dialog").click(function() {
            // $(this).closest(".popup popup--left").removeClass("open";)

            $(this).parent().parent().parent().removeClass("open");
        })
        $(".signin-dialog").click(function() {
            // $(this).closest(".popup popup--left").removeClass("open";)

            $(this).parent().parent().parent().removeClass("open");
        })
        $(".cloudbar i").click(function() {
            $('.maps-wrap').toggleClass('fix_map_top')
            // If the clicked element has the active class, remove the active class from EVERY .nav-link>.state element
            if ($(this).hasClass("la-cloud-meatball")) {
                $(".cloudbar i").removeClass("la-cloud-meatball");
                $(".cloudbar i").addClass("la-cloud");
                $("#wrapper .site-main").css("cssText", "margin-top: 0px !important;");
                $(".site-header").css("top", "0");
                $(".html-marquee").css('top', '-48px');
                localStorage.setItem('show-weather', "no");
            }
            // Else, the element doesn't have the active class, so we remove it from every element before applying it to the element that was clicked
            else {
                $(this).addClass("la-cloud-meatball");
                $(".cloudbar i").removeClass("la-cloud");
                $("#wrapper .site-main").css("cssText", "margin-top: 40px !important;");
                $(".html-marquee").css('top', '0px');
                $(".site-header").css("top", "47px");
                localStorage.setItem('show-weather', "yes");
            }
        });

        $(".signup_user").on('click', function () {
            $(".usertype_div").removeClass('active');
            $(this).addClass('active');
            $("#user_type").val('1');
            if(!$(".operator_check").hasClass('d-none')){
                $(".operator_check").addClass('d-none');
            }
            $('.usertype_div_alert').removeClass('active');
            userTypePopup('JoinNow');
        });

        $(".signup_operator").on('click', function () {
            $(".usertype_div").removeClass('active');
            $(this).addClass('active');
            $("#user_type").val('2');
            $(".operator_check").removeClass('d-none');
            $('.usertype_div_alert').removeClass('active');
            $('#user_plan_type').val("");
            $('#user_plan_price').val("");
            $('#user_plan_type_text').html("");
        });
