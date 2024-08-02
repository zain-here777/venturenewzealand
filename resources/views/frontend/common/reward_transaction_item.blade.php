    <li>
        <div class="reward_history_block">
            <div class="reward_title">
                <h3><i class="la la-gift"></i>{{$transaction->title}}</h3>
                <p class="d-flex align-items-center date"><i class="la la-calendar "></i>{{dateFormat($transaction->created_at)}}</p>
            </div>
            
            <div class="reward_bottom">
                <p class="desc">{{$transaction->description}}</p>
                <p class="points @if($transaction->transaction_type==2) red @endif">
                    <span>Points:</span>
                    @if($transaction->transaction_type==1) + @endif
                    @if($transaction->transaction_type==2) - @endif 
                    {{cleanDecimalZeros($transaction->points)}}</p>
            </div>
        </div>
    </li>
