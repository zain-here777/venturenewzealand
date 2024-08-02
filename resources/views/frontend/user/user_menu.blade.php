<ul>
    <li class="{{isActiveMenu('user_profile')}}"><a href="{{route('user_profile')}}">{{__('Profile')}}</a></li>
    @if(isOperatorUser() && checkPlaceCreateLimit())
        <li class="{{isActiveMenu('place_addnew')}}"><a href="{{route('place_addnew')}}">{{__('Company Info')}}</a></li>
    @endif
    @if(isOperatorUser())
    <li class="{{isActiveMenu('user_my_place')}}"><a href="{{route('user_my_place')}}">{{__('Company')}}</a></li>
    @endif
    @if(!isOperatorUser())
    <li class="{{isActiveMenu('user_wishlist')}}"><a href="{{route('user_wishlist')}}">{{__('Favourites')}}</a></li>
    @endif
    @if(!isOperatorUser())
    <li class="{{isActiveMenu('user_product_wishlist')}}"><a href="{{route('user_product_wishlist')}}">{{__('Wishlist')}}</a></li>
    @endif
    {{-- @if(isUserAdmin())
    <li class="{{isActiveMenu('operator_list')}}"><a href="{{route('operator_list')}}">{{__('Operator')}}</a></li>
    @endif --}}

</ul>
