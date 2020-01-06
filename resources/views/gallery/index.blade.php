@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <h2> Gallerij </h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="gal">
                            @foreach($images as $image)
                                <img class="card-img-top galleryImages" src="{{asset('storage/')}}/{{$image->id}}.png">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
