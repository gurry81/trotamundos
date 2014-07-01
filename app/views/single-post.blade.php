@extends("layouts.single")

@section("header")
	@parent
@stop

@section("sidebar")
	<?php 

		$details = ["author" => $post->author,
					"except" => [$post->id],
					"type" => Publication::$type['NEW']];

		$templates = [GUI::$templates["MORE_AUTHOR"],GUI::$templates["TOP_PUBLICATIONS"]];
	?>
	{{GUI::sidebar($templates,$details)}}
@stop

@section("content")

	{{GUI::single($post,GUI::$templates["SINGLE_POST"])}}
	
@stop

@section("footer")
	@parent
@stop