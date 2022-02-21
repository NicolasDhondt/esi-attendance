@extends('canvas')

@section('content')

@isset($isAuthenticated)
        @if ($isAuthenticated==1)
                 <h1> Vous avez été bien authentifier  </h1> <br>
                 <h4> vous etes présent.</h4>
        @else
                 <h1>   Désolé vous n'etes pas enregistrer dans ce cours </h1>
        @endif
@endisset


@endsection
