
$(document).ready(function(){
	enquire.register("screen and (max-width: 1050px)", {
		match : function() {
			menu_mobile();
		},  
		unmatch : function() {
		}
	});
});