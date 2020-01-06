@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Beheer</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <a class="btn btn-primary beheer" href="{{ route('score.create')}}" role="button">Uitslag ronde invoeren</a>
                        </div>
                        <div class="col-sm">
                            <a class="btn btn-primary beheer" href="{{ route('round-edit')}}" role="button">Uitslag aanpassen</a>
                        </div>
                    </div>
                    <div class="row" style="padding-top:20px;">
                        <div class="col-sm">
                            <a class="btn btn-primary beheer" href="{{ route('indeling') }}" role="button">Volgende ronde starten</a>
                        </div>
                        <div class="col-sm">
                            <a class="btn btn-primary beheer" href="#" role="button">Toernament afsluiten</a>
                        </div>
                    </div>
                    <div class="row" style="padding-top:20px;">
                        <div class="col-sm">
                        </div>
                        <div class="col-sm">
                            <a class="btn btn-primary beheer" href="{{ route('gallerij.create') }}" role="button">Gallerij</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
