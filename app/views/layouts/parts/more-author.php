<?php 
	$posts = Publication::byAuthor($details['author'],$details['except']);

	if($posts){
?>

<div class="more-about">
	<div class="aside-title"><?php echo trans("messages.more-of"); ?> <?php echo User::find($details['author'])->nick; ?></div>
	<ul>
		<?php 
		
			foreach ($posts as $post) {
				$type = $post->type;
				echo "<li><a href=" .  route('single' . $type, $post->id) . ">$post->title</a></li>";
			} 

		?>
	</ul>
</div>
<?php } ?>

