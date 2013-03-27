<?php
/*
Template Name: Ajax Handler
*/
?>
<?php
	$post = get_post($_GET['id']);
?>
<?php if ($post) : ?>
	<?php setup_postdata($post); ?>
	<div class="modal-header">	
		<h2 class="entry-title"><?php the_title() ?></h2>
	</div>

	<div class="modal-body">
		<?php the_content(); ?>
	</div>
	
<!-- 	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
	    <a class="submit btn btn-primary">发布</a>
	    <script>
	    $('.submit', '#submitModal').click(function(){
			$('#usp_form').submit();
		});

	    </script>
	</div> -->
<?php endif; ?>