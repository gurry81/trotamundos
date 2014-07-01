@extends("layouts.dashboard")

@section("styles")
	@parent
	{{HTML::style("css/dash-list.css")}} 
@stop

@section("content")
	<?php  

		$data["template"] = GUI::$templates["DASH-PLAYER-TABLE"];
		$options = [
			"id" => $event,
			"limit" => 10,
			"paginate" => true,
			"order" => Input::has("order")? Input::get("order"): "DESC",
			
		];
		
		 Player::filters($options);

		 $data["query"] = new Query($options);
		 $data["posts"] = Player::getPlayers($data["query"]->options);

	?>
	{{GUI::dashboard(GUI::$templates["DASH-PLAYER-LIST"], $data)}}

@stop