@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Beheer</div>

                <div class="card-body">
                    <div>
                    <form method="POST" action="{{ route('user-edit-delete', $user->id)}}">
                       @method('delete')
                       @csrf
                       <button type="submit" class="btn btn-danger" style="position: relative;left: 95%;">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </form>
                    </div>
                    <div class="row">
                       <form method="POST" action="{{ route('user-edit-save', $user->id)}}" style="width:100%;">
                       @method('patch')
                       @csrf
                        <div class="row" >
                            <div class="col-sm" style="padding-bottom:25px;">
                                <p>Voornaam:</p>
                                <input type="text" class="form-control" name="f_name" value="{{$user->f_name}}">
                            </div>
                            <div class="col-sm" style="padding-bottom:25px;">
                                <p>Achternaam:</p>
                                <input type="text" class="form-control" name="l_name" value="{{$user->l_name}}">
                            </div>
                            <div class="col-sm" style="padding-bottom:25px;">
                                <p>Rol:</p>
                                <select name="roleid" class="form-control">
                                    @foreach($roles as $role)
                                    <option value="{{$role->id}}" @if($user->roles->id == $role->id) selected @endif >{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                       </div>
                       <div class="row" >
                            <div class="col-sm"  style="padding-bottom:25px;">
                                <p>E-mail:</p>
                                <input type="text" class="form-control" name="email" value="{{$user->email}}">
                            </div>
                            
                            <div class="col-sm">
                                <p>Telefoon nummer:</p>
                                <input type="text" class="form-control" name="phone_nr" value="{{$user->phone_nr}}">
                            </div>
                       </div>
                    <input type=submit class="btn btn-primary" value="Gebruiker aanpassen" style="margin-top:25px;width:100%;">
                    </form>     
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
