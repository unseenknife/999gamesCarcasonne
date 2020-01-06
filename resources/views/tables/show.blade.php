@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <h2>Ronde {{$round}} Tafel {{$table}}</h2>
                        </div>
                    </div>
                    <div class="card-body paddingRoundTable">
                        {{--Samantha--}}


                        @foreach ($tableRounds as $tableRound)
                            <div class="col-2 margin-topRoundTable">
                                <div class="row">
                                    <img src="{{asset('img')}}/Player{{$loop->iteration}}.png" class="playerImg">
                                </div>
                            </div>
                            <div class="col-4 margin-topRoundTable">
                                <div class="row">
                                    <p class="font-weight-bold">{{$tableRound->f_name}} {{$tableRound->l_name}}</p>
                                </div>
                            @if ($tableRound->points == NULL)
                                <div class="row">
                                    <p class="roundTable">Rang:</p>
                                </div>
                            @else
                                <div class="row">
                                    <p class="roundTable">Rang: #{{$loop->iteration}}</p>
                                </div>
                            @endif
                                <div class="row">
                                    <p class="roundTable">Punten: {{$tableRound->points}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
