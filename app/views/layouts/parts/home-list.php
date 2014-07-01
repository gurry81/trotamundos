<?php 
	$type = $query->options["type"];
 ?>
<div class="content-separator"><span class="title-separator"><?php echo ( $type == Publication::$type["NEW"])? strtoupper(trans("messages.posts")) : strtoupper(trans("messages.games"));?></span></div>
<?php if(count($posts)){ ?>
<section class="slider" id=<?php echo $type . "-slider" ?>>
	<div class="sliderContent">
		<div class="sliderImages">
		<?php 
			foreach ($posts as $post) {
			 	require app_path() . "/views/layouts/parts/article-slider.php";
			}
		 ?>
		</div>
	</div>
<?php if(count($posts) > 1){ ?>
	<div class="controls">
		<div class="control previous icon-previous" onclick="previous('<?php echo $type ?>')"></div>
		<div class="control next icon-next" onclick="next('<?php echo $type ?>')"></div>
	</div>
<?php } ?>
</section>
<?php } ?>

