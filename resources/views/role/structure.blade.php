@extends('layouts.dashboard')

@section('title','Organization Structure')

@section('content')
    @include('role.employees_tree')
@endsection