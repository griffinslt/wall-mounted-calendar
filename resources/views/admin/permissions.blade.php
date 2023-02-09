@extends('layouts.admin')

@section('title', 'Permissions Page')

@section('content')


    <div class="row">
        <div class="col">
            <h1 class="mx-5">Roles Table</h1>


            <div class='container-fluid mx-5'>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Roles</th>
                            <th scope="col">Permissions</th>
                            <th scope="col">Role Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>

                                <th scope="row">{{ $role->name }}</th>
                                <td>
                                    @foreach ($role->permissions as $permission)
                                        <div class="row">
                                            <div class="col">{{ $permission->name }} </div>
                                            <div class="col">
                                                <a href="{{route('permissions.remove-permission-from-role', ['role' => $role->id, 'permission' => $permission->id])}}" class="btn btn-warning">Remove Permission From
                                                    Role</a>
                                                </div>
                                        </div>

                                        <hr>
                                    @endforeach

                                </td>

                                <td><button class="btn btn-success">Edit Role</button>
                                    <button class="btn btn-danger">Delete Role</button>
                                </td>
                                {{-- <button data-bs-target="#deleteModal"
                                data-bs-toggle="modal" data-url="{{route('rooms.destroy', ['room' => $room->id])}}"
                                class='btn btn-danger delete-booking'>Delete Role</button> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <div class="col">
            <h1 class="mx-5">Permissions Table</h1>


            <div class='container-fluid mx-5'>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Permission</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <th scope="row">{{ $permission->name }}</th>
                                <td>
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col"><button class="btn btn-success">Edit Permission</button></div>
                                        <div class="col"><button class="btn btn-primary">Add Permission To Role</button>
                                        </div>
                                        <div class="col"><button class="btn btn-danger">Removed Permission</button></div>
                                    </div>
                                </td>



                                {{-- <button data-bs-target="#deleteModal"
                                data-bs-toggle="modal" data-url="{{route('rooms.destroy', ['room' => $room->id])}}"
                                class='btn btn-danger delete-booking'>Delete</button></td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>




    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this room?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    <form action="" method="post" id="deleteForm">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger"> Delete Role </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="//code.jquery.com/jquery-2.1.3.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // For A Delete Record Popup
            $('.delete-booking').click(function() {
                var url = $(this).attr('data-url');
                console.log(url);
                $("#deleteForm").attr("action", url);
            });
        });
    </script>




@endsection
