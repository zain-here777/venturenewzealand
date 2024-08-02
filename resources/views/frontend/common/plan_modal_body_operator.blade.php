<div id="plan_modal_body_operator">
    {{-- <h3 class="text-center">Pricing Plan</h3> --}}

    @php
    $operatorPrice = App\Models\UserSubscription::getOperatorStripePriceObject();

    $interval = $operatorPrice->recurring->interval;
    $interval_count = $operatorPrice->recurring->interval_count;

    if($interval_count==1){
    $interval_count="";
    }
    $amount = $operatorPrice->unit_amount;

    $product = App\Models\UserSubscription::getOperatorStripeProductObject($operatorPrice->product);
    $productName = $product->name;
    $isFreeSubscriptionAllow=App\Models\User::isFreeSubscriptionAllow();
    $trial_period_days=App\Models\User::freeSubscriptionDays();
    @endphp

    {{-- <article class="card__content"> --}}
        {{-- <div class="card__pricing">
            <div class="card__pricing-number">
                <span class="card__pricing-symbol">$</span>{{$amount/100}}
            </div>
            <span class="card__pricing-month">/{{$interval_count}}{{$interval}}</span>
        </div>

        <header class="card__header">
            <div class="card__header-circle">
                <img src="https://fadzrinmadu.github.io/hosted-assets/responsive-pricing-card-using-html-and-css/free-coin.png"
                    alt="" class="card__header-img">
            </div>

            {{--
            <!-- <span class="card__header-subtitle">{{App\Models\UserSubscription::getSubscriptionDaysForUserType(2)}} Days</span> -->
            --}}
            {{-- <h1 class="card__header-title">{{$productName}}</h1>
        </header>

        <ul class="card__list">
            <li class="card__list-item">
                <i class="fal fa-check"></i>
                <p class="card__list-description"><span>➤</span> List 3 products in your company profile.</p>
            </li>
            <li class="card__list-item">
                <i class="fal fa-check"></i>
                <p class="card__list-description"><span>➤</span> Change your deals when you want.</p>
            </li>
            <li class="card__list-item">
                <i class="fal fa-check"></i>
                <p class="card__list-description"><span>➤</span> Feature your best deals.</p>
            </li>
            <li class="card__list-item">
                <i class="fal fa-check"></i>
                <p class="card__list-description"><span>➤</span> Notify your companies followers when you list new
                    products or deals.</p>
            </li>
        </ul>--}}
        <div class="anuual-modal">
            <h1>Join Now</h1>

            @if($trial_period_days>0)
            <p>
                Get a free subscription till the <span>{{$trial_period_days}}.</span> Payments will be automatically
                deducted moving forward!
            </p>
            @endif
            <h4>Operators Venture</h4>
            <div class="modal-price">
                <h2>${{$amount/100}}</h2>
                <label>Per {{$interval_count}}{{$interval}}</label>
            </div>
            <ul>
                <li>Create your own company profile</li>
                <li>Add up to 3 products</li>
                <li>Login and change your deals when you want</li>
                <li>Users following your company get notifications when you add deals and change products</li>
                <li>Get paid within 24 hours when you set up a stripe connect account</li>
                <li>No commissions</li>
            </ul>
        </div>
        <div class="text-center">
            <button type="button" class="btn" data-dismiss="modal" data-toggle="modal"
                data-target="#stripe_modal">Subscribe</button>
        </div>
        {{--
    </article> --}}
</div>
