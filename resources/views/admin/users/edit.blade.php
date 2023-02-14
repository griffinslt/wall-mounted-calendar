@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="container-fluid px-5">
        <h1>Edit User</h1>

        <form action="{{route('users.update', ['user'=>$user])}}" method="post">
            @csrf
            <div class="row">
                <div class='col'>
                    <h5>Email:</h5>
                </div>
                <div class="col"><input type="text" name="email" value="{{ $user->email }}"></div>
                <div class="col"></div>
                <div class="col"></div>
<p></p>
            </div>
            <div class="row">
                <div class='col'>
                    <h5>Name: </h5>
                </div>
                <div class='col'><input type="text" name="name" value="{{ $user->name }}"></div>
                <div class="col"></div>
                <div class="col"></div>
            </div>
<p></p>


        
        
        <p></p>


        <h2>Current Roles</h2>
        <p></p>


        @foreach ($user->roles as $role)
            <div class="row">
                <div class="col">
                    <h3>{{ $role->name }} </h3>
                </div>
                <div class="col"><a href="{{route('users.removeRoleFromUser', ['user'=> $user, 'role' => $role])}}" class="btn btn-danger">Remove Role From User</a></div>
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
                        <div class="col"><a class="btn btn-primary" href="{{route('users.addRoleToUser', ['user'=> $user, 'role' => $role])}}">Add role to user</a></div>
                        <div class='col'></div>

                    </div>


        @endforeach
        <hr>



        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>





@endsection
