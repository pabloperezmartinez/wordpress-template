<?php

/* Add shortcodes. */
add_action( 'init', 'bas_register_shortcodes' );

/**
 * Registers shortcodes.
 *
 */
function bas_register_shortcodes() {

	// Registers shortcodes.
	
	/* Add the [URI UPLOAD] shortcode. */
	add_shortcode( 'uri_upload', 'bas_upload_uri' );
	
	/* Add the [PROJECT BOX] shortcode. */
	add_shortcode( 'project_box', 'bas_project_box' );
	
	/* Add the [MORE INFO] shortcode. */
	add_shortcode( 'more_info', 'bas_more_info' );
	
	/* Add the [Menú Eficiencia] shortcode. */
	add_shortcode( 'menu_eficiencia', 'bas_menu_eficiencia' );
	
	// Add Filters.
	//add_filter('the_content', 'bas_add_info_content', 1);
}

/**
 * URI UPLOAD.
 */
function bas_upload_uri( $atts, $content) {
	
	$upload_dir = wp_upload_dir();	
    return $upload_dir['baseurl'];
}

/**
 * Menú Eficiencia.
 */
function bas_menu_eficiencia( $atts, $content) {
	
    extract(shortcode_atts(array(
		'title' => '',
    ), $atts));
	
	$content_temp .= '<a href="/eficiencia-energetica/proyectos-de-iluminacion-eficiente/" class="bot-menu-ef sprite-1"></a>';
	$content_temp .= '<a href="/eficiencia-energetica/kits-de-autoconsumo-para-hogares-y-empresa/" class="bot-menu-ef sprite-2 column-last"></a>';
	$content_temp .= '<a href="/eficiencia-energetica/gestion-energetica/" class="bot-menu-ef sprite-3"></a>';
	$content_temp .= '<a href="/eficiencia-energetica/planes-de-sostenibilidad/" class="bot-menu-ef sprite-4 column-last"></a>';
	$content_temp .= '<a href="/eficiencia-energetica/auditorias-energeticas/" class="bot-menu-ef sprite-5"></a>';
	$content_temp .= '<a href="/eficiencia-energetica/planes-director/" class="bot-menu-ef sprite-6 column-last"></a>';
	
    return $content_temp;
}

/**
 * PROJECT BOX.
 */
function bas_project_box( $atts, $content) {
	
    extract(shortcode_atts(array(
		'title' => 'Project Box Title',
    ), $atts));
	
	$content_temp .= '<h3 class="title-sec">'.$title.'</h3>';
	$content_temp .= do_shortcode($content);
	$content_temp .= '<div class="line-portfolio"></div>';
			
    return $content_temp;
}

/**
 * MORE INFO.
 */
function bas_more_info( $atts, $content) {
	
    extract(shortcode_atts(array(
		'url' => '/contacto/',
    ), $atts));
	
	$content_temp .= '<div class="clear"></div>';
	$content_temp .= '<ul class="sbutton social-links-footer suscrip in-page">';
	$content_temp .= '<li>';
	$content_temp .= '<a target="_parent" title="'.__('Request more information', 'finesse').'" href="'.$url.'">';
	$content_temp .= '<span style="opacity: 1;" class="button-up boletin_up sprite"></span>';
	$content_temp .= '<span class="shover boletin_over sprite" style="opacity: 0;"></span>';
	$content_temp .= '<span class="button-text">'.__('Request more information', 'finesse').'</span>';
	$content_temp .= '</a>';
	$content_temp .= '</li>';
	$content_temp .= '</ul>';
	$content_temp .= '<div class="clear"></div>';
			
    return $content_temp;
}

/**
 * Filter -> Content.
 */
/*function bas_add_info_content($content)
{	
   	global $wp_query;

	$template_name = get_post_meta( $wp_query->post->ID, '_wp_page_template', true );
	
	if($template_name != 'template-fullwidth.php' && $template_name != 'template-page.php' && !is_single($post))
		return $content;
	
	$content .= do_shortcode('[more_info]');
	
    return $content;
}*/