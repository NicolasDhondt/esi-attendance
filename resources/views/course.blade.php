@extends('canvas')
@section('navigationMenu')
@include('partials.globalNavigation')
@endsection

@section('content')
<h1 id="title">Liste des cours</h1>

<table id="seanceTable">
    <th>N° cours</th>
    <th>Titre</th>
    @foreach($courses as $course)
    <tr dusk="trCourse" data-href="{{ route('studentsByCourse', ['courseId'=>$course->id]) }}">
        <td>{{$course->id}}</td>
        <td>{{$course->title}}</td>
    </tr>
    @endforeach
</table>
<script type="text/javascript" src="{{ asset('js/clickableTableRow.js') }}"></script>
@endsection