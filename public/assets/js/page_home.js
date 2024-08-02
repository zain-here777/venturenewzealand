$( document ).ready(function() {
    // highlightedProducts slick scroll

    $(document).ready(function() {
        if ($('#login-hero').length) {
            if (window.matchMedia('(max-width: 768px)').matches) {
                $('.lazy').css('height', '550px');
                $('.destination_map').css('margin-top', '-700px');
            } else if (window.matchMedia('(min-width: 1024px)').matches) {
                $('.site-banner_content').css('margin-top', '-800px');
                $('.lazy').css('height', '1200px');
                // $('.destination_map').css('margin-top', '-600px');
            }
        }
    });
    

    $('.explore-slider2').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay:true,
        arrows:true,
        appendArrows: $('.explore-slider__nav'),
        prevArrow: '<div class="place-slider__prev slick-nav__prev slick-arrow" style="display: block;"><i class="las la-arrow-left"></i></div>',
        nextArrow: '<div class="place-slider__next slick-nav__next slick-arrow" style="display: block;"><i class="las la-arrow-right"></i></div>',
        responsive: [
            {
            breakpoint: 1366,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    adaptiveHeight: true,
                },
            },
            {
            breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    adaptiveHeight: true,
                },
            },
            {
            breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
            {
            breakpoint: 575,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });
    // highlightedProducts slick scroll
    var maxHeight = 0;

      $(".slick-slide .place-item .entry-detail").each(function(){
      if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
      });

      $(".slick-slide .place-item .entry-detail").height(maxHeight);
});


              // const video = document.getElementById("my-video");
              var video = document.querySelector('video > source');

              var assetURL = "{{ asset('videos/new_finally_high_bitrate.mp4') }}";

              // Need to be specific for Blink regarding codecs
              // ./mp4info frag_bunny.mp4 | grep Codec
              var mimeCodec = 'video/mp4; codecs="avc1.64001e, mp4a.40.2"';

              if ('MediaSource' in window && MediaSource.isTypeSupported(mimeCodec)) {
                  var mediaSource = new MediaSource;
                  //console.log(mediaSource.readyState); // closed
                  video.src = URL.createObjectURL(mediaSource);
                  mediaSource.addEventListener('sourceopen', sourceOpen);
              } else {
                  console.error('Unsupported MIME type or codec: ', mimeCodec);
              }

              function sourceOpen(_) {
                  console.log("SOURCE OPEN", this.readyState); // open
                  var mediaSource = this;
                  var sourceBuffer = mediaSource.addSourceBuffer(mimeCodec);
                  fetchAB(assetURL, function (buf) {
                      sourceBuffer.addEventListener('updateend', function (_) {
                          if (!sourceBuffer.updating && mediaSource.readyState === 'open') {
                              mediaSource.endOfStream();
                          }
                          // mediaSource.endOfStream();
                          video.play();
                          // console.log(mediaSource.readyState); // ended
                      });
                      sourceBuffer.appendBuffer(buf);
                  });
              };

              function fetchAB (url, cb) {
                  console.log("URLLLLLLLLL", url);
                  var xhr = new XMLHttpRequest;
                  xhr.open('get', url);
                  xhr.responseType = 'arraybuffer';
                  xhr.onload = function () {
                      console.log("OPEN ", xhr.response)
                      cb(xhr.response);
                  };
                  xhr.send();
              };

            //   let currentIndex = 0;

            //   function updateSlider() {
            //     const sliderWrapper = document.querySelector('.slider-wrapper');
            //     const sliderWidth = document.querySelector('.slider-container').clientWidth;
            //     sliderWrapper.style.transform = `translateX(-${currentIndex * sliderWidth}px)`;
            //   }
          
            //   function nextSlide() {
            //     const totalSlides = document.querySelectorAll('.slide').length;
            //     if (currentIndex < totalSlides - 1) {
            //       currentIndex++;
            //       updateSlider();
            //     }
            //   }
          
            //   function prevSlide() {
            //     if (currentIndex > 0) {
            //       currentIndex--;
            //       updateSlider();
            //     }
            //   }
          
            //   window.addEventListener('resize', updateSlider);
            //   window.addEventListener('DOMContentLoaded', updateSlider);

              

              // // creating the MediaSource, just with the "new" keyword, and the URL for it
              // const myMediaSource = new MediaSource();
              // console.log('myMediaSource ', myMediaSource);
              // const url = URL.createObjectURL(myMediaSource);
              // console.log('URL ', url);

              // // attaching the MediaSource to the video tag
              // videoTag.src = url;

              // // 1. add source buffers
              // const audioSourceBuffer = myMediaSource.onAddSourceBuffer('audio/mp4; codecs="mp4a.40.2"');
              // console.log('audioSourceBuffer ', audioSourceBuffer);
              // const videoSourceBuffer = myMediaSource.onAddSourceBuffer('video/mp4; codecs="avc1.64001e"');
              // console.log('videoSourceBuffer ', videoSourceBuffer);
