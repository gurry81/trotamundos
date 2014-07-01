@extends('layouts.error')

@section('error')
	<h2 class="title">{{$error["title"]}}</h2>
	<div class="info">{{$error["info"]}}</div>
@stop
