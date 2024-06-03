<?php
/**
 * Single product template
 */
?>
    <script>
        function displayToast(url) {
            $('body')
                .toast({
                    title: 'Genial!!!',
                    message: 'Estamos a&ntilde;adiendo tu compra al carrito',
                    class: 'info',
                    className: {
                        toast: 'ui message'
                    },
                    onHide: window.location.href = url
                })
            ;
        }
    </script>
<?php while (have_posts()) :
    the_post();
    global $product;
    $meta_artist_name = get_post_meta(get_the_ID(), "artist_name", true);
    $meta_label_name = get_post_meta(get_the_ID(), "label_name", true);
    ?>
    <div>
        <h2 class="ui inverted dividing header">
            <div class="content">
                <?php if ($meta_artist_name != null) echo $meta_artist_name . " - " ?><?php the_title(); ?>
                <?php if ($meta_label_name != null): ?>
                    <div class="sub header">
                        <i class="record vinyl icon"></i><?php echo $meta_label_name ?>
                    </div>
                <?php endif; ?>
            </div>
        </h2>
        <div class="ui medium left floated image">
            <?php if (get_the_post_thumbnail_url() != null || get_the_post_thumbnail_url() != ''): ?>
                <img alt="<?php the_title() ?>" src="<?php echo get_the_post_thumbnail_url(); ?>"
                     class="ui fluid image">
            <?php else: ?>
                <img alt="<?php the_title() ?>"
                     src="<?php bloginfo('stylesheet_directory'); ?>/img/not-available-img.png"
                     class="ui fluid image">
            <?php endif; ?>
        </div>
        <?php if ($product->get_stock_quantity() > 0): ?>
            <div class="ui right floated labeled button" tabindex="0">
                <div class="ui primary button" onclick='displayToast("<?php echo the_permalink(); ?>?add-to-cart=<?php echo get_the_ID(); ?>")'>
                    <i class="cart icon"></i> <?php echo $product->get_price_html(); ?>
                </div>
                <div class="ui basic primary left pointing label" onclick='displayToast("<?php echo the_permalink(); ?>?add-to-cart=<?php echo get_the_ID(); ?>")'>
                    <?php echo $product->get_stock_quantity() ?> en stock
                </div>
            </div>
        <?php else: ?>
            <div class="ui right floated button large text">
                No disponible
            </div>
        <?php endif; ?>
        <!-- h3 class="ui blue header">Descripci&oacute;n</h3>
        <p>
            <span class="ui blue text"><strong>Ancho: </strong></span><?php echo $product->get_height() . get_option('woocommerce_dimension_unit'); ?>
            &nbsp;&nbsp;&nbsp;
            <span class="ui blue text"><strong>Alto: </strong></span><?php echo $product->get_length() . get_option('woocommerce_dimension_unit'); ?>
            &nbsp;&nbsp;&nbsp;
            <span class="ui blue text"><strong>Espesor: </strong></span><?php echo $product->get_width() . get_option('woocommerce_dimension_unit'); ?>
            &nbsp;&nbsp;&nbsp;
            <span class="ui blue text"><strong>Peso: </strong></span><?php echo $product->get_weight() . get_option('woocommerce_weight_unit'); ?>
        </p-->
        <?php the_excerpt(); ?>
        <?php the_content(); ?>
        <?php if ($product->get_stock_quantity() <= 0): ?>
            <div class="ui compact info message">
                <p>Este artículo no se encuentra disponible. Si deseas reservarlo, por favor comunícate con nosotros:</p>
                <p>
                    <a href="https://www.facebook.com/fotoyvinilos/" target="_blank"><i class="circular blue inverted facebook icon"></i></a>
                    <a href="https://www.instagram.com/lava.musica/" target="_blank"><i class="circular inverted pink instagram icon"></i></a>
                    <a href="https://wa.link/gm614a" target="_blank"><i class="circular inverted green whatsapp icon"></i></a>
                    <a href="<?php echo site_url();?>/rss" target="_blank"><i class="circular inverted red rss icon"></i></a>
                </p>
                <p>
                    <a href="tel:+593996393939"><i class="phone icon"></i> +593 99 639 3939</a><br>
					<a href="mailto:fotoyvinilosuio@gmail.com"><i class="mail icon"></i> fotoyvinilosuio@gmail.com</a>
                </p>
            </div>
        <?php endif; ?>
        <?php $posttags = wp_get_post_terms( get_the_id(), 'product_tag' );
        if ($posttags):?>
            <br/><br/>
            <?php if ($meta_artist_name != null): ?>
                <a class="ui blue label" href="<?php echo get_search_link($meta_artist_name) ?>">
                    <i class="large microphone alternate icon"></i>
                    <?php echo $meta_artist_name; ?>
                </a>
            <?php endif; ?>
            <br/><br/>
            <strong>Etiquetas: </strong>
            <?php foreach($posttags as $tag):?>
                <a class="ui primary tag label" href="<?php echo get_term_link( $tag->term_id , 'product_tag' )?>"><?php echo $tag->name?></a>&nbsp;
            <?php endforeach?>
        <?php endif;?>
    </div>
<?php endwhile; ?>