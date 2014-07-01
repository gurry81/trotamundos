function processVote(){
	$.ajax({
		url : url,
		type : "POST",
		data : null,
		dataType : "json",
		success: function(data,status,xhr){
			$("#votes").text(data.votes);
			$("#voteButton").attr("class" , "btn " + data.class);
			url = data.url;
		},
	});

}