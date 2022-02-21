@extends('canvas')

@section('navigationMenu')
@include('partials.globalNavigation')
@endsection

@section('content')
@if($teacher == 'all')
<h1 id="title">L'ensemble des cours</h1>
@else
<h1 id="title">Cours du professeur {{$teacher}}</h1>
@endif

<body onload="initCalendar('{{$teacher}}')">
    <form id="selectsFilters">
        <span>Filtres : </span>
        <select dusk="selectTeacher" name="selectTeacher" id="selectTeacher">
            <option value="all">Tous les Profs</option>
        </select>
        <button dusk="selectTeacherButton" type="button" onclick="getSeanceByTeacher()" class="btn btn-dark">Chercher</button>
    </form>

    <div id='calendar'></div>

    <script type="text/javascript" src="{{ asset('js/clickableTableRow.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/fullcalendar.js') }}"></script>

</body>

@endsection
