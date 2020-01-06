@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Spelers</div>

                <div class="card-body">
                    <div class="row">
                        <input type="text" id="myInput" onkeyup="filterTable()" placeholder="Naam..." title="Naam">                    
                    </div>
                    <div class="row">
                        <!-- Create table so the user can search on names to make it easier when there are multiple users -->
                        <table id="myTable" style="width:100%;">
                              <thead role="rowgroup">
                                <tr role="row">
                                    <th role="columnheader">Naam</th>
                                    
                                    
                                </tr>
                              </thead>
                              <tbody role="rowgroup">
                                @foreach($users as $user)
                                <tr role="row" onclick="DoNav('{{ route('spelers.show',$user->id)}}');">
                                    <td role="cell">{{$user->f_name}} {{$user->l_name}}</td>
                                    
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

<script>
function DoNav(theUrl)
  {
  //Kinda cheating, but have the table row link without having an <a> around every table data cell </a>
  document.location.href = theUrl;
  }


function filterTable() {
    //define values
      var input, filter, table, tr, td, i, txtValue;

      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
     //get user input and put it in the filter

      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
     // get the table row of our table

        for (i = 0; i < tr.length; i++) { //get the first row of data and filter based on it
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                } else {
                tr[i].style.display = "none";
                }
            }       
        }
}
</script>

@endsection
