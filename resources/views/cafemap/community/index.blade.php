@extends('layouts.community')

@section('title', 'Comunidad | Bunaster')

@section('content')
    @include('cafemap.community._reviews_summary', ['reviewsCount' => $reviewsCount])
    @include('cafemap.community._featured_cafes')
    @include('cafemap.community._top_users')
    @include('cafemap.community._feed', ['posts' => $posts])

@endsection
