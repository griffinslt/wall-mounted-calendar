@extends('layouts.standard')

@section('title', 'Users Page')

@section('content')

    <h1 class="mx-5">User Page</h1>

    <div class='container-sm'>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Booking(s)</th>
                    <th scope="col">Role(s)</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name}}</td>
                        <td>{{ $user->email }}</td>
                        <td><button class = "btn btn-info">Go There</button></td>
                        <td>
                            @foreach ($user->getRoleNames() as $role)
                             <p>{{$role}}</p>
                            @endforeach

                
                        </td>
                        <td><button class="btn btn-success">Edit</button>  <button class='btn btn-danger'>Delete</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


@endsection
