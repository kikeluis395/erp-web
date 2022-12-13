var time = new Date().getTime();
$(document.body).on("click keypress", function(e) {
	time = new Date().getTime();
});

$(function(){
	function refresh() {
		if(new Date().getTime() - time >= 30000 && ($('.modal-open').length == 0) && ($(".table-cont-single").scrollTop() == 0)) 
			window.location.reload();
		else 
			setTimeout(refresh, 10000);
	}
	
	setTimeout(refresh, 10000);
});