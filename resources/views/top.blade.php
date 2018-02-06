@extends('layouts.app')

@section('content')


     <div class="row mt-5">
         <div class="col-6">
           <p class="lead font-weight-bold">Items with the most declutters.</p>
               <table class="table table-striped ">
                <thead class="thead-dark">
                    <tr>
                        <th>Item</th>
                        <th>Declutters</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($declutters as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->declutters }}</td>
                        </tr>
                    @endforeach
                </tbody>
             </table>
         </div>

        <div  class="col-6">
            <p class="lead font-weight-bold">Items with the highest average cost.</p>
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Item</th>
                        <th>Average Cost</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($itemsByCost as $item)
                    <tr>
                        <td>{{ $item[0]->name }}</td>
                        <td>{{ $item[1] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        /*.table {*/
            /*width: 40% !important;*/
        /*}*/

        /*.table-striped {*/
            /*width: 40% !important;*/
        /*}*/
    </style>

@endsection