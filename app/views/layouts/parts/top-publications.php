<?php 
	$posts = Publication::byVotes($details["type"]);

	if($posts){
 ?>

<div class="top-ranking more-about">
	<div class="aside-title"><?php echo trans("messages.top") ?> <?php echo $details["type"];?></div>
	<ul>
		<?php foreach ($posts as $post) {

			echo "<li><span class='votes'>". $post->votes ."</span><a href=". route('single' . $details["type"], $post->id). ">" . $post->title. "</a></li>";
		} ?>
	</ul>
	
</div>

<?php } ?>