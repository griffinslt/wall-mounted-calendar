@extends('layouts.admin')

@section('title', 'Create Booking Page')

@section('content')


    <h1 class="mx-5">Which building would you like to book a slot in?</h1>

    <div class="container-fluid px-5">
    
        @foreach ($buildings->sortBy('campus')->sortBy('name') as $building)
            <a class = 'btn btn-primary' href="{{route('bookings.admin.create', ['building'=> $building->id])}}"> {{$building->name}} ({{$building->campus}}) </a>
            <p></p>
        @endforeach

        <h5>Not sure of the details yet?</h5>
        <a class = "btn btn-info" href="{{route('admin.search-by-filter')}}">Search By Filter</a><p></p>
    
        <a class="btn btn-danger" href="/admin/bookings">Cancel</a>
    </div>

    






@endsection
