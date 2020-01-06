@extends('layouts.app')

@section('content')
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            
                            <h2> Timer </h2>


                        </div>
                    </div>
                    {{--Samantha--}}
                    {{--form timer--}}
                    <br>
                    <form action="{{ route('ranglijst.index') }}" method="post" >
                        @csrf
                        Minutes: <input type="text" id="mns" name="mns" value="0" size="3" maxlength="3" /> &nbsp; &nbsp;
                        Seconds: <input type="text" id="scs" name="scs" value="0" size="2" maxlength="2" /><br/>
                        <input type="hidden" name="type" value="timer" />
                        <br/>
                        <input  class="btn btn-success" type="submit"  id="btnct" value="START"/>

                    </form>
                    {{--end form timer--}}
                    {{--end Samatha--}}


                </div>
            </div>
        </div>
    </div>
@endsection
