@extends('layouts.admin')

@section('title', 'Add Permission to Role')

@section('content')
    <div class="container-fluid px-5">
        <h1>Add Permission: {{ $permission->id }} To One Of The Following Roles</h1>
        <p></p>
        @foreach ($roles as $role)
        @if (!$permission->roles->contains($role))
        <a href ="{{route('permissions.add-permission-to-role', ['permission'=>$permission, 'role'=>$role])}}" class = "btn btn-primary"> {{$role->name}}</a>
        <p></p>
        @endif
           
        @endforeach

        <a href="/admin/permissions" class="btn btn-danger">Go Back</a>


    </div>





@endsection
