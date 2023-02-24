@extends('layouts.admin')

@section('title', 'Edit Role')

@section('content')
    <div class="container-fluid px-5">
        <h1>Name Role</h1>
<p></p>
        <form method="POST" action="{{route('permissions.store-role')}}">
            @csrf
            <div class="row">
                <div class='col'>
                    <h5>Role Name:</h5>
                </div>
                <div class="col"><input type="text" name="name" value=""></div>
                <div class="col"></div>
                <div class="col"></div>
<p></p>
            </div>
            <input type="submit" value="Submit" class="btn btn-primary">
            <a class="btn btn-danger" href="/admin/permissions">Back</a>
        </form>


    </div>





@endsection
