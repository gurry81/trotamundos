<?php 
	echo Form::open(["url" => route("user-list"), "method" => "get", "id" => "filters"]) ?>
	<div class="column">
		<label><?php echo trans("messages.email") ?></label>
		<?php echo Form::text("email", (Input::has("email"))? Input::get("email") : "") ?>
	</div>
	<div class="column">
		<label><?php echo trans("messages.type") ?></label>
		<?php echo Form::select("type", ["all" => trans("messages.all"),"normal" => trans("messages.normal"),"author" => trans("messages.author"), "organization" => trans("messages.organization") , "admin" => trans("messages.admin")],(Input::has("type"))? Input::get("type") : "all" ) ?>		
	</div>

	<div class="column">
		<label><?php echo trans("messages.nick") ?></label>
		<?php echo Form::text("nick", (Input::has("nick"))? Input::get("nick") : "") ?>		
	</div>

	<?php echo Form::submit(trans("messages.search"),["class" => "btn"]); ?>
<?php echo Form::close(); ?>
<table id="list">
	<thead>
		<tr>
			<th><?php echo trans("messages.image") ?></th>
			<th><?php echo trans("messages.type") ?></th>
			<?php  
				$orderEmail = 'down';
				if((Input::has('orderby') && Input::get('orderby') == 'email') && Input::has('order') && Input::get('order') == 'DESC')
					$orderEmail = 'up';
				$orderNick = 'down';
				if((Input::has('orderby') && Input::get('orderby') == 'nick') && Input::has('order') && Input::get('order') == 'DESC')
					$orderNick = 'up';
				?>
			<th><?php echo trans("messages.email") ?><a href="?orderby=email&order=<?php echo ($orderEmail == 'down')? 'DESC':'ASC'; foreach (Input::except('orderby','order') as $param => $value) {
				echo '&' . $param . '=' . $value;
			} ?>" class="icon-<?php echo $orderEmail ?> option"></a></th>
			<th><?php echo trans("messages.nick") ?><a href="?orderby=nick&order=<?php echo ($orderNick == 'down')? 'DESC':'ASC'; foreach (Input::except('orderby','order') as $param => $value) {
				echo '&' . $param . '=' . $value;
			} ?>" class="icon-<?php echo $orderNick ?> option"></a></th>
			<th></th>
		</tr>
	</thead>

	<tbody>
		<?php 
			if($data["posts"])
				GUI::loop($data["query"],$data["posts"], $data["template"]); 
			else
				echo "<div id='no_posts'>" . trans("messages.no-users") . "</div>";	

		?>
	</tbody>
</table>

