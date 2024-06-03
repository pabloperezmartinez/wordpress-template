<?php

require_once ('Be/Api.php');

$Be_client_id = "coQg7Elc5PPFMKSfmMKou5ktexRi9vo2";
$Be_client_secret = "Ni0aaBWYk0uJhmE0OnO90d7gzL3l6q0Q";
$Be_user = "basgrani";
$Be_cron_recurrence = "30min"; // hourly, twicedaily, daily
$Be_log = "";
$Be_check_page = 1;

//----------------------------------------------------------
// Save options.
//----------------------------------------------------------
$Be_check_page = get_option('be_check_page');
if($Be_check_page == false)
{
	update_option('be_check_page', 1);
	$Be_check_page = get_option('be_check_page');
}

//----------------------------------------------------------
// CRON
//----------------------------------------------------------

// Add cron interval of 20 min
function addCronMinutes($array) {
    $array['15min'] = array(
            'interval' => 60*15,
            'display' => '15 Minutes',
    );
	$array['30min'] = array(
            'interval' => 60*30,
            'display' => '30 Minutes',
    );
    return $array;
}
add_filter('cron_schedules','addCronMinutes');

// Remove CRON
//wp_clear_scheduled_hook( 'be_scheduled_update' );

/**
 * Create CRON Update Event.
 *
 */
if ( function_exists('wp_next_scheduled') && function_exists('wp_schedule_event') ) {
	if ( !wp_next_scheduled('be_scheduled_update') )
		wp_schedule_event(time(), $Be_cron_recurrence, 'be_scheduled_update');
}

add_action( 'be_scheduled_update', 'be_do_scheduled_update' );
/**
 * Create Action to CRON Update Event.
 * 
 */
function be_do_scheduled_update() {
	global $Be_log, $Be_is_change;
	
	/*be_sync_projects_db();
	
	if($Be_is_change)
		Bas_WP_Util_Email::send_email_to_me('noreply@basgrani.com', 'Basgrani Site', 'CRON Activity Behance Projects', $Be_log);*/
}
//be_do_scheduled_update();

//----------------------------------------------------------
// API
//----------------------------------------------------------

/**
 * Init API Be
 *
 */
function be_init_api() {
	global $Be_api, $Be_client_id, $Be_client_secret;
	
	if(isset($Be_api))
		return;
	
	$Be_api = new Be_Api( $Be_client_id, $Be_client_secret );
}

/**
 * Get List Projects.
 *
 */
function be_list_projects_api() {
	global $Be_api, $Be_user, $Be_projects_per_page;
	
	be_init_api();
	
	// User's list of projects
	$Be_list_projects = $Be_api->getUserProjects( $Be_user );

	return $Be_list_projects;
}

/**
 * Get List id, name, modified_date and views Projects.
 *
 */
function be_list_projects_id_api() {
	global $Be_api, $Be_user, $Be_check_page;
	
	be_init_api();
	
	// User's list of projects
	$Be_list_projects = $Be_api->getUserProjects( $Be_user, array('page' => $Be_check_page) );
	
	// Update for check page later.
	if(count($Be_list_projects) == 0)
	{
		$Be_check_page = 1;
		$Be_list_projects = $Be_api->getUserProjects( $Be_user, array('page' => $Be_check_page) );
		update_option('be_check_page', 2);  // check later.
		
		be_log("<strong>Activity Report for Behance Projects (Page -> ".$Be_check_page."):</strong><br><br>");
	}
	else
	{
		be_log("<strong>Activity Report for Behance Projects (Page -> ".$Be_check_page."):</strong><br><br>");
		
		$Be_check_page++;
		update_option('be_check_page', $Be_check_page);
	}
	
	$project_id["id_project"] = array(); 
	$project_id["name"] = array();
	$project_id["modified_date"] = array();
	$project_id["views"] = array();
	foreach ($Be_list_projects as $project) {
		array_push($project_id["id_project"], $project->id);
		array_push($project_id["name"], $project->name);
		array_push($project_id["modified_date"], $project->modified_on);
		array_push($project_id["views"], $project->stats->views);
	}
	return $project_id;
}

/**
 * Test API Be
 *
 */
function be_test_api() {
	global $Be_api, $Be_user;
	
	be_init_api();
	
	// User's list of projects
	//$Be_list_projects = $Be_api->getUserProjects( $Be_user );
	//Bas_WP_Core::trace($Be_api->getUserProjects( $Be_user ));
	/*$be_mail_content .= "List of Be Projects:\n\n";
	foreach ($Be_list_projects as $be_projects){
		$be_mail_content .= $be_projects->name."\n";
	}*/
	//Bas_WP_Core::trace($be_mail_content);
	//Bas_WP_Core::trace(json_encode($Be_api->getProject( '11367411' )));
	
	//Bas_WP_Core::trace($Be_api->viewProject('11367411'));
	
	
	//wp_mail( 'jorge@basgrani.com', 'CRON Be Test', $be_mail_content );
	
	//$test_data = be_get_project_id_db("1");
	
	//Bas_WP_Core::trace($test_data);
	
	//Bas_WP_Core::trace($Be_api->appreciateProject( '11367411' ));
	
	//$Be_api->getUserProjects( 'basgrani' );
	//return $content;
}
//be_test_api();

//------------------------------------------------------------------
// HELPS
//------------------------------------------------------------------

/**
 * Be Log
 *
 */
function be_log($text) {
	global $Be_log;
	
	$Be_log .= $text.'<br>';
}

/**
 * Table Name.
 *
 */
function be_get_table_name()
{
	global $wpdb;
	return $table_name = $wpdb->base_prefix . "basgrani_be";
}

/**
 * Sync all Projects in Stored of DB
 *
 */
function be_sync_projects_db() {
	
	global $Be_is_change;
	
	$Be_list_projects_id = be_list_projects_id_api();
	$DB_list_projects_id = be_get_all_projects_id_db();
	
	$i=0;
	$Be_api_limit=0;
	foreach ($Be_list_projects_id["id_project"] as $Be_project_id) {
		// If exist project in DB...
		$key = array_search($Be_project_id, $DB_list_projects_id["id_project"]);
		if(is_numeric($key))
		{
			// If modified, update project...
			if(($Be_list_projects_id["modified_date"][$i] != $DB_list_projects_id["modified_date"][$key]) ||
			($Be_list_projects_id["views"][$i] != $DB_list_projects_id["views"][$key]))
			{
				if(be_update_project_db($Be_project_id))
					be_log('-'.$Be_list_projects_id["name"][$i]." -> <strong>Project Updated</strong>");
				else
					be_log('-'.$Be_list_projects_id["name"][$i]." -> <strong>Error: Updated</strong>");
					
				$Be_is_change = true;
			}
			else
				be_log('-'.$Be_list_projects_id["name"][$i]." -> In Sync");
		}
		else // Not exist, insert project...
		{
			if(be_add_project_db($Be_project_id))
				be_log('-'.$Be_list_projects_id["name"][$i]." -> <strong>New Project Added</strong>");
			else
				be_log('-'.$Be_list_projects_id["name"][$i]." -> <strong>Error: Added</strong>");
				
			$Be_is_change = true;
		}
		$i++;
	}
	
	// Footer.
	if($i==0)
		be_log("<br><strong>No data for Sync...</strong>");
	else
		be_log("<br><strong>(".$i.") Project/s in Sync.</strong>");
}

/**
 * Add Project in DB
 *
 */
function be_add_project_db($id_project) {
	global $wpdb, $Be_api;
	
	$Be_data = $Be_api->getProject( $id_project );
	$Be_json_data = json_encode($Be_data);
	
	if($Be_json_data == false)
		return false;
	
	$table_name = be_get_table_name();
	$rows_affected = $wpdb->insert($table_name, array(
		'id_project' => $Be_data->id,
		'name' => $Be_data->name,
		'modified_date' => $Be_data->modified_on,
		'json_data' => $Be_json_data));
	if ($rows_affected <= 0) {
		return false;
	}
	return true;
}

/**
 * Update Project in DB
 *
 */
function be_update_project_db($id_project) {
	global $wpdb, $Be_api;
	
	$Be_data = $Be_api->getProject( $id_project );
	$Be_json_data = json_encode($Be_data);
	
	if($Be_json_data == false)
		return false;
	
	$table_name = be_get_table_name();
	$rows_affected = $wpdb->update($table_name, array(
		'name' => $Be_data->name,
		'modified_date' => $Be_data->modified_on,
		'json_data' => $Be_json_data), 
		array('id_project' => $id_project)
		);
	if ($rows_affected <= 0) {
		return false;
	}
	return true;
}

/**
 * Get all id_project, name, modified_date and views Projects Stored of DB
 *
 */
function be_get_all_projects_id_db()
{
	global $wpdb;
	$table_name = be_get_table_name();
	$rows = $wpdb->get_results("SELECT id_project, name, modified_date, json_data FROM $table_name");
	$project_id["id_project"] = array();
	$project_id["name"] = array(); 
	$project_id["modified_date"] = array();
	$project_id["views"] = array(); 
	foreach ($rows as $row) {
		$json_data = json_decode($row->json_data);
		
		array_push($project_id["id_project"], $row->id_project);
		array_push($project_id["name"], $row->name);
		array_push($project_id["modified_date"], $row->modified_date);
		array_push($project_id["views"], $json_data->stats->views);
	}
	return $project_id;
}
		
/**
 * Get all Projects Stored of DB
 *
 */
function be_get_projects_db() 
{
	global $wpdb;
	$table_name = be_get_table_name();
    return $wpdb->get_results("SELECT * FROM $table_name");
}

/**
 * Get Project By id Stored of DB
 *
 */
function be_get_project_id_db($id, $assoc = false) 
{
	global $wpdb;
	
	if(!$id)
		return false;
	
	$table_name = be_get_table_name();
    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id = $id");
	
	return ( empty($result[0]->id) )
           ? false
           : json_decode($result[0]->json_data, $assoc);
}

/**
 * Get Project By POST id Stored of DB
 *
 */
function be_get_project_post_id_db($id, $assoc = false) 
{
	$be_project_id = get_post_meta($id, "finesse_be_project_id", true);
	return be_get_project_id_db($be_project_id, $assoc);
}

/**
 * Get current Project ID in POST
 *
 */
function be_current_project_id()
{
    global $post;
    if (isset($post)) {
        $project_id = get_post_meta(get_the_ID(), 'finesse_be_project_id', true);
        if (is_string($project_id)) {
            return $project_id;
        }
    }
    return 'default-project';
}