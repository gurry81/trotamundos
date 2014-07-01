$(function(){
	// footerPosition();
})

function footerPosition(){
	var footerHeight = $("footer").innerHeight();
	$("footer").css("bottom",footerHeight * -1 + "px")
}