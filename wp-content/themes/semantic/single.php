<?php get_header(); ?>

<div class="ui container">
	<div class="ui segment" style="min-height: 700px; margin-top: 2vh;">
	<?php while ( have_posts() ) : the_post();?>
		<h2 class="ui header">
			<i class="big newspaper outline icon"></i>
		  <div class="content">
		    <?php the_title(); ?>
		  </div>
		</h2>
		<?php the_content(); ?>
	<?php endwhile;?>
	</div>
</div>
<?php get_footer(); ?>
