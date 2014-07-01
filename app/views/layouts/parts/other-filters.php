
<div id="other-filters">
	<div class="filter-title"><?php echo trans("messages.o-filters") ?></div>
	<div class="filter-options">

	  <div class="label"><label><?php echo trans("messages.province") ?></label></div>
	  <div id="map"><div class="icon-spain" onclick="showMapFilter()"></div></div>

	  <div>
	  	 <form action="" method="GET" onsubmit="mergeRequest(event)">
		  	<div class="label"><label><?php echo trans("messages.order-by"); ?></label></div>
		  	<select id="sortby" name="orderby">
		  		<option value="created_at" <?php echo (Input::get("orderby") == "created_at")? "selected":"" ?>><?php echo trans("messages.date") ?></option>
		  		<option value="votes" <?php echo (Input::get("orderby") == "votes")? "selected":"" ?>><?php echo trans("messages.votes") ?></option>
		  	</select>
		  	<input type="hidden" id="province" name="province"/>
		    <button class="btn" type="submit"><?php echo strtoupper( trans("messages.search")) ?></button>
		  </form>
	  </div>
	 
	</div>

	<?php require app_path() . "/views/layouts/parts/spainMap.php" ?>
</div>
