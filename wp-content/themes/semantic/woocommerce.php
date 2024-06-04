<?php
/**
 * Woocommerce templates
 */
get_header();
?>
<div class="ui container">
    <div class="ui segment" style="margin-top: 2vh; min-height: 500px">
        <?php
        if (is_single()): include("blocks/product-single.php");
        elseif (is_archive()): include("blocks/products-archive.php");
        else: woocommerce_content();
        endif;
        ?>
    </div>
</div>
<?php get_footer(); ?>
