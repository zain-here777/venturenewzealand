const sound = document.getElementById("sound");
const triggers = document.querySelectorAll(".js-confetti");
const defaults = {
    disableForReducedMotion: true
};

function fire(particleRatio, opts) {
    confetti(
        Object.assign({}, defaults, opts, {
            particleCount: Math.floor(200 * particleRatio)
        })
    );
}

function confettiExplosion(origin) {
    fire(0.25, {
        spread: 26,
        startVelocity: 55,
        origin
    });
    fire(0.2, {
        spread: 60,
        origin
    });
    fire(0.35, {
        spread: 100,
        decay: 0.91,
        origin
    });
    fire(0.1, {
        spread: 120,
        startVelocity: 25,
        decay: 0.92,
        origin
    });
    fire(0.1, {
        spread: 120,
        startVelocity: 45,
        origin
    });
}

Array.from(triggers).forEach((trigger) => {
    trigger.addEventListener("click", () => {
        const rect = trigger.getBoundingClientRect();
        const center = {
            x: rect.left + rect.width / 2,
            y: rect.top + rect.height / 2
        };
        const origin = {
            x: center.x / window.innerWidth,
            y: center.y / window.innerHeight
        };

        if (sound) {
            sound.currentTime = 0;
            sound.play();
        }

        const staticOrigin = {
            x: 0.663720703125,
            y: 0.6025641025641025
        }

        console.log('origin', origin);

        confettiExplosion(staticOrigin);
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
        $(".zoom-in-zoom-out h3").css("display", "inline-block");
    });
});

// ----------------------------------------------

// // 2. This code loads the IFrame Player API code asynchronously.
// var tag = document.createElement('script');

// tag.src = "https://www.youtube.com/iframe_api";
// var firstScriptTag = document.getElementsByTagName('script')[0];
// firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.

// var player;

// function onYouTubeIframeAPIReady() {
//     player = new YT.Player('player', {
//         height: '390',
//         width: '640',
//         videoId: '8qtWMz1rcRo',
//         playerVars: {
//             loop: 1,
//             playlist: '8qtWMz1rcRo',
//             mute: 1,
//             controls: 0,
//             rel: '0',
//             modestbranding: 1,
//             iv_load_policy: '3'
//         },
//         events: {
//             'onReady': onPlayerReady,
//             'onStateChange': onPlayerStateChange
//         }
//     });

// }

// function onPlayerReady(event) {
//     event.target.playVideo();
//     event.target.mute();
// }

// function onPlayerStateChange(event) {}

// var player;
// function onYouTubeIframeAPIReady() {
//   player = new YT.Player('player', {
//     height: '390',
//     width: '640',
//     videoId: 'rUWxSEwctFU',
//     playerVars: {
//       'loop': 1,
//       'showinfo': 0,
//       'playsinline': 1,
//       'autoplay': 1,
//       'mute': 1,
//       'controls': 0,
//       'disablekb': 0,
//       'rel': 0,
//       'modestbranding' : 1
//     },
//     events: {
//       'onReady': onPlayerReady,
//       'onStateChange': onPlayerStateChange
//     }
//   });
// }


// // 4. The API will call this function when the video player is ready.
// function onPlayerReady(event) {
//   event.target.playVideo();
// }

// // 5. The API calls this function when the player's state changes.
// //    The function indicates that when playing a video (state=1),
// //    the player should play for six seconds and then stop.
// var done = false;
// function onPlayerStateChange(event) {
//   if (event.data == YT.PlayerState.PLAYING && !done) {
//   //   setTimeout(stopVideo, 6000);
//   //   done = true;
//   }
// }
// function stopVideo() {
//   player.stopVideo();
// }


// --------------------------------------------------------

 // "ytp-large-play-button ytp-button" aria-label="Play"
//  $(function() {
//     let iframe = $('#yt-vd-iframe');
//     let button = iframe.contents().find('.ytp-large-play-button');
//     button.trigger("click");
// });

// -------------------------------------------------------
function Tost(msg, type) {
    toastr.options.closeButton = true;
    toastr.options.closeMethod = 'fadeOut';
    toastr.options.closeDuration = 300;
    toastr.options.closeEasing = 'swing';
    switch (type) {
        case "info":
            toastr.info(msg);
            break;

        case "warning":
            toastr.warning(msg);
            break;

        case "success":
            toastr.success(msg);
            break;

        case "error":
            toastr.error(msg);
            break;
    }
}

// -------------------------------------------------------------

$(document).ready(function() {
    $('.right-header__destinations').mouseenter(function(e){
        e.preventDefault();
        e.stopPropagation();
        $(this).find('.menu-arrow,.sub-menu').addClass("open");
        $(this).find('.drop_menu').addClass("open_megamenu");
        $(this).find(".menu_title i").addClass("la-angle-up");
    });
    $('.right-header__destinations').mouseleave(function(e){
        e.preventDefault();
        e.stopPropagation();
        $(this).find('.menu-arrow,.sub-menu').removeClass("open");
        $(this).find('.drop_menu').removeClass("open_megamenu");
        $(this).find(".menu_title i").removeClass("la-angle-up");
    });

    $('.drop_menu').click(function(e) {
    e.stopPropagation();
    });
});

