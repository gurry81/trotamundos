<div id="sport-filter">
	<div class="filter-title"><?php echo trans("messages.sports") ?></div>
	<div class="filter-options">
		<ul>
			<?php 
				$sports = DB::table("sport")->get();

				foreach ($sports as $sport) { 
			?>					
				<li class="sport-option <?php echo ((Input::has('sport') && Input::get('sport') == $sport->id) || (!Input::has('sport') && $sport->id == 5)? "sport-selected" : "") ?>"><a href=<?php echo "?sport=$sport->id&"; foreach(Input::except(["sport","page"]) as $param => $value){echo $param . "=" . $value . "&";} ?>><div class="sport-name"><span><?php echo "$sport->name" ?></span></div><div class="sport-icon"><div class="icon-<?php echo strtolower($sport->icon) ?>"></div></div><div class="sport-separator"></div><span class="clear"></span></a></li>	
			<?php 

				}
			 ?>
		</ul>
	</div>
</div>
