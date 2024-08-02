@extends('admin.layouts.template')

@section('main')

    <div class="page-title">
        <div class="title_left">
            <h3>Participants</h3>
        </div>
        <div class="title_right">
            <div class="pull-right">
                <a class="btn btn-primary" href="{{route('admin_competition_list')}}">Back</a>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content" style="font-size: 16px;">
                    <div class="col-md-6">
                        <div> <b>Competition :</b> {{$competition->title}} </div>
                        <div> <b>Entry Fee Points :</b> {{cleanDecimalZeros($competition->entry_fee_points)}} </div>
                        <div> <b>Prize Points :</b> {{cleanDecimalZeros($competition->prize_points)}} </div>
                        <div> <b>Start Date :</b> {{dateFormat($competition->start_date)}} </div>
                        <div> <b>End Date :</b> {{dateFormat($competition->end_date)}} </div>
                    </div>

                    <div class="col-md-6">
                        <div> <b>Total Participants :</b> {{count($competitions_participants)}} </div>
                        @if($competition_winner && $competition_winner->user)
                            <div> <b>Winner :</b> {{$competition_winner->user->name}} , {{$competition_winner->user->email}}</div>
                        @else
                            <div> <b>Winner :</b> N/A </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <table class="table table-striped table-bordered golo-datatable">
                        <thead>
                            <tr>
                                <th width="3%">ID</th>
                                <th>Participant Name</th>
                                <th>Email</th>
                                <th>Competition Joined At</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($competitions_participants))
                            @php
                                $winStatus = participantWinnerStatus();
                            @endphp
                                @foreach($competitions_participants as $participant)
                                    @if($participant->user)
                                    <tr>
                                        <td>{{$participant->id}}</td>
                                        <td>{{$participant['user']['name']}}</td>
                                        <td>{{$participant['user']['email']}}</td>
                                        <td>{{dateTimeFormat($participant->created_at)}}</td>

                                        <td class="golo-flex">
                                            @if($participant->status==$winStatus)
                                                <button type="button" class="btn btn-success btn-xs" disabled>Winner</button>
                                            @else
                                                @if(!$competition_winner)
                                                    <form id="declare_winner_form_{{$participant->id}}" action="{{route('admin_participant_declare_winner',$participant->id)}}" method="POST">
                                                        @csrf
                                                        <button onclick="event.preventDefault(); if (confirm('Are you sure?')) {document.getElementById('declare_winner_form_{{$participant->id}}').submit();}" type="button" class="btn btn-info btn-xs">Declare Winner</button>
                                                    </form>
                                                @endif
                                            @endif

                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

@push('scripts')
    <script src="{{asset('admin/js/page_place.js')}}"></script>
@endpush
