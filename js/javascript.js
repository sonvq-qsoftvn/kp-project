$(document).ready(function() {
	$('#hide_help').click(function(){
		$("#help_box").slideUp();
		$("#hide_help").hide();
		$("#show_help").show();
	});
	
	$('#show_help').click(function(){
		$("#help_box").slideDown();
		$("#show_help").hide();
		$("#hide_help").show();
	});
	
	
});	