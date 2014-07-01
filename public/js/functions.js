$(function(){
	$(window).scroll(toTop);

	// if($("body").outerHeight() < $("html").outerHeight()){
	// 	$("body").css("height","100%");
	// }
})

function toTop(){
	if ($(window).scrollTop() > 200)
		$("#toTop").fadeIn("slow");
	else
		$("#toTop").fadeOut("slow");

}

function goTop(){
	$("html,body").animate(
		{
			scrollTop: 0
		}, 800);
	
}

