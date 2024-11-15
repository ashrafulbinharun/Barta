@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    @include('profile.partials.avatar')
    @include('profile.partials.details')
@endsection
