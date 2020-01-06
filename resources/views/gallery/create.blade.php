@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <h2>Foto toevoegen</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route ('gallerij.index')}}" enctype="multipart/form-data">
                            @CSRF
                            <div class="form-group row">
                                <label for="title" class="col-sm-3 col-form-label">Naam:</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <input type="text" class="form-control" id="title" name="title">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-9 offset-sm-3 galleryInput">
                                <input type="file" class="form-control-file inputFileGallery" name="file">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-9 offset-sm-3 galleryInput">
                                    <button type="submit" class="btn btn-primary btnGallery">Sla mij op!</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
