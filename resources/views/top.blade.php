@extends('layouts.app')

@section('content')


     <div class="row mt-5">
         <div class="col-md-6 mb-5">
           <p class="lead font-weight-bold">Most Declutters.</p>
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
                            <td><a href="/items/{{$item->id}}" style="color: seagreen">{{ $item->name }}</a></td>
                            <td>{{ $item->declutters }}</td>
                        </tr>
                    @endforeach
                </tbody>
             </table>
         </div>

        <div  class="col-md-6">
            <p class="lead font-weight-bold">The highest average cost.</p>
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
                        <td><a href="/items/{{$item[0]->id}}" style="color: seagreen">{{ $item[0]->name }}</a></td>
                        <td>${{ number_format((float)$item[1], 2, '.', '') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection