<?php  $type = $post->type; ?>
<article>
	<div class="article-title"><a href="<?php echo route("single" . $type,$post->id);?>"><?php echo $post->title; ?></a></div>
	<div class="article-meta">
	<?php  
		foreach ($post->sports as $sport) { ?>
			<span class="article-sport icon-<?php echo $sport->icon;?>"></span>
	<?php } ?>
		
		<span class="votes"><span class="icon-like"></span><?php echo $post->votes ?></span>
		<span class="author">by <a href=<?php echo route("author",$post->user->email) ;?>><?php echo $post->user->nick; ?></a></span>
	</div>
	<img class="article-img" src=<?php echo url("/media/posts") . '/' . $post->$type->image; ?>>
	<div class="article-excerpt">
		<?php echo $post->$type->excerpt; ?>
	</div>
	<div class="more"><a href=<?php echo route("single" . $type, $post->id); ?>><?php echo trans("messages.more") ?></a></div>
</article>