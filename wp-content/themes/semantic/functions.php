<?php

/**
 * Registra menú
 */
function register_menu()
{
    register_nav_menu('main-nav', __('Top Main Navigation'));
}

add_action('init', 'register_menu');
add_theme_support('post-thumbnails');

/**
 * Inicializa acordiones si es que estos existen
 * @param  [type] $attr    [description]
 * @param  [type] $content [description]
 * @return [type]          [description]
 */
function accordion_shortcode($attr, $content = null)
{
    return '<div class="ui fluid styled accordion">' . do_shortcode($content) . '</div><script>$(".ui.accordion").accordion("open",1);</script>';
}

add_shortcode('accordion', 'accordion_shortcode');

function title_shortcode($attr, $content = null)
{
    return '<div class="title"><i class="dropdown icon"></i>' . $content . '</div>';
}

add_shortcode('title', 'title_shortcode');

function content_shortcode($attr, $content = null)
{
    return '<div class="content"><p>' . $content . '</p></div>';
}

add_shortcode('content', 'content_shortcode');

/**
 * Agrega de "artista" a Woocmmerce
 */
function prefix_add_artist_input()
{
    $args = [
        'label' => __('Artista', 'woocommerce'), // Text in the label in the editor.
        'placeholder' => __('Ingresa nombre de artista', 'woocommerce'), // Give examples or suggestions as placeholder
        'id' => 'artist_name', // required, will be used as meta_key
        'desc_tip' => true,
        'description' => __('Nombre de intérprete del álbum', 'woocommerce')
    ];
    woocommerce_wp_text_input($args);
}

add_action('woocommerce_product_options_sku', 'prefix_add_artist_input');

/**
 * Agrega de "selo discográfico" a Woocmmerce
 */
function prefix_add_record_label_input()
{
    $args = [
        'label' => __('Sello discográfico', 'woocommerce'), // Text in the label in the editor.
        'placeholder' => __('Ingresa nombre de sello discográfico', 'woocommerce'), // Give examples or suggestions as placeholder
        'id' => 'label_name', // required, will be used as meta_key
        'desc_tip' => true,
        'description' => __('Nombre de disquera.', 'woocommerce')
    ];
    woocommerce_wp_text_input($args);
}

add_action('woocommerce_product_options_sku', 'prefix_add_record_label_input');

/**
 * Guarda campo de artista
 * @param  [type] $post_id [description]
 * @return [type]          [description]
 */
function save_artist($post_id)
{
    // grab the custom SKU from $_POST
    $custom_artist = isset($_POST['artist_name']) ? sanitize_text_field($_POST['artist_name']) : '';

    // grab the product
    $product = wc_get_product($post_id);

    // save the custom SKU using WooCommerce built-in functions
    $product->update_meta_data('artist_name', $custom_artist);
    $product->save();
}

add_action('woocommerce_process_product_meta', 'save_artist');

/**
 * Guarda campo de sello discográfico
 * @param  [type] $post_id [description]
 * @return [type]          [description]
 */
function save_label_name($post_id)
{
    // grab the custom SKU from $_POST
    $custom_label_name = isset($_POST['label_name']) ? sanitize_text_field($_POST['label_name']) : '';

    // grab the product
    $product = wc_get_product($post_id);

    // save the custom SKU using WooCommerce built-in functions
    $product->update_meta_data('label_name', $custom_label_name);
    $product->save();
}

add_action('woocommerce_process_product_meta', 'save_label_name');

function semantic_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'semantic_add_woocommerce_support');

/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter('loop_shop_per_page', 'new_loop_shop_per_page', 9);

function new_loop_shop_per_page($cols)
{
    // $cols contains the current number of products per page based on the value stored on Options -> Reading
    // Return the number of products you wanna show per page.
    $cols = 18;
    return $cols;
}


/**
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */
function cf_search_join( $join ) {
    global $wpdb;

    if ( is_search() ) {    
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }

    return $join;
}
add_filter('posts_join', 'cf_search_join' );

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function cf_search_where( $where ) {
    global $pagenow, $wpdb;

    if ( is_search() ) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }

    return $where;
}
add_filter( 'posts_where', 'cf_search_where' );

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct( $where ) {
    global $wpdb;

    if ( is_search() ) {
        return "DISTINCT";
    }

    return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );

/**
 * Check if WooCommerce is activated
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}
}