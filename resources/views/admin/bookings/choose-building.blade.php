@extends('layouts.admin')

@section('title', 'Create Booking Page')

@section('content')


    <h1 class="mx-5">Which building would you like to book a slot in?</h1>

    <div class="container-fluid px-5">
    
        @foreach ($buildings as $building)
            <a class = 'btn btn-primary' href="{{route('bookings.admin.create', ['building'=> $building->id])}}"> {{$building->name}} ({{$building->campus}}) </a>
            <p></p>
        @endforeach
    
    </div>






@endsection
