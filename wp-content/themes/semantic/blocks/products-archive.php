<?php
/**
* Template for products loop
*/

$terms    = get_terms([
    'taxonomy'    => $taxonomy,
    'hide_empty'  => true,
    'parent'      => get_queried_object_id()
]);
?>
<h1 class="ui primary dividing header"><?php echo single_cat_title(); ?></h1>

<?php /***** Products *******/ 
if (have_posts()) : ?>
    <a class="floating-right" href="https://wa.link/gm614a" target="_blank">
        <i class="big circular green inverted whatsapp icon"></i>
        <span class="ui left pointing green big basic label">¿Necesitas ayuda?</span>
    </a>
    <div class="ui stackable grid">
        <?php /***** subategories links *******/
        if (!empty($terms) && !is_front_page()): ?>
            <div class="three wide column">
                <div class="ui inverted accordion" id="cat_accordion">
                    <div class="title">
                        <i class="dropdown icon"></i>
                        Categorías
                    </div>
                    <div class="content">
                        <div class="ui inverted link list">
                            <?php foreach ( $terms as $term ): ?>
                                <a href="<?php echo get_term_link( $term, $taxonomy ); ?>" class="item"><?php echo $term->name ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; 
        /******** Products list block ********/ ?>
        <div class="<?php echo (!empty($terms) && !is_front_page()) ? "thirteen" : "" ;?> wide column">
            <ul class="ui three inverted stackable doubling centered link cards">
                <?php
                while (have_posts()) : the_post();
                    global $product;
                    $meta_artist_name = get_post_meta(get_the_ID(), "artist_name", true);
                    $meta_label_name = get_post_meta(get_the_ID(), "label_name", true);
                    ?>
                    <a href="<?php echo the_permalink() ?>" class="card">
                        <div class="image">
                            <?php if (get_the_post_thumbnail_url() != null || get_the_post_thumbnail_url() != ''): ?>
                                <img alt="<?php the_title() ?>" src="<?php echo get_the_post_thumbnail_url(); ?>"
                                    class="ui fluid image">
                            <?php else: ?>
                                <img alt="<?php the_title() ?>"
                                    src="<?php bloginfo('stylesheet_directory'); ?>/img/not-available-img.png"
                                    class="ui fluid image">
                            <?php endif; ?>
                        </div>
                        <div class="content">
                            <?php if (intval($product->get_stock_quantity()) > 0): ?>
                                <div class="ui red right floated tag label">
                                    <?php echo $product->get_price_html(); ?>
                                </div>
                            <?php else: ?>
                                <div class="ui right floated tag label">
                                    No disponible
                                </div>
                            <?php endif; ?>
                            <div class="header">
                                <?php the_title() ?>
                            </div>
                            <?php if ($meta_artist_name != null): ?>
                                <div class="description">
                                    <i class="microphone icon"></i>
                                    <?php echo $meta_artist_name ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <?php if ($meta_label_name != null): ?>
                            <div class="extra content">
                                <span class="right floated">
                                    <i class="record vinyl icon"></i>
                                    <?php echo $meta_label_name ?>
                                </span>
                            </div>
                        <?php endif ?>
                    </a>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>


    
    <?php 
    include ("pagination.php");
    else :
    wp_reset_postdata(); ?>
    <div class="ui container">
        <div class="ui placeholder inverted segment">
            <div class="ui icon header">
                <i class="blue frown icon"></i>
                No se encuentran productos
            </div>
            <div class="inline">
                <a class="ui primary button" href="<?php echo get_site_url() ?>">Regresar a inicio</a>
            </div>
        </div>
    </div>
<?php endif; ?>