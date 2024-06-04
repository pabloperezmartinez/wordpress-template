<?php
	get_header();

	$args = array(
			'numberposts' => 4,
			'orderby' => 'date',
			'order' => 'DESC',
	);
	$ultimos = get_posts( $args );
?>
	<script type="text/javascript">

		$(function(){
			var images = $('.carousel'),
				imgIx = 0;

			(function nextImage(){
				$(images[imgIx++] || images[imgIx = 0, imgIx++]).fadeIn(1000).delay(4000).fadeOut(1000, nextImage);
			})();
		});

	</script>

	<div class="ui container">
		<div class="ui segment" style="min-height:500px">
			<h2 class="ui primary dividing header">Posts</h2>
			<div class="ui stackable four column grid">
				<?php foreach ($ultimos as $post):?>
					<div class="column">
						<?php if (get_post_thumbnail_id( $post->ID )!=NULL):?>
						<img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0];?>" class="ui fluid image">
						<?php endif; ?>
						<br><a href="<?php echo get_permalink($post->ID)?>" class="ui blue sub header"><?php echo $post->post_title;?></a>
						<p><?php echo $post->post_excerpt?></p>
					</div>
				<?php endforeach;?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>
