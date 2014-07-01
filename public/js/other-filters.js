$(function(){
	// Province Events
	$("#add-province").click(addProvince)
	$("#province-box").focus(function(){clearInput(this)});

	// Spain Map svg Events
	$("#states a").click(function(ev){
		ev.stopPropagation();
		
		if(currentP && currentP != $(this).find("path")[0]){
			removeProvince(currentP);
		}

		var province = $(this).attr("id");
		currentP = $(this).find("path")[0];

		if($(currentP).attr("class") == "active")
			removeProvince(currentP);
		else
			addProvince(province,currentP);
	})

	if(Param.has("province")){
		currentP = $("#states #" + Param.only("province")).find("path")[0];
		addProvince(Param.get("province"),currentP);
	}else{
		currentP = null;
	}
})

function showMapFilter(){
	$("#svgMap").fadeIn("normal");
}

function closeMapFilter(){
	$("#svgMap").fadeOut("normal");
}

function addProvince(province,path){
	$(path).attr("class","active");
	$("#other-filters form #province").val(province);
}

function removeProvince(path){
	$(path).removeAttr("class");
	$("#other-filters form #province").val("");
}

function mergeRequest(ev){
	ev.preventDefault();
	var formParams = $(ev.target).serializeArray();
	formParams = Param.getStringOfSerialize(formParams);
	formParams += Param.except(["province","orderby","page"]);
	window.location.href = "?" + formParams;
}

