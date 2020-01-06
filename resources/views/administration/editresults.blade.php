@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <select name="dropdown" class="form-control">
            <option value="0" >-----</option>
            @foreach ($rounds as $round)
                <option value="{{$round->round_id}}">Ronde {{$round->round_id}}</option>
            @endforeach
            </select>

            <hr>
            <div class="container">
            <div class="table-select-div" id="table0"> 
                    <div>
                        Selecteer een ronde en tafel combinatie, om deze aan te passen indien iets foutief is ingevuld.
                    </div>
                </div>

            @foreach ($rounds as $round)
            <div class="table-select-div hidden" id="table{{$loop->iteration}}">
             <div class="row">
                @foreach ($tables[$loop->iteration	] as $table)
               
                    <div class="col-sm" style="padding-top:25px;">
                    <!--<form method="POST" action="route('table.edit', $round->round_id)">
                        @csrf
                        <input type="hidden" name="tableid" value="{{$table->id}}"></input>
                        <input type="hidden" name="tablenr" value="{{$table->table}}"></input>
                        <button type="submit" class="btn btn-primary">Verander tafel {{$table->table}}</button>
                    </form>-->

                    <a href="tafel/edit/{{$table->round_id}}/{{$table->table}}" class="btn btn-primary" style="width:100%;"> Tafel {{$table->table}} </a>

                    </div>
               
                @endforeach
                 </div>
                </div>
            @endforeach
            </div>
            

            <script type="text/javascript">
                $(window).load(function(){
                    $('select[name="dropdown"]').change(function() {
                             if ($(this).val() == 0){
                                 //alert($(this).val());
                                 $(".table-select-div").hide(200);                                 
                                 $("#table0").show(200);
                                 }
                        @foreach ($rounds as $round)
                            if ($(this).val() == {{$round->round_id}}){
                                 //alert($(this).val());
                                 $(".table-select-div").hide(200);
                                 $("#table{{$round->round_id}}").show(200);
                            }
                        @endforeach
                     });
                 });
            </script>

        </div>
    </div>
</div>
@endsection
