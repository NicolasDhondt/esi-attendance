@extends('canvas')

@section('navigationMenu')
@include('partials.globalNavigation')
@endsection

@section('content')

@if(Route::currentRouteName()=='studentsByGroup')
<h1 id="title">Etudiants du groupe {{$students[0]->acronym}}</h1>
@elseif(Route::currentRouteName()=='studentsBySeance')
<h1 id="title">Etudiants du cours : {{$courseTitle->title}} de M. {{$teacherName[0]->last_name}}</h1>
@elseif(Route::currentRouteName()=='studentsByCourse')
<h1 id="title">Etudiants du cours : {{$courseTitle->title}}</h1>
@elseif(Route::currentRouteName()=='students')
<h1 id="title">Liste des étudiants</h1>
@endif

@if(Route::currentRouteName()=='studentsByCourse')
<div id="buttonsActions">
    @include('partials.addStudent')
    @include('partials.removeStudent')
</div>
@endif

<div id="attendance">
    @if(Route::currentRouteName()=='studentsBySeance')
    <div id="buttonAddAll">
        <form action ="{{ route('updateAllAttendance')}}" method="POST">
            @csrf
            <input type="hidden" name="seanceId" value="{{ $seanceId }}">
            <input  type="submit" dusk="selectAll" value="Tout dé/sélectionner" class="btn btn-outline-success">
        </form>
    </div>

    <form name="qrcode" target="_blanc"   action="{{ route('qrcode')}}" method="POST">
    @csrf
    <input type="hidden" name="seanceId" value='{{$seanceId}}'>
    <input dusk="genererQrCodeButton" type="submit" value="Générer QRCode"
        style ="margin: 5%; border-radius: 5px ; cursor:pointer; background: lightblue; padding:5px 15px"/>
    </form>
    @endif
    <table id="studentsTable">
        @if(Route::currentRouteName()=='studentsBySeance')
        <th id="thCheck">Présence</th>
        @endif
        <th>Matricule</th>
        <th>Groupe</th>
        <th>Prénom</th>
        <th>Nom de famille</th>
        @foreach($students as $student)
        <tr>
            @if(Route::currentRouteName()=='studentsBySeance')
            <td class="td_checkbox">
                <input type="checkbox" class="checkbox_max" @click="updateAttendance({{ $student->studentId }},{{ $seanceId }})" dusk="presentCheck" aria-label="Checkbox for following text input" @if($student->present==1)checked @endif>
            </td>
            @endif
            <td class="studentMat" value='{{$student->studentId}}'> {{$student->studentId}}</td>
            <td class="studentGroup"> {{$student->acronym}}</td>
            <td class="studentFirstName"> {{$student->firstName}}</td>
            <td class="studentLastName">{{$student->lastName}}</td>
        </tr>
        @endforeach
    </table>
</div>

<script type="text/javascript" src="{{ asset('js/attendanceUpdate.js') }}"></script>
@endsection
