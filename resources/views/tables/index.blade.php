{{--Samantha added--}}
@extends('layouts.app')

@section('content')
    <div class="text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                Tafels
                            </div>
                        </div>

                        <!-- Accordion -->
                        <div class="container-fluid bg-gray" id="accordion-style-1">
                            <div class="container">
                                <section>
                                    <div class="row">
                                        <div class="col-10 mx-auto">
                                            <div class="accordion" id="accordionExample">

                                                 @for($i = 1; $i < count($round_table); $i++)
                                                    @if($i == 1 || $round_table[$i]->round_id != $round_table[$i-1]->round_id)
                                                        <div class="card">
                                                            <div class="card-header" id="headingOne">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#collapse{{$round_table[$i]->round_id}}" aria-expanded="true" aria-controls="collapseOne">
                                                                        <ul class="list-button"><li>
                                                                                <img src="{{ asset('img/divider-black.png') }}">
                                                                                <img src="{{ asset('img/divider-carcassonne-up-black.png') }}">
                                                                                <img src="{{ asset('img/divider-black.png') }}">
                                                                            </li>
                                                                            <li>Round {{$round_table[$i]->round_id}}</li>
                                                                        </ul>
                                                                    </button>
                                                                </h5>
                                                            </div>

                                                            <div id="collapse{{$round_table[$i]->round_id}}" class="collapse @if($round_table[$i]->round_id == 1) show @endif fade" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                                <!-- try -->

                                                                @foreach($round_table as $round)
                                                                    @if($round->round_id == $round_table[$i]->round_id)
                                                                        <ul class='table_list'><li><a href="{{ route('tafel.show',[$round->round_id, $round->table]) }}" class="table_link">Tafel: {{ $round->table }}</a></li></ul>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                @endif
                                            @endfor
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection
