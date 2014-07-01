function dropdown(menu){

	$(menu).find(".submenu").slideToggle("normal");
}

// perfil & post-edit
function previsualiza(input) {
    var file = input.files[0];

    var reader = new FileReader();

    reader.onload = (function(theFile) {
        return function(e) {
            $("form #image").attr("src", e.target.result);
        };
    })(file);

    reader.readAsDataURL(file);
}