<?php

define('UNLOGGED_DIR_AJAX', 'upges_admin');
define('LOGGED_DIR_AJAX', 'wp-admin');

/**
 * URL AJAX.
 */
function bas_ajax_url() {
	$url_ajax = "";
	if ( is_user_logged_in() ) 
		$url_ajax = LOGGED_DIR_AJAX.'/admin-ajax.php';
	else
		$url_ajax = UNLOGGED_DIR_AJAX.'/admin-ajax.php';
	
    return site_url($url_ajax);
}

/**
 * Get label zone.
 */
function bas_get_label_zone() {
	global $typenow;
	
	$post_id = get_the_ID();
	$_zoneLabel = '';
	$_cont = '';
	
	if($typenow == 'ai1ec_event')
	{
		if(has_term( 'ulepicc', 'events_categories' ))
		{
			$_zoneLabel = __('ulepicc fe', 'finesse');
			$_cont .= '<h4 class="zone-label ulepicc">';
		}
		if(has_term( 'ulepicc-brasil', 'events_categories' ))
		{
			$_zoneLabel = __('ulepicc br', 'finesse');
			$_cont .= '<h4 class="zone-label ulepicc-brasil">';
		}
		if(has_term( 'ulepicc-espana', 'events_categories' ))
		{
			$_zoneLabel = __('ulepicc es', 'finesse');
			$_cont .= '<h4 class="zone-label ulepicc-espana">';
		}
		if(has_term( 'ulepicc-mozambique', 'events_categories' ))
		{
			$_zoneLabel = __('ulepicc mz', 'finesse');
			$_cont .= '<h4 class="zone-label ulepicc-mozambique">';
		}
	}
	else
	{
		// WPML
		if (function_exists('icl_object_id'))
			$post_id = icl_object_id($post_id, 'post', false, ICL_LANGUAGE_CODE);
			
		$_source_language_code = bas_lang_info_post_id($post_id)->source_language_code;
		if($_source_language_code == NULL)
			$_source_language_code = bas_lang_info_post_id($post_id)->language_code;
		
		if($_source_language_code == 'es-up')
		{
			$_zoneLabel = __('ulepicc fe', 'finesse');
			$_cont .= '<h4 class="zone-label ulepicc">';
		}
		if($_source_language_code == 'pt-pt')
		{
			$_zoneLabel = __('ulepicc br', 'finesse');
			$_cont .= '<h4 class="zone-label ulepicc-brasil">';
		}
		if($_source_language_code == 'es')
		{
			$_zoneLabel = __('ulepicc es', 'finesse');
			$_cont .= '<h4 class="zone-label ulepicc-espana">';
		}
		if($_source_language_code == 'pt-mz')
		{
			$_zoneLabel = __('ulepicc mz', 'finesse');
			$_cont .= '<h4 class="zone-label ulepicc-mozambique">';
		}
	}
	
	$_cont .= $_zoneLabel.'</h4>';
	
    return $_cont;
}

/**
 * Get Lang Info Podt ID.
 */
function bas_lang_info_post_id($post_id){
    global $wpdb;
 
    $query = $wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'icl_translations WHERE element_id="%d"', $post_id);
    $query_exec = $wpdb->get_row($query);
 
    return $query_exec;
}
