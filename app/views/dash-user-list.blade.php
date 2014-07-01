@extends("layouts.dashboard")

@section("styles")
	@parent
	{{HTML::style("css/dash-list.css")}} 
@stop

@section("content")
	<?php  
		$data["template"] = GUI::$templates["DASH-USER-TABLE"];
		$options = [
			"limit" => 10,
			"paginate" => true,
			"order" => Input::has("order")? Input::get("order"): "DESC",
		];
		
		 User::filters($options);

		 $data["query"] = new Query($options);
		 $data["posts"] = User::getUsers($data["query"]->options);

	?>
	{{GUI::dashboard(GUI::$templates["DASH-USER-LIST"], $data)}}
@stop