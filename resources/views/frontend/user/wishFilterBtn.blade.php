<style>
@foreach($categories as $cat)
    #wishFilterBtns button.btnCat{{ $cat->slug }}{
        background-color: #FEFEFE;
        color: {{ $cat->color_code }};
    }

    #wishFilterBtns button.btnCat{{ $cat->slug }} svg {
        width: 16px;
        height: 16px;
        fill: transparent;
    }

    @media only screen and (max-width: 768px) {
        #wishFilterBtns button.btnCat{{ $cat->slug }} svg {
            width: 12px;
            height: 12px;
        }
    }

    #wishFilterBtns button.btnCat{{ $cat->slug }} svg path {
        fill: {{ $cat->color_code }};
    }

    #wishFilterBtns button.btnCat{{ $cat->slug }}.active {
        color: #FEFEFE;
        background-color: {{ $cat->color_code }};
    }

    #wishFilterBtns button.btnCat{{ $cat->slug }}.active svg path {
        fill: #FEFEFE;
    }

    .interest-cat.interest-{{$cat->slug}} button{
        background-color: #FEFEFE;
        color: #8d8d8d;
    }
    .interest-cat.interest-{{$cat->slug}} button.active{
        color: #FEFEFE;
        background-color: {{ $cat->color_code }};
    }
@endforeach
</style>
