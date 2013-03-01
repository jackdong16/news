$(document).ready(function() {
  // $('a[title*="parent"]', '#main_nav').parent().hover(function(){
  // 	$('.dropdown-toggle').dropdown();
  // });
	$('.menu-item', '#main_nav').hover(function(){
		//debugger;
		$(this).dropdown();
		$('.sub-menu', this).show();
	});
});

function imgError(image){
    $(image).hide();
}