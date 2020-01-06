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
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Real Time
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu rankingslistDropdown">
                                    <li><a class="textRankDropdown" href="{{ route('ranglijst.index') }}">Real Time</a></li>
                                    @foreach ($counterRounds as $counterRound)
                                        <li><a class="textRankDropdown" href="ranglijst/{{$counterRound}}">Ronde {{$counterRound}}</a></li>
                                    @endforeach
                                </ul>

                        </div>
                    </div>
                        {{--Samantha--}}

                        {{--Counts the time from the timer--}}
                        <div id="countdown"></div>
                        {{--end Samantha--}}
                    <div class="card-body">
                        <div class="row">
                            <div class="divider divider-car-up">
                                <span></span></div>
                        </div>
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
    </div>

        {{--Samantha--}}

    <?php
//JS / PHP Timer function
    $now = time();
    $timestamp_file = 'end_timestamp.txt';

    $end_timestamp = file_get_contents($timestamp_file);

    if ($now < $end_timestamp) {
    ?>
    <script>




        // Count down milliseconds = server_end - server_now = client_end - client_now
        var server_end = <?php echo $end_timestamp; ?> * 1000;
        var server_now = <?php echo time(); ?> * 1000;
        var client_now = new Date().getTime();
        var end = server_end - server_now + client_now; // this is the real end time

        var _second = 1000;
        var _minute = _second * 60;
        var _hour = _minute * 60;
        var _day = _hour *24;
        var timer;

        function showRemaining()
        {
            var now = new Date();
            var distance = end - now;
            if (distance < 0 ) {
                clearInterval( timer );



                    document.getElementById('countdown').innerHTML = '<h1>Ronde is beëindigd !</h1>';


                return;
            }
            var days = Math.floor(distance / _day);
            var hours = Math.floor( (distance % _day ) / _hour );
            var minutes = Math.floor( (distance % _hour) / _minute );
            var seconds = Math.floor( (distance % _minute) / _second );

            var countdown = document.getElementById('countdown');
            countdown.innerHTML = '';
            if (days) {
                countdown.innerHTML += 'Days: ' + days + '<br />';
            }
            // countdown.innerHTML += '<h1>' + hours+ ':</h1><br />';
            countdown.innerHTML += '<h1><i class="fas fa-flag"></i> Ronde tijd: ' + minutes + ':' + seconds + '</h1>';
        }

        timer = setInterval(showRemaining, 1000);
    </script>
    <?php
    }
    ?>

    {{--end Samantha--}}
@endsection
