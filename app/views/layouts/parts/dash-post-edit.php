<?php 
	$post = $data["post"];
	$type = $post->type;

	if(isset($data['errors']) && count($data['errors']->getMessages()) > 0){
		echo '<ul class="error">';
		foreach ($data['errors']->all('<li>:message</li>') as $error) {
			echo $error;
		}
		echo '</ul>';
	} 
 ?>

<?php echo Form::open(["method" => "post","url" => action("PublicationController@update",$post->id), "onsubmit" => "getValues(event)","files" => true])?>
			<div class="row">
				<label><?php echo trans("messages.title") ?></label>
			</div>		
			<div class="row">
				<?php echo Form::text("title", (isset($data['credentials']['title']))?$data['credentials']['title']: $post->title) ?>
			</div>
			<div class="row">
				<label><?php echo trans("messages.image") ?></label>
			</div>	
			<div class="row">
				<img id="image" src=<?php echo url("/media/posts") . "/" . $post->$type->image ?>>
				<?php echo Form::file("image", ["accept" => "image/*","onchange" => "previsualiza(this)"]) ?>
			</div>
			<div class="row">
				<label><?php echo trans("messages.description") ?></label>
			</div>	
			<div class="row textarea">
				<?php echo Form::textarea("description", (isset($data['credentials']['description']))?$data['credentials']['description']: $post->$type->description, ["id" => "description", "placeholder" => trans("messages.editor")]) ?>
			</div>
			<div class="row">
				<label><?php echo trans("messages.excerpt") ?></label>				
			</div>
			<div class="row textarea">
				<?php echo Form::textarea("excerpt", (isset($data['credentials']['excerpt']))?$data['credentials']['excerpt']: $post->$type->excerpt,["rows" => "10", "placeholder" => trans("messages.area-excerpt") ]) ?>
			</div>
			
			<div id="right-sidebar">
				<label><?php echo trans("messages.sports") ?></label>
				<ul id="sport-list">
				<?php 
					$sports = Sport::all();

					foreach ($sports as $sport) {
						echo '<li class="icon-' .$sport->icon .'" id="' . $sport->id . '" ></li>';
					}
				 ?>
				</ul>

				<?php 
					$sports = [];
					foreach ($post->sports as $sport) {
						$sports[] = $sport->id;
					}

					echo Form::hidden("sports",(isset($data["credentials"]["sports"]))?$data["credentials"]["sports"]: json_encode($sports),["id" => "sports"]) ;
				?>

				<label><?php echo trans("messages.provinces") ?></label>
				<div class="icon-spain" onclick="showMapFilter()"></div>
				<?php 
					$provinces = [];
					foreach ($post->provinces as $province) {
						$provinces[] = $province->province;
					}
					
					echo Form::hidden("provinces",(isset($data["credentials"]["provinces"]))?$data["credentials"]["provinces"]:json_encode($provinces),["id" => "provinces"]) ;
				?>
				<?php if($type == Publication::$type["EVENT"]) {?>
					<label><?php echo trans("messages.date") ?></label>
					<input name="date" type="date" value=<?php echo (isset($data["credentials"]["date"]))?$data["credentials"]["date"]:$post->$type->date ?> placeholder="mm-dd-yyyy"/>
					<label><?php echo trans("messages.e-register") ?></label>
					<input name="end_register" type="date" value=<?php echo (isset($data["credentials"]["end_register"]))?$data["credentials"]["end_register"]:$post->$type->end_register ?> placeholder="mm-dd-yyyy"/>
					<label><?php echo trans("messages.price") ?></label>
					<input name="price" type="number" value=<?php echo (isset($data["credentials"]["price"]))?$data["credentials"]["price"]:$post->$type->price?> min="0" step="0.10" />
				<?php } ?>
				<label><?php echo trans("messages.lang") ?></label>
				<?php echo Form::select("lang",["es" => "Español", "en" => "English"],(isset($data["credentials"]["lang"]))?$data["credentials"]["lang"]: $post->lang) ?>
				<div id="options">
					<div class="option"><?php echo Form::submit(trans("messages.update") , ["class" => "btn option"]) ?></div>
					<div class="option"><a class="btn" href=<?php echo route("post-list") ?>><?php echo trans("messages.cancel") ?></a></div>				
				</div>

				<?php echo Form::hidden("type",$type) ?>
				<?php echo Form::hidden("author",$post->author) ?>
			</div>
<?php echo Form::close()?>