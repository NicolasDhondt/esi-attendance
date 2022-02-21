@extends('canvas')

@section('navigationMenu')
<main>
    <h1 id="homePageTitle">
        ESI - ATTENDANCE
    </h1>
    <ul id="homePageUl" class="list-group list-group-horizontal-xl">
        <li><a href="/">Accueil</a></li>
        <li><a href="/students">Liste des étudiants</a></li>
        <li><a href="/courses">Liste des cours</a></li>
        <li>
            <a dusk="listeSeances" href="/seances/all">Liste des séances</a>
        </li>
        <li>
            <a dusk="addFile" href="/addFiles">Ajouter fichiers</a>
        </li>
    </ul>
</main>
@endsection
