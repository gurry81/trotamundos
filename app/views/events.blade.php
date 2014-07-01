@extends("layouts.list")

@section("header")
	@parent
@stop

@section("sidebar")
	@parent
@stop

@section("content")
	<?php 
		$options ["type"] = Publication::$type["EVENT"];
		$options["paginate"] = true;

		Publication::filters($options);
		$query = new Query($options);
		
		$posts = Publication::getPublications($query->options);

		if($posts)
			echo GUI::loop($query,$posts,GUI::$templates["POST_LIST"]);
		else
			echo "<span id='no_posts'>" . trans('messages.no-posts') . "</span>";
			
	?>
	
@stop

@section("footer")
	@parent
@stop

