@extends('layouts.admin')

@section('title', 'Users Page')

@section('content')

<div class="row px-5">
    <div class="col"><h1>Users Page</h1></div>
    <div class="d-flex justify-content-end col"><a href="">Create User</a>
    </div>
</div>


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
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><a href="{{route('bookings.index-for-user', ['user' => $user->id])}}" class="btn btn-info">Bookings</a></td>
                        <td>
                            @foreach ($user->getRoleNames() as $role)
                                <p>{{ $role }}</p>
                            @endforeach


                        </td>
                        <td><a href= "{{route('users.edit', ['user' => $user->id])}}" class="btn btn-success">Edit</a> 
                            <button data-bs-target="#deleteModal"
                                data-bs-toggle="modal" data-url="{{route('users.destroy', ['user' => $user->id])}}"
                                class='btn btn-danger delete-user'>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>




    
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    <form action="" method="post" id="deleteForm">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger"> Delete User </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="//code.jquery.com/jquery-2.1.3.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // For A Delete Record Popup
            $('.delete-user').click(function() {
                var url = $(this).attr('data-url');
                console.log(url);
                $("#deleteForm").attr("action", url);
            });
        });
    </script>


@endsection
