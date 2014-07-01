<?php 

	if(isset($data['errors']) && count($data['errors']->getMessages()) > 0){
		echo '<ul class="error">';
		foreach ($data['errors']->all('<li>:message</li>') as $error) {
			echo $error;
		}
		echo '</ul>';
	} 
 ?>

<?php echo Form::open(["method" => "post","url" => action("UserController@create"), "files" => true])?>
	<div class="row">
		<img id="image" src= <?php echo url('/media/images') . '/' . "default.jpg"; ?>>
		<div id="options">
			<div class="option"><?php echo Form::submit(trans("messages.create"),["class" => "btn option"])?></div>
		</div>
		<input type="file" name="image" onchange="previsualiza(this)" />
	</div>
	<div class="row">
		<?php echo Form::text("email", (isset($data['credentials']["email"]))? $data['credentials']["email"] : "", ["placeholder" =>trans("messages.email")])?>
	</div>
	<div class="row">
		<?php echo Form::text("nick", (isset($data['credentials']["nick"]))? $data['credentials']["nick"] : "", ["placeholder" =>trans("messages.nick")])?>
	</div>
	<div class="row">
		<?php echo Form::password("password",["placeholder" => trans("messages.password")])?>		
	</div>
	<div class="row">
		<?php echo Form::password("password_confirmation",["placeholder" => trans("messages.r-password")])?>		
	</div>

	<?php if(Auth::user()->type == "admin" && Route::getCurrentRoute()->getName() != "dashboard"){ ?>
	<div class="row">

		<label><?php echo trans("messages.type")?>: </label>
		<?php echo Form::select("type",["all" => trans("messages.all"),"normal" => trans("messages.normal"),"author" => trans("messages.author"), "organization" => trans("messages.organization") , "admin" => trans("messages.admin")], (isset($data['credentials']["type"]))? $data['credentials']["type"] : "normal")?>		
	</div>
	<?php } ?>
<?php echo Form::close()?>