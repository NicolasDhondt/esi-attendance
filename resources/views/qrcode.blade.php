@extends('canvas')
@section('navigationMenu')
@include('partials.globalNavigation')
@endsection
@section('content')
@if(Route::currentRouteName()=='qrcode')
<div class="card">
    <div id="qr">
        <a id="qrtitle">Inscrivez-vous au cours </a>
        <a id="qrtitle2">Scannez le QrCode</a>
    </div>

       <div dusk="qrCodeImage" class="qrCodePage" >
            <span style="display:flex; justify-content:center;">{!! QrCode::size(350)->generate("$urlLogin") !!}</span>
            </div>
        </div>
@endif
@endsection
