$(document).ready(function() {
   // $("#myCarousel").swiperight(function() {  
   //    $("#myCarousel").carousel('prev');  
   //  });  
   // $("#myCarousel").swipeleft(function() {  
   //    $("#myCarousel").carousel('next');  
   // });  
	jQuery('a.postpopup').click(function(){
		id = jQuery(this).attr('rel');
		jQuery('<div id="submitModal" class="modal hide fade"></div>').hide().appendTo('body').load('http://localhost:8888/news/?page_id='+id).modal();
		$('#submitModal').on('hidden', function () {
		  	$(this).remove();
		});

		$('#usp_form').ready(function() {
			//debugger;
		  	$('.submit', '#submitModal').click(function(){
				$('#usp_form').submit();
			});
		});

		
		return false;
	});
});