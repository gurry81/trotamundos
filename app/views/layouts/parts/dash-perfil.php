<?php  $user = Auth::user();?>

<?php echo Form::open(["url" => route("user-edit",$user->email),"method" => "post", "files" => true, "id" => "info"])?>
	<div class="row">
		<img id="image" src= <?php echo url('/media/images') . '/' . "$user->image"; ?>>
		<div id="options">
			<div class="option"><?php echo Form::submit(trans("messages.edit") ,["class" => "btn option"])?></div>
		</div>
	</div>
	<div class="row">
		<label><?php echo trans("messages.email") ?></label>
		<?php echo Form::text("email", (isset($data["credentials"]["email"]))? $data["credentials"]["email"] : $user->email, ["readonly" => ""])?>
	</div>
	<div class="row">
		<label><?php echo trans("messages.nick") ?></label>
		<?php echo Form::text("nick", (isset($data["credentials"]["nick"]))? $data["credentials"]["nick"] : $user->nick, ["readonly" => ""])?>
	</div>
	<div class="row">
		<label><?php echo trans("messages.type") ?></label>
		<?php echo Form::text("type", (isset($data["credentials"]["type"]))? $data["credentials"]["type"] : $user->type, ["readonly" => ""])?>
	</div>
<?php echo Form::close()?>