@extends("layouts.game-register")

@section("content")
	<?php echo Form::open(["method" => "post", "target" => "_top","files" => true, "id" => "info"])?>
	<div class="row">
		<img id="image" src= <?php echo url('/media/posts') . '/' . "$event->image"; ?>>
	</div>
	<div class="row">
		<label><?php echo trans("messages.price") ?></label>
		<?php echo Form::text("email", $event->price . " $", ["readonly" => ""])?>
	</div>
	<div class="row">
		<label><?php echo trans("messages.joiners") ?></label>
		<?php echo Form::text("nick", count($event->players), ["readonly" => ""])?>
	</div>
	<div class="row">
		<label><?php echo trans("messages.date") ?></label>
		<?php echo Form::text("type", Utils::parseDate($event->date), ["readonly" => ""])?>
	</div>
	<div class="row">
		<label><?php echo trans("messages.e-register") ?></label>
		<?php echo Form::text("type", Utils::parseDate($event->end_register), ["readonly" => ""])?>
	</div>
	<div class="row" id="paypal">
	<?php if ($event->finished()){
			echo '<span class="info">'. trans("messages.game-end") .'</span>';
		} 
		else if ($event->end_Register()){echo '<span class="info">'. trans("messages.game-end-r") .'</span>';} 
		else {?>
		<div id="options">
			<div class="option"><?php echo Form::submit(trans("messages.join") ,["formaction" => action("GameController@register",$event->id), "class" => "btn option"])?></div>
		</div>
		<?php } ?>
	</div>
<?php echo Form::close()?>



@stop

