$(function(){

	// post-edit
    CKEDITOR.replace( 'description' );

    //map
    $("#states a").click(function(ev){
		ev.stopPropagation();

		var province = $(this).attr("id");
		var path = $(this).find("path")[0];

		if($(path).attr("class") == "active")
			removeProvince(province,path);
		else
			addProvince(province,path);
	})

	provinces = [];

	if($("#provinces").val()){
		var proActive = JSON.parse($("#provinces").val());
		var path;
		for (var index in proActive) {
			path = $("#states #" + proActive[index]).find("path")[0];
			addProvince(proActive[index],path)
		}
	}

	// sports

	 $("#sport-list li").click(function(ev){

		var sport = $(this).attr("id");

		if($(this).hasClass("active"))
			removeSport(sport,$(this));
		else
			addSport(sport,$(this));
	})

	sports = [];

	if($("#sports").val()){
		var spActive = JSON.parse($("#sports").val());
		var icon;
		for (var index in spActive) {
			icon = $("#sport-list #" + spActive[index]);
			addSport(spActive[index],icon)
		}
	}
})

// before submit 

function getValues(ev){
	$("#description").val(CKEDITOR.instances.description.getData());
	$("#provinces").val(JSON.stringify(provinces));
	if(sports.length > 0)
		$("#sports").val(JSON.stringify(sports));
}

// map

function showMapFilter(){
	$("#svgMap").fadeIn("normal");
}

function closeMapFilter(){
	$("#svgMap").fadeOut("normal");
}

// provinces

function addProvince(province,path){
	$(path).attr("class", "active");
	provinces.push(province);
}

function removeProvince(province,path){
	$(path).removeAttr("class");
	provinces.splice(provinces.indexOf(province),1);
}

// sports

function addSport(sport,icon){
	$(icon).addClass("active");
	sports.push(Number(sport));
}

function removeSport(sport,icon){
	$(icon).removeClass("active");
	sports.splice(sports.indexOf(Number(sport)),1);
}