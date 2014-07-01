$(function(){
	loadSliders();

	window.addEventListener("resize", responsive, true);
})

function loadSliders(){
	var imgWidth = $($(".article-intro")[0]).outerWidth(true);

	slider["post"].slider = $("#post-slider .sliderImages");
	slider["post"].nextControl = $("#post-slider .next");
	slider["post"].previousControl = $("#post-slider .previous");
	slider["post"].imgWidth = imgWidth;
	slider["post"].start = false;
	addQueryPath(slider["post"]);
	slider["game"].slider = $("#game-slider .sliderImages");
	slider["game"].nextControl = $("#game-slider .next");
	slider["game"].previousControl = $("#game-slider .previous");
	slider["game"].imgWidth = imgWidth;
	slider["game"].start = false;
	addQueryPath(slider["game"]);

}

function addQueryPath(slider){
	var params = Param.all(true);
	for (var param in params) {
		slider.database.query[param] = params[param];
	};
}

function next(type){
	if(hasMore(type)){
		slider[type].slider.css("left","-=" + slider[type].imgWidth);
		slider[type].current = (slider[type].current + 1)%slider[type].max;
		// if ajax not in request
			slider[type].database.query.current++;
		slider[type].next = (slider[type].current < slider[type].total - 1)? true:false;
		slider[type].previous = true;
	}

	checkControls(type);

	if(slider[type].current > slider[type].total - 3 && (slider[type].database.query.next === null || slider[type].database.query.next)){
		slider[type].database.query.current = (slider[type].total);
		take(type,'next');
		// slider[type].database.query.current -= (slider[type].total-slider[type].current);
	}

	slider[type].start = true;
}

function previous(type){
	if(hasLess(type)){
		slider[type].slider.css("left","+=" + slider[type].imgWidth);
		slider[type].current = Math.abs((slider[type].current - 1)%slider[type].max);
		slider[type].database.query.current--;
		slider[type].next = true;
		slider[type].previous = (slider[type].current > 0)? true:false;
	}
	checkControls(type);
	if(slider[type].current < 2 && slider[type].database.query.previous){
		slider[type].database.query.current -= (4+slider[type].current);
		 
		if(slider[type].database.query.current < 0){
			slider[type].database.query.current += 3;
			slider[type].database.query.previous = false;
		}else{
			take(type,'previous');
			// slider[type].database.query.current += (3+slider[type].current);  // to finish ajax request
		}
	}
}

function hasMore(type){
	if(slider[type].next)
		return true;
	return false;
}

function hasLess(type){
	if(slider[type].previous || slider[type].database.query.previous)
		return true;
	return false;
}

function take(type,control){
	var params = slider[type].database.query ;

	$.ajax({
		url : slider[type].url,
		type : "GET",
		data : params,
		dataType : "json",
		error: function(xhr,status){
			slider[type].database.query[control] = false;
		},
		success: function(data,status,xhr){
			slider[type].database.query[control] = data.more;
			if(slider[type].max == slider[type].total){
				var articles = slider[type].slider.find("article-intro");

				for (var index = 0; index < data.found; index++) {
					articles[index].remove();
				};

			}else{
				slider[type].total += data.found;
			}
			
			slider[type].slider.append(data.posts);
		},
	});
}

function checkControls(type){
	if(slider[type].next)
		slider[type].nextControl.fadeIn("normal");
	else
		slider[type].nextControl.fadeOut("normal");

	if(slider[type].previous)
		slider[type].previousControl.fadeIn("normal");
	else
		slider[type].previousControl.fadeOut("normal");
}

function responsive(e){
	var dif = 200;

	if (document.body.clientWidth <  1250) {
		if(slider["post"].imgWidth > 700){
			if(slider["post"].start)
	    		slider["post"].slider.css("left","+=" +  slider["post"].current * dif);   
			slider["post"].imgWidth -= 200;
		}
    }else if (slider["post"].imgWidth < 900){
		if(slider["post"].start)
    		slider["post"].slider.css("left","-=" + slider["post"].current * dif);   
		slider["post"].imgWidth += 200;
    }

	if (document.body.clientWidth <  1250 ) {
		if(slider["game"].imgWidth > 700){
			if(slider["post"].start)
	    		slider["game"].slider.css("left","+=" +  slider["game"].current * dif);   
			slider["game"].imgWidth -= 200;
		}
    }else if (slider["game"].imgWidth < 900){
		if(slider["post"].start)	
    		slider["game"].slider.css("left","-=" + slider["game"].current * dif);   
		slider["game"].imgWidth += 200;
    }
	
}