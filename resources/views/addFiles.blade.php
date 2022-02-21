@extends('canvas')

@section('navigationMenu')
@include('partials.globalNavigation')
@endsection

@section('content')
<b id="helpForm"> Aide : afin de sélectionner plusieurs fichiers, maintenez la touche CTRL ou SHIFT enfoncée lors de la sélection des fichiers.</b>
<div>
    <form action="{{ url('addCSV') }}" method="post" enctype="multipart/form-data" id=fileForm>
        @csrf
        <h4>Ajout de fichiers csv :</h4>
        <br>
        <input dusk="addCsv" multiple type="file" name="csv[]" required>
        <br>
        <br>
        <button dusk="sendCsv" type="submit" class="btn btn-outline-secondary" name="sendCSV"><b>Ajouter les fichiers csv</b></button>
    </form>
    <form action="{{ url('addICS') }}" method="post" enctype="multipart/form-data" id=fileForm>
        @csrf
        <h4>Ajout de fichiers ics :</h4>
        <br>
        <input dusk="addIcs" multiple type="file" name="ics[]" required>
        <br>
        <br>
        <button dusk="sendIcs" type="submit" class="btn btn-outline-secondary" name="sendICS"><b>Ajouter les fichiers ics</b></button>
    </form>
</div>
@endsection