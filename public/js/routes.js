$(function(){
	$("#states a").click(function(){
		// $(this).find("title").text();
	})

	$("#button").click(function(){
		if(typeof currentRegion != "undefined")
			currentRegion.css("fill","#DDD");
		currentRegion = $("#" + $("#province").val()).find("path");
		currentRegion.css("fill","#E13314");	

	})
})