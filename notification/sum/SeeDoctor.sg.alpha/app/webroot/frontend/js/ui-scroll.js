$(document).ready(function(){
$( ".datepicker" ).datepicker();
$('.bxslider').bxSlider({
minSlides: 1,
maxSlides: 1,
});
$('.bxslider1').bxSlider({
minSlides: 1,
maxSlides: 1,
});

$('#tabs_nav li:first a').addClass('active');
$('.tab_content:first').show();
$('.find_doctor #tabs_nav li').click(function(event){
event.preventDefault();
$('#tabs_nav li a').removeClass('active');
$(this).find('a').addClass('active');
$('.tab_content').hide();
var selected_tab = $(this).find('a').attr('href');
$(selected_tab).fadeIn();
return false;
});
$(".custom-select").each(function(){
$(this).wrap( "<span class='select-wrapper'></span>" );
$(this).after("<span class='holder'></span>");
});
$(".custom-select").change(function(){
var selectedOption = $(this).find(":selected").text();
$(this).next(".holder").text(selectedOption);
}).trigger('change');
$(window).scroll(function(){
if($(this).scrollTop() > 10){
$(".scrolltop").fadeIn();	
}else{
$(".scrolltop").fadeOut();	
}
});$(".scrolltop").click(function(){
$("html, body").animate({scrollTop: 0},800);
return false;
});$("#log").on('click', function(){
$("body").addClass("login-back");
$(".login").slideDown();
});
$(".login_form_close").on('click', function(){
$("body").removeClass("login-back");
$(".login").slideUp();
});
$(".listbox").each('focus',function(){
	$("option:selected").addClass('selected');
})
});