@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">

                            <h2> Ranglijst </h2>

                            <div class="dropdown button-rounds">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Ronde {{$id}}
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu rankingslistDropdown">
                                    <li><a class="textRankDropdown" href="{{ route('ranglijst.index') }}">Real Time</a></li>
                                    @foreach ($counterRounds as $counterRound)
                                        <li><a class="textRankDropdown" href="{{$counterRound}}">Ronde {{$counterRound}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <table class="table table-borderless">
                                <tbody>

                                @foreach ($ranking as $rank)
                                    <tr>
                                        @if ($rank['rank'] == 1)
                                            <th><i class="fas fa-trophy trophy-gold"></i></th>
                                        @elseif ($rank['rank'] == 2)
                                            <th><i class="fas fa-trophy trophy-silver"></i></th>
                                        @elseif ($rank['rank'] == 3)
                                            <th><i class="fas fa-trophy trophy-bronze"></i></th>
                                        @else
                                            <th> #{{$rank['rank']}} </th>
                                        @endif
                                        <td> {{$rank['player']}} </td>
                                        <td> {{$rank['score']}} </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
