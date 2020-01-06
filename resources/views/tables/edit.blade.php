@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                <form method="POST" action="{{ route('tafel.update', [$round, $table]) }}">
                    @method('patch')
                    @csrf
                    <div class="card-header">
                        <div class="row">
                            <h2>Ronde {{$round}} Tafel {{$table}}</h2>
                        </div>
                    </div>
                    <div class="card-body paddingRoundTable">
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
                                <div class="row">
                                    <p class="roundTable">Rang: #{{$loop->iteration}}</p>
                                </div>
                                <div class="row">
                                    <input type="number" class="form-control" placeholder="Punten:" name="player{{$loop->iteration}}punten" value="{{$tableRound->points}}">
                                    <input type="hidden"  name="player{{$loop->iteration}}id" value="{{$tableRound->id}} ">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <input type=submit class="btn btn-primary" value="Scores aanpassen" style="margin-top:25px;width:100%;">
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
