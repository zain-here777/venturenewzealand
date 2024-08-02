<div id="plan_modal_body_user">
    {{-- <h3 class="text-center">Pricing Plan</h3> --}}

    {{-- <article class="card__content">
        <div class="card__pricing">
            <div class="card__pricing-number">
                <span
                    class="card__pricing-symbol">$</span>{{App\Models\UserSubscription::getSubscriptionPriceForUserType(1)}}
            </div>
            <span class="card__pricing-month">/month</span>
        </div> --}}

        {{-- <header class="card__header">
            <div class="card__header-circle">
                <img src="https://fadzrinmadu.github.io/hosted-assets/responsive-pricing-card-using-html-and-css/free-coin.png"
                    alt="" class="card__header-img">
            </div>

            <span class="card__header-subtitle">{{App\Models\UserSubscription::getSubscriptionDaysForUserType(1)}}
                Days</span>
            <h1 class="card__header-title">{{getUserTypePhrase(1)}}</h1>
        </header> --}}

        {{-- <ul class="card__list">
            <li class="card__list-item">
                <i class="fal fa-check"></i>
                <p class="card__list-description"><span>➤</span> Get unlimited access to the directory to find places of
                    interest near you</p>
            </li>
            <li class="card__list-item">
                <i class="fal fa-check"></i>
                <p class="card__list-description"><span>➤</span> Follow your favourite companies</p>
            </li>
            <li class="card__list-item">
                <i class="fal fa-check"></i>
                <p class="card__list-description"><span>➤</span> Scan in at your favourite companies in Venture New
                    Zealands directory to earn points to redeem in monthly competions</p>
            </li>
            <li class="card__list-item">
                <i class="fal fa-check"></i>
                <p class="card__list-description"><span>➤</span> Create your own profile to get notifications for new
                    products your interested in</p>
            </li>
            <li class="card__list-item">
                <i class="fal fa-check"></i>
                <p class="card__list-description"><span>➤</span> Be in the chance to win monthly prizes</p>
            </li>

        </ul> --}}
        <div class="anuual-modal">
            <h1>Join Now</h1>
            <h4>Annual Venture</h4>
            <div class="modal-price">
                <h2>${{App\Models\UserSubscription::getSubscriptionPriceForUserType(1)}}</h2>
                <span>Per year</span>
            </div>
            <ul>
                <li>Follow your favourite companies</li>
                <li>Find featured products to get amazing deals</li>
                <li>Find free activities and attractions</li>
                <li>Earn rewards as you travel and participate in awesome competitions</li>
                <li>Use Venture maps to find the closest attractions</li>
            </ul>
        </div>
        <div class="text-center">
            <button type="button" class="btn" data-dismiss="modal" data-toggle="modal"
                data-target="#stripe_modal">Subscribe</button>
        </div>
        {{--
    </article> --}}
</div>
