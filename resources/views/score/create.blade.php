@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('score.store') }}">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <h2> Score invoeren </h2>

                            <div class="dropdown button-rounds">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                    @if($counterTables != "")
                                        Ronde {{$round_id}}
                                    @else
                                        Selecteer ronde
                                    @endif
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    @foreach ($counterRounds as $counterRound)
                                        <li><a href="{{route('score.round', $counterRound)}}">Ronde {{$counterRound}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @if($counterTables != "")
                            <div class="dropdown button-rounds">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                    @if($tableRounds != "")
                                        Tafel {{$table_id}}
                                    @else
                                        Selecteer tafel
                                    @endif
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    @foreach ($counterTables as $counterTable)
                                        <li><a href="{{route('score.table', [$round_id, $counterTable])}}">Tafel {{$counterTable}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif


                        </div>
                    </div>
                    @if($tableRounds != "")
                    <div class="card-body">
                        <div class="row">
                            <div class="divider divider-car-up">
                                <span></span></div>
                        </div>
                        <div class="row">
                            <table class="table table-borderless">
                                <tbody>

                                    @csrf
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
                                            <label>Punten: </label><input style="width: 70%;margin-left: 4%;" type="number" class="form-control" name="player{{$loop->iteration}}punten" value="{{$tableRound->points}}">
                                            <input type="hidden" name="player{{$loop->iteration}}id" value="{{$tableRound->player_id}}">
                                            <input type="hidden" name="table_id" value="{{$table_id}}">
                                            <input type="hidden" name="round_id" value="{{$round_id}}">
                                        </div>
                                    </div>
                                @endforeach
                                    <div class="col-md-4 offset-5"><input type=submit class="btn btn-primary" value="Scores opslaan" style="margin-top:25px;width:50%;"></div>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
