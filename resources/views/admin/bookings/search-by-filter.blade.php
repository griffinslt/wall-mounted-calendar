@extends('layouts.admin')

@section('title', 'Search By Filter')

@section('content')

@livewire('filter-rooms', ['rooms' => $rooms, 'buildings' => $buildings])



    
@endsection