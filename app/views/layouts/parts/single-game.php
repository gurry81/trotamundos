<?php  $type = $post->type; ?>
<article class="single-event single">

	<div class="article-title"><?php echo $post->title; ?></div>
	<div class="article-meta">
		<?php  
			foreach ($post->sports as $sport) { ?>
				<span class="article-sport icon-<?php echo $sport->icon;?>"></span>
		<?php } ?>
		<span class="votes"><span class="icon-like"></span><span id="votes"><?php echo $post->votes; ?></span></span>
		<span class="author">by <a href=<?php echo route("author",$post->user->email) ;?>><?php echo $post->user->nick; ?></a></span>
		<span class="article-date"><?php echo trans("messages.post-at") ?> <?php echo Utils::parseDate($post->created_at); ?></span>
	</div>
	<div class="article-content">
	<!-- JOIN BUTTON -->
		<?php if(Auth::check()){ ?> 
			<?php
				$player = Player::where("user","=",Auth::user()->email)
						->where("game","=",$post->id)
						->get();
				if(!count($player)){
			 ?>
			<div class="btn" id="register-event">
				<a href=<?php echo route("game-info",$post->id) ?>><?php echo trans("messages.join") ?></a> 
			</div>
		<?php }else{ ?>
				<div class="btn join" id="register-event">
				<?php  echo trans("messages.joined");?>
				</div>
		<?php } ?>

	<?php } ?>
	<!--  -->
	<img class="article-img" src=<?php echo url("/media/posts") . '/' . $post->$type->image; ?>>
	<div id="description">
		<?php 
		// if($post->lang == App::getLocale())
			echo $post->$type->description;
		?>
	</div>
		<div class="clear"></div>
	</div>
	<?php 
	if(Auth::check()){
		$vote = Vote::where("publication","=",$post->id)->where("user","=",Auth::user()->email)->get();
		if(count($vote)){ ?>
			 <script type="text/javascript">
			 var url = "<?php echo route('delete-vote',$post->id) ?>"
			 </script>
			 <div class="btn voted" onclick="processVote()" id="voteButton"></div>
		<?php  } else { ?>
			<script type="text/javascript">
			 var url = "<?php echo route('vote',$post->id) ?>"
			</script>
			<div class="btn novoted" onclick="processVote()" id="voteButton" ></div>
		<?php }
	}
	?>
</article>