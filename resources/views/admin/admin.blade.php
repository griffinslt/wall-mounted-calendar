@extends('layouts.standard')

@section('title', 'Admin Page')

@section('content')

    <div class="row justify-content-center align-items-center g-2">
        <div class="col">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>

                    <p class="card-text">View and edit user information.</p>
                    <a href="#" class="card-link">Card link</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Bookings</h5>

                    <p class="card-text">View and edit booking information.</p>
                    <a href="/bookings" class="card-link">Bookings Page</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Rooms</h5>

                    <p class="card-text">View and Edit Room Information.</p>
                    <a href="#" class="card-link">Card link</a>
                </div>
            </div>
        </div>
        <div class='col'><div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Permission</h5>
                <p class="card-text">View and edit permissions.</p>
                <a href="#" class="card-link">Card link</a>
            </div>
        </div> </div>







        
    </div>


@endsection
