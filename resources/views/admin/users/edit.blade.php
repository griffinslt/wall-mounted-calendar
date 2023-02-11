@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="container-fluid px-5">
        <h2>Current Roles</h2>
        <p></p>


        @foreach ($user->roles as $role)
            <div class="row">
                <div class="col">
                    <h3>{{ $role->name }} </h3>
                </div>
                <div class="col"><a href="" class="btn btn-danger">Remove Role From User</a></div>
                <div class='col'></div>
            </div>
        @endforeach
        <hr>

        <h2> Add Roles to User </h2>
        <p></p>
       
        @foreach ($roles as $role)


                    <div class="row">
                        <div class="col">
                            <h3>{{ $role->name }} </h3>
                        </div>
                        <div class="col"><a class="btn btn-primary" href="">Add role to user</a></div>
                        <div class='col'></div>

                    </div>


        @endforeach
        <hr>


        <h5>Want to change name, password or email? click <a class="btn btn-primary" href="/dashboard">here</a></h5>

    </div>





@endsection
