@extends('layout')
@section('content')


<!-- Blog Post -->
    

                <!-- Title -->
                <h1>{{ $row->title }}</h1>
                <!-- Author -->
                <p class="lead">
                    by {{ $row->name_author }}
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on {{ date('M,d Y',strtotime($row->created_at)) }}</p>

                <hr>

                <!-- Post Content -->
                {!! $row->content !!}
                

                <hr>                

@endsection