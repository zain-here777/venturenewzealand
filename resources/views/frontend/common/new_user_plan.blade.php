<div class="modal fade new_user_plan_modal" id="new_user_plan" tabindex="-1" role="dialog" aria-labelledby="plan_feature"
    aria-hidden="true" style="overflow:scroll;">
    <div class="modal-dialog modal-dialog-centered modal-lg justify-content-center">
        <div class="d-flex w-100 modal-flex">
            <div class="modal-content free-ccount">
                <div class="modal-body member-wrap mb-0">
                    <div class="wrapper_content">
                        <h3>Casual<br/>Venture Membership</h3>
                        <div class="price">
                            <h2>$0<span>/Year</span></h2>
                        </div>
                        <ul class="wrapper_li">
                            <li>Easy Bookings</li>
                            <li>Access to the Venture New Zealand Directory and Deals</li>
                            <li>Follow your Favorite operators</li>
                            <li>Booking Fees</li>
                            <li>Stay up to date with local deals and discounts</li>
                        </ul>
                        <div class="text-center">
                            <button class="btn" data-type="free"
                                onclick="userPlanType('free',0)">Sign Up</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-content">
                <div class="modal-header">
                    <p>Most Popular</p>
                </div>
                <div class="modal-body member-wrap mb-0">
                    <div class="wrapper_content">
                        <h3><span style="color:#72BF44">Premium</span><br/>Venture Membership</h3>
                        <div class="price">
                            <h2>${{ App\Models\UserSubscription::getSubscriptionPriceForUserType(1) }}<span>/Year</span>
                            </h2>
                        </div>
                        <ul class="wrapper_li">
                            <li>Access to the Itinerary planner </li>
                            <li>Earn rewards</li>
                            <li style="color:#72BF44; font-weight:bold">NO BOOKING FEES</li>
                            <li>Enter Competitions</li>
                            <li>Win Giveaways</li>
                            <li>Entry into the 'VNZ Open Days'</li>
                        </ul>
                        <div class="text-center">
                            <button class="btn" data-type="paid"
                                data-val="{{ App\Models\UserSubscription::getSubscriptionPriceForUserType(1) }}"
                                onclick="userPlanType('paid',{{ App\Models\UserSubscription::getSubscriptionPriceForUserType(1) }})">Sign
                                Up</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