//  show mega menu on hover Start

if($(window).width()  < 1024){
    $(".right-header__destinations a.menu_title").click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).next('.drop_menu').find('.menu-arrow').toggleClass("open");
        $(this).next('.drop_menu').toggleClass("open_megamenu");
        $(this).find("i").toggleClass("la-angle-up");
    });
}


//  show mega menu on hover end
$(document).click(function() {
    // alert('document click')
    // $('.drop_menu').removeClass("open_megamenu");
    // $(".right-header__destinations a.menu_title i").removeClass('la-angle-up')
});

// $(".popup__destinations .sub-menu li a").click(function() {
// var clicked = false;
// var el = document.getElementById(".popup__destinations .sub-menu li .dropdown_city_show");
// var maxClicksDelay = 500; // in milliseconds
// el.onclick = function(e) {
//     if(clicked) {
//     e.preventDefault();
//     e.stopPropagation();
//     clicked = true;
//     setTimeout(function() { clicked = false}, maxClicksDelay );
//     $(this).parent().find("ul.dropdown").slideToggle();
//     $(this).find("i").toggleClass("la-angle-up");
//     $(this).toggleClass("active");
//     }
// }

$(".popup__destinations .sub-menu li .dropdown_city_show").click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).parent().find("ul.dropdown").slideToggle();
    $(this).find("i").toggleClass("la-angle-up");
    $(this).toggleClass("active");
});

// $(".popup__destinations .sub-menu li .dropdown_region_name").click(function(e) {
//     e.preventDefault();
// });
// $(".popup__destinations .sub-menu li").click(function(e) {
//     e.preventDefault();
// });
$(window).scroll(function() {
    if ($(this).scrollTop() > 50) {
        $('.site-header').addClass('fixed');
    } else {
        $('.site-header').removeClass('fixed');
    }
});

// ===== Scroll to Top ====
$(window).scroll(function() {
    if ($(this).scrollTop() >= 50) { // If page is scrolled more than 50px
        $('#return-to-top').fadeIn(200); // Fade in the arrow
    } else {
        $('#return-to-top').fadeOut(200); // Else fade out the arrow
    }
});
$('#return-to-top').click(function() { // When arrow is clicked
    $('body,html').animate({
        scrollTop: 0 // Scroll to top of body
    }, 500);
});

// -----------------------------------------------------------------------

mapboxgl.accessToken = 'pk.eyJ1IjoibWluaHRoZSIsImEiOiJja2phc2l1eWc0OHF1MnJtMGw3ZzFjeXdxIn0.mJAsm20swzej4lWDUBucow';

// ------------------------------------------------------------------------

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function newsletterSubscribe() {

    let email = $('#nl_email').val();
    let fullname = $('#nl_fullname').val();

    if (email == "" || fullname == "") {
        alert("Please fill Full name and Email");
        return;
    }

    $.ajax({
        url: getUrlAPI('newsletter_subscribe', ''),
        data: {
            email: email,
            fullname: fullname
        },
        type: 'POST',
        success: function(res) {
            if (res.status) {
                $('#nl_email').val('');
                $('#nl_fullname').val('');
                Tost(res.message, 'success');
            } else {
                Tost(res.message, 'error');
            }
        },
        error: function(xhr, status, error) {
            // Tost('An error occurred!','error');
            Object.keys(xhr.responseJSON.errors).map(function(value, key) {
                Tost(xhr.responseJSON.errors[value], 'error');
                // console.log(value,key);
                // Tost(value,'error');
            });
        }
    }); //ajax

} //newsletterSubscribe()

$('#singup_facebook_singup').on('click', function() {
    const social_type = $(this).data('social');
    $('#social_url_hidden').val(social_type);
    let user_type = $('#user_type').val();
    if (user_type == "") {
        $('#LoginSingUpModel').modal('hide');
        $('#UserTypeSelectPopUp').modal('show');
    } else {
        socialSingup(user_type)
    }
})

$('#singup_google_singup').on('click', function() {
    const social_type = $(this).data('social');
    $('#social_url_hidden').val(social_type);
    let user_type = $('#user_type').val();
    if (user_type == "") {
        $('#LoginSingUpModel').modal('hide');
        $('#UserTypeSelectPopUp').modal('show');
    } else {
        socialSingup(user_type)
    }
})

function socialSingup(type) {
    let social_url = $('#social_url_hidden').val();
    $.ajax({
        url: "{{ route('socialSession') }}",
        data: {
            type: type
        },
        type: 'POST',
        success: function(res) {
            if (res.status == true) {
                location.href = "{{ url('') }}/auth/" + social_url;
            }
        },

    });

}
