<?php get_header();?>
<?php if (have_posts()) : while (have_posts()) : the_post();?>
<div class="ui container">
 <div class="ui inverted segment" style="min-height: 40%; margin-top: 2vh">
  <h2 id="post-<?php the_ID(); ?>" class="ui primary dividing header"><?php the_title();?></h2>
  <div>
   <?php the_content('<p class="serif">Leer el resto de esta página &raquo;</p>'); ?>
  </div>
 </div>
</div>
 <?php endwhile; endif; ?>
<?php get_footer();?>
