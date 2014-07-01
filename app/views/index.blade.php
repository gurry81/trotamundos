@extends("layouts.home")

@section("header")
	@parent
@stop

@section("content")
	<?php 
		$options = ["type" => Publication::$type["NEW"]];
		$options["limit"] = 3;

		Publication::filters($options);
		
		$query = new Query($options);
		$posts = Publication::getPublications($query->options);

		if($posts){
			echo GUI::slider($query,$posts);	
		}

	?>


	 <script type="text/javascript">
		slider = Array();
		slider["<?php echo $query->options['type'] ?>"] ={
			slider : null,
			max: 6,
			total: <?php echo count($posts) ?>,
			current: 0,
			next: true,
			previous: false,
			url: "<?php echo route($query->options['type'] . '-slider') ?>",
			database:{
				query :{
					limit: 3,
					type: "<?php echo $query->options['type'] ?>",
					current: 0,
					next: null,
					previous: false,
					found: 0,
					paginate: true,
				},
			},
		}
	 </script>

	<?php 
		$query->mergeOptions(["type" => Publication::$type["EVENT"]]); 
		$posts = Publication::getPublications($query->options);

		if($posts){
			echo GUI::slider($query,$posts);	
		}

	?>
	
	<script type="text/javascript">
		slider["<?php echo $query->options['type'] ?>"] ={
			slider : null,
			max: 6,
			total: <?php echo count($posts) ?>,
			current: 0,
			next: true,
			previous: false,
			url: "<?php echo route($query->options['type'] . '-slider') ?>",
			database:{
				query :{
					limit: 3,
					type: "<?php echo $query->options['type'] ?>",
					current: 0,
					next: null,
					previous: false,
					found: 0,
					paginate: true,
				},
			},
		}
	 </script>
@stop

@section("footer")
	@parent
@stop

