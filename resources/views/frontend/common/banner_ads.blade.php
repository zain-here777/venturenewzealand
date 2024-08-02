<div class="banner_ads">

    <div class="banner_slider">
        @if(count($banner_ads)>0)
        @foreach ($banner_ads as $banner_ad)
            @php
                echo ($banner_ad->image);
            @endphp
            {{-- <a href="javascript:void(0);"><img src="{{ getImageUrl($banner_ad->image) }}" class="img-fluid"></a> --}}
        @endforeach
        @endif
    </div>

</div>
@push('scripts')
    <script>
        $('.banner_slider').slick({
            dots: false,
            infinite: true,
            speed: 500,
            fade: true,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 4000,
            cssEase: 'linear'
        });
    </script>
@endpush
