@extends('layouts.no-navbar')

@section('content')
    @auth
        <welcome-page></welcome-page>
    @else

        <Login></Login>
    @endauth


@endsection
