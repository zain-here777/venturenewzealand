$(document).ready((function(){$(".cloudbar i").removeClass("la-cloud-meatball"),$(".cloudbar i").addClass("la-cloud"),$("#wrapper .site-main").css("cssText","margin-top: 0px !important;"),$(".site-header").css("top","0"),$(".html-marquee").css("top","-48px")}));const sound=document.getElementById("sound"),triggers=document.querySelectorAll(".js-confetti"),defaults={disableForReducedMotion:!0};function fire(e,o){confetti(Object.assign({},defaults,o,{particleCount:Math.floor(200*e)}))}function confettiExplosion(e){fire(.25,{spread:26,startVelocity:55,origin:e}),fire(.2,{spread:60,origin:e}),fire(.35,{spread:100,decay:.91,origin:e}),fire(.1,{spread:120,startVelocity:25,decay:.92,origin:e}),fire(.1,{spread:120,startVelocity:45,origin:e})}function Tost(e,o){switch(toastr.options.closeButton=!0,toastr.options.closeMethod="fadeOut",toastr.options.closeDuration=300,toastr.options.closeEasing="swing",o){case"info":toastr.info(e);break;case"warning":toastr.warning(e);break;case"success":toastr.success(e);break;case"error":toastr.error(e)}}function newsletterSubscribe(){let e=$("#nl_email").val(),o=$("#nl_fullname").val();""!=e&&""!=o?$.ajax({url:getUrlAPI("newsletter_subscribe",""),data:{email:e,fullname:o},type:"POST",success:function(e){e.status?($("#nl_email").val(""),$("#nl_fullname").val(""),Tost(e.message,"success")):Tost(e.message,"error")},error:function(e,o,t){Object.keys(e.responseJSON.errors).map((function(o,t){Tost(e.responseJSON.errors[o],"error")}))}}):alert("Please fill Full name and Email")}function socialSingup(e){let o=$("#social_url_hidden").val();$.ajax({url:"{{ route('socialSession') }}",data:{type:e},type:"POST",success:function(e){1==e.status&&(location.href="{{ url('') }}/auth/"+o)}})}Array.from(triggers).forEach((e=>{e.addEventListener("click",(()=>{const o=e.getBoundingClientRect(),t=o.left+o.width/2,n=o.top+o.height/2,s={x:t/window.innerWidth,y:n/window.innerHeight};sound&&(sound.currentTime=0,sound.play());console.log("origin",s),confettiExplosion({x:.663720703125,y:.6025641025641025}),$("html, body").animate({scrollTop:0},"slow"),$(".zoom-in-zoom-out h3").css("display","inline-block")}))})),$(document).ready((function(){$(".right-header__destinations").mouseenter((function(e){e.preventDefault(),e.stopPropagation(),$(this).find(".menu-arrow,.sub-menu").addClass("open"),$(this).find(".drop_menu").addClass("open_megamenu"),$(this).find(".menu_title i").addClass("la-angle-up")})),$(".right-header__destinations").mouseleave((function(e){e.preventDefault(),e.stopPropagation(),$(this).find(".menu-arrow,.sub-menu").removeClass("open"),$(this).find(".drop_menu").removeClass("open_megamenu"),$(this).find(".menu_title i").removeClass("la-angle-up")})),$(".drop_menu").click((function(e){e.stopPropagation()}))})),$(window).width()<1024&&$(".right-header__destinations a.menu_title").click((function(e){e.preventDefault(),e.stopPropagation(),$(this).next(".drop_menu").find(".menu-arrow").toggleClass("open"),$(this).next(".drop_menu").toggleClass("open_megamenu"),$(this).find("i").toggleClass("la-angle-up")})),$(document).click((function(){})),$(".popup__destinations .sub-menu li .dropdown_city_show").click((function(e){e.preventDefault(),e.stopPropagation(),$(this).parent().find("ul.dropdown").slideToggle(),$(this).find("i").toggleClass("la-angle-up"),$(this).toggleClass("active")})),$(window).scroll((function(){$(this).scrollTop()>50?$(".site-header").addClass("fixed"):$(".site-header").removeClass("fixed")})),$(window).scroll((function(){$(this).scrollTop()>=50?$("#return-to-top").fadeIn(200):$("#return-to-top").fadeOut(200)})),$("#return-to-top").click((function(){$("body,html").animate({scrollTop:0},500)})),mapboxgl.accessToken="pk.eyJ1IjoibWluaHRoZSIsImEiOiJja2phc2l1eWc0OHF1MnJtMGw3ZzFjeXdxIn0.mJAsm20swzej4lWDUBucow",$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),$("#singup_facebook_singup").on("click",(function(){const e=$(this).data("social");$("#social_url_hidden").val(e);let o=$("#user_type").val();""==o?($("#LoginSingUpModel").modal("hide"),$("#UserTypeSelectPopUp").modal("show")):socialSingup(o)})),$("#singup_google_singup").on("click",(function(){const e=$(this).data("social");$("#social_url_hidden").val(e);let o=$("#user_type").val();""==o?($("#LoginSingUpModel").modal("hide"),$("#UserTypeSelectPopUp").modal("show")):socialSingup(o)}));
