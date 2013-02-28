$(document).ready(function() {
  $('a[title*="parent"]', '#main_nav').parent().hover(function(){
  	$('.dropdown-toggle').dropdown()
  });
});

function imgError(image){
    $(image).hide();
}