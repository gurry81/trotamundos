<div class="article-intro">
	<div class="article-title"><a href="<?php echo route("single" . $type, $post->id); ?>" > <?php  echo $post->title; ?></a></div>
	<img class="article-img" src=<?php  echo url("/media/posts") . '/' . $post->$type->image; ?>>
	<div class="article-meta">
		<?php  
			foreach ($post->sports as $sport) { ?>
				<span class="article-sport icon-<?php echo $sport->icon ?>"></span>
		<?php } ?>
		<span class="votes"><?php echo $post->votes ?><span class="icon-like"></span></span>
		<span class="author"><?php echo trans("messages.by") ?> <a href=<?php echo route("author",$post->user->email);?>><?php echo $post->user->nick ?></a></span>
	</div>
</div>