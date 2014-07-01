<?php 
	$user = $data["user"];
	if(isset($data["errors"]) && count($data["errors"]->getMessages()) > 0){

		echo '<ul class="error">';
		foreach ($data["errors"]->all('<li>:message</li>') as $error) {
			echo $error;
		}
		echo '</ul>';
	} 
 ?>

<?php echo Form::open(["method" => "post", "files" => true, "id" => "info"])?>
	<div class="row">
		<img id="image" src= <?php echo url('/media/images') . '/' . "$user->image"; ?>>
		<div id="options">
			<div class="option"><?php echo Form::submit(trans("messages.delete"),["class" => "btn option","formaction" =>action("UserController@delete",$user->email)])?></div>
			<div class="option"><?php echo Form::submit(trans("messages.update"),["class" => "btn option","formaction" =>action("UserController@update")])?></div>
			<div class="option"><a class="btn cancel" href=<?php echo (isset($_SERVER["HTTP_REFERER"]) && parse_url($_SERVER["HTTP_REFERER"],PHP_URL_HOST) == $_SERVER["SERVER_NAME"])?$_SERVER["HTTP_REFERER"]:route("dashboard") ?>><?php echo trans("messages.cancel") ?></a></div>				
			
		</div>
		<input type="file" name="image" onchange="previsualiza(this)" />
	</div>
	<div class="row">
		<?php echo Form::text("email", (isset($data["credentials"]["email"]))? $data["credentials"]["email"] : $user->email, ["placeholder" => trans("messages.email")])?>
		<?php echo Form::hidden("old-email", $user->email)?>
	</div>
	<div class="row">
		<?php echo Form::text("nick", (isset($data["credentials"]["nick"]))? $data["credentials"]["nick"] : $user->nick, ["placeholder" => trans("messages.nick")])?>
	</div>
	<div class="row">
		<?php echo Form::password("password",["placeholder" => trans("messages.password") ])?>		
	</div>
	<div class="row">
		<?php echo Form::password("password_confirmation",["placeholder" => trans("messages.r-password")])?>		
	</div>

	<?php if(Auth::user()->type == "admin" && Route::getCurrentRoute()->getName() != "dashboard"){ ?>
	<div class="row">

		<label><?php echo trans("messages.type") ?>: </label>
		<?php echo Form::select("type",["normal" => trans("messages.normal") ,"author" => trans("messages.author"),"organization" => trans("messages.organization") ,"admin" => trans("messages.admin")], (isset($data["credentials"]["type"]))? $data["credentials"]["type"] : $user->type)?>		
	</div>
	<?php } ?>
<?php echo Form::close()?>
