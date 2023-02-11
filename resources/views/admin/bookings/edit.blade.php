@extends('layouts.admin')

@section('title', 'Bookings Page')

@section('content')


    <h1 class="mx-5">Edit Booking: {{ $booking->id }} for room {{ $booking->room->id }}</h1>

    <div class="container-fluid px-5">

        <form method="POST" action="{{ route('bookings.update', ['booking' => $booking]) }}">
            @csrf
            <div class="form-floating">
                <select name="duration" class="form-select" id="floatingSelect" aria-label="Floating label select example">

                    <option value="15">15 Minutes</option>
                    <option value="30">30 Minutes</option>
                    <option value="45">45 Minutes </option>
                    <option value="60">1 Hour</option>
                    <option value="90">1.5 Hours</option>
                    <option value="120">2 Hours</option>
                </select>
                <label form="floatingSelect">Duration</label>
            </div>
            <hr>





            <div class="row justify-content-center align-items-center g-2">
                <div class="col">
                    <div class="form-floating">
                        <select name="day" class="form-select" id="floatingSelect"
                            aria-label="Floating label select example">
                            @for ($i = 0; $i < 31; $i++)
                                <option value="{{ $i + 1 }}">{{ $i + 1 }}</option>
                            @endfor
                        </select>
                        <label form="floatingSelect">Day</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating">
                        <select name="month" class="form-select" id="floatingSelect"
                            aria-label="Floating label select example">
                            @for ($i = 0; $i < 12; $i++)
                                <option value="{{ $i + 1 }}">{{ $i + 1 }}</option>
                            @endfor
                        </select>
                        <label form="floatingSelect">Month</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating">
                        <select name="year" class="form-select" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option value="{{ Carbon\Carbon::now()->format('Y') }}"> {{ Carbon\Carbon::now()->format('Y') }}
                            </option>
                            <option value="{{ Carbon\Carbon::now()->addYears(1)->format('Y') }}">
                                {{ Carbon\Carbon::now()->addYears(1)->format('Y') }}</option>
                        </select>
                        <label form="floatingSelect">Year</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating">
                        <select name="hour" class="form-select" id="floatingSelect"
                            aria-label="Floating label select example">
                            @for ($i = 8; $i < 19; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <label form="floatingSelect">Hour</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating">
                        <select name="minute" class="form-select" id="floatingSelect"
                            aria-label="Floating label select example">
                            @for ($i = 0; $i < 60; $i += 15)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <label form="floatingSelect">Minute</label>
                    </div>
                </div>
            </div>




            <p></p>
            <input type="submit" value="Submit" class="btn btn-primary">

            <a class="btn btn-danger" href="{{ url()->previous() }}">Cancel</a>
        </form>

        <hr>
        <h2>Upcoming Meetings</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Booking ID</th>
                    <th scope="col">Booking Time</th>
                    <th scope="col">Booking Duration/minutes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    @if (Carbon\Carbon::parse($booking->time_of_booking)->gt(Carbon\Carbon::now()))
                        <tr>
                            <th scope="row">{{ $booking->id }}</th>
                            <td>{{ $booking->time_of_booking }}</td>
                            <td>{{ $booking->duration }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

    </div>







@endsection
