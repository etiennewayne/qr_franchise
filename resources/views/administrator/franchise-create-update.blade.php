@extends('layouts.app')

@section('content')
    <franchise-create-update data-id="{{$dataid}}" prop-data='@json($data)'></franchise-create-update>
@endsection

