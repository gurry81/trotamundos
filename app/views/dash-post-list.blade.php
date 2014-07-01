@extends("layouts.dashboard")

@section("styles")
	@parent
	{{HTML::style("css/dash-list.css")}} 
@stop

@section("content")
	<?php  
		$data["template"] = GUI::$templates["DASH-POST-TABLE"];
		$options = [
			"limit" => 10,
			"paginate" => true,
			"lang" => false,
			"orderby" => 'updated_at',
			"order" => Input::has('order')? Input::get('order'): 'DESC',
		];
		
		$user = Auth::user();

		switch ($user->type){
		 	case "normal":
		 		break;
		 	case "author":
		 		$options["type"] = Publication::$type["NEW"];
		 		$options["author"] = $user->email;
		 		break;
		 	case "organization":
		 		$options["type"] = Publication::$type["EVENT"];
		 		$options["author"] = $user->email;
		 		break;
		 	case "admin":
		 		$options["type"] = Publication::$type["ALL"];
		 		break;
		 }

		 Publication::filters($options);

		 $data["query"] = new Query($options);
		 $data["posts"] = Publication::getPublications($data["query"]->options);

	?>
	{{GUI::dashboard(GUI::$templates["DASH-POST-LIST"], $data)}}
@stop