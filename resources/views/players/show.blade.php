@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="col-sm-12 headerProfile">
                            <h2 class="font-weight-bold">{{$profiles[0]->f_name}} {{$profiles[0]->l_name}}</h2>
                        </div>
                        <div class="col-sm-12 headerProfile">

                            <h2 class="font-weight-bold">#{{$playerRank['rank']}}</h2>
                        </div>
                    </div>
                    <div class="card-body col-md-12 profileBackground">
                        <p class="fontProfile font-weight-bold">Totaal score: {{$playerRank['score']}}</p>
                        <p class="fontProfile font-weight-bold">Totaal punten: {{$totalPoints}}</p>

                        <table class="table table-reflow">
                            <thead>
                            <tr>
                                <th class="fontProfile FontTableData">Ronde</th>
                                <th class="fontProfile FontTableData">Rang</th>
                                <th class="fontProfile FontTableData">Punten</th>
                                <th class="fontProfile FontTableData">Score</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($profileRank as $profile)
                                    <tr>
                                        <td class="fontProfile FontTableData">{{$profile['round']}}</td>
                                        @if($profile['score'] != 0)
                                            <td class="fontProfile FontTableData">#{{$profile['rank']}}</td>
                                        @else
                                            <td class="fontProfile FontTableData">#</td>
                                        @endif
                                        <td class="fontProfile FontTableData">{{$profile['points']}}</td>
                                        <td class="fontProfile FontTableData">{{$profile['score']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
