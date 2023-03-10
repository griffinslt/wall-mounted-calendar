@extends('layouts.standard')

@section('title', 'Create Booking Page')

@section('content')


    <h1 class="mx-5">Which building would you like to book a slot in?</h1>

    <div class="container-fluid px-5">
    
        @foreach ($buildings->sortBy('campus')->sortBy('name') as $building)
            <a class = 'btn btn-primary' href="{{route('bookings.create', ['building'=> $building->id])}}"> {{$building->name}} ({{$building->campus}}) </a>
            <p></p>
        @endforeach
    
        <a class="btn btn-danger" href="/bookings">Cancel</a>
    </div>






@endsection
