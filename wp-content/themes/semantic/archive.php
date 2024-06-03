<?php
get_header();

?>

<div class="ui container">
	<div class="ui segment" style="margin-top: 2vh">
		<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();?>
	 		<a href="<?php echo the_permalink()?>"><h1 class="ui dividing header"><?php the_title()?></h1></a><br>
	 		<div class="ui doubling grid">
	 			<div class="six wide column grid">
	 				<?php if (the_post_thumbnail_url!=null || the_post_thumbnail_url!=''):?>
	 					<a href="<?php echo the_permalink()?>">
	 						<img alt="<?php the_title()?>" src="<?php the_post_thumbnail_url();?>" class="ui fluid image">
	 					</a>
	 				<?php else:?>
	 					&nbsp;
	 				<?php endif;?>
	 			</div>
	 			<div class="ten wide column grid">
	 				<?php the_content("Leer más")?>
	 			</div>
	 		</div>
		<?php endwhile;?>
	</div>
</div>


<?php
get_footer();
?>
