@extends("layouts.list")

@section("header")
	@parent
@stop

@section("sidebar")
	@parent
@stop

@section("content")
	<?php 
		$options ["type"] = Publication::$type["ALL"];
		$options["paginate"] = true;
		$options["author"] = $author;

		Publication::filters($options);
		$query = new Query($options);
		
		$posts = Publication::getPublications($query->options);

		if($posts)
			echo GUI::loop($query,$posts,GUI::$templates["POST_LIST"]);
		else
			echo "<div id='no_posts'>" . trans("messages.no-posts") . "</div>";
	?>

@stop

@section("footer")
	@parent
@stop
	