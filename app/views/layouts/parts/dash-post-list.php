<?php 
	echo Form::open(["url" => route("post-list"), "method" => "get", "id" => "filters"]) ?>
	<?php if(Auth::user()->type == "admin") {?>
	<div class="column">
		<label><?php echo trans("messages.author") ?></label>
		<?php echo Form::text("author", (Input::has("author"))? Input::get("author") : "") ?>
	</div>
	<div class="column">
		<label><?php echo trans("messages.type") ?></label>
		<?php echo Form::select("type", ["post" => "Post","game" => "Game","all" => "All"],(Input::has("type"))? Input::get("type") : "all" ) ?>		
	</div>
<?php } ?>
	<div class="column">
		<label><?php echo trans("messages.title") ?></label>
		<?php echo Form::text("title", (Input::has("title"))? Input::get("title") : "") ?>		
	</div>

	<?php echo Form::submit(trans("messages.search"),["class" => "btn"]); ?>
<?php echo Form::close(); ?>
<table id="list">
	<thead>
		<tr>
			<th><?php echo trans("messages.title") ?></th>
			<th><?php echo trans("messages.type") ?></th>
			<th><?php echo trans("messages.lang") ?></th>
			<th><?php echo trans("messages.author") ?></th>
			<?php 
				$orderDate = 'down';
				if((Input::has('orderby') && Input::get('orderby') == 'updated_at') && Input::has('order') && Input::get('order') == 'DESC')
					$orderDate = 'up';
				$orderVotes = 'down';
				if((Input::has('orderby') && Input::get('orderby') == 'votes') && Input::has('order') && Input::get('order') == 'DESC')
					$orderVotes = 'up';

			 ?>
			<th><?php echo trans("messages.votes") ?><a href="?orderby=votes&order=<?php echo ($orderVotes == 'down')? 'DESC':'ASC';  foreach (Input::except('orderby','order') as $param => $value) {
				echo '&' . $param . '=' . $value;
			} ?>" class="icon-<?php echo $orderVotes ?> option"></a></th>
			<th><?php echo trans("messages.l-update") ?><a href="?orderby=updated_at&order=<?php echo ($orderDate == 'down')? 'DESC':'ASC'; foreach (Input::except('orderby','order') as $param => $value) {
				echo '&' . $param . '=' . $value;
			} ?>" class="icon-<?php echo $orderDate ?> option"></a></th>
			<th></th>
		</tr>
	</thead>

	<tbody>

		<?php 
			if($data["posts"])
				GUI::loop($data["query"],$data["posts"], $data["template"]); 
			else
				echo "<div id='no_posts'>" . trans("messages.no-posts") . "</div>";	

		?>
	</tbody>
</table>

