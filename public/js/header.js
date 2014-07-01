$(function(){
	$("header #user-menu-button")
	.click(userMenuAnimate)
})

function userMenuAnimate(){
	var menu = $("header #user-menu");

	if(menu.css("display") == "none")
		menu.fadeIn("normal");
	else
		menu.fadeOut("normal");

}
