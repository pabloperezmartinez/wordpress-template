<?php

// Bas_WP Library.
require_once ('Bas_WP/Core.php');
require_once ('Bas_WP/Util/Email.php');
require_once ('Bas_WP/Util/Help.php');

// Init Bas_WP Library.
$Bas_WP_Core = new Bas_WP_Core();

// Includes.
include_once (BAS_FUNCTIONS_FILE_PATH . '/bas_includes/bas-util.php');

include_once (BAS_FUNCTIONS_FILE_PATH . '/bas_includes/custom-shortcodes.php');
include_once (BAS_FUNCTIONS_FILE_PATH . '/bas_includes/custom-meta-box.php');
include_once (BAS_FUNCTIONS_FILE_PATH . '/bas_includes/custom-ajax.php');
include_once (BAS_FUNCTIONS_FILE_PATH . '/bas_includes/custom-cron.php');

// ----------------------------------------------------------------------

// Set zone.
switch (get_locale()) {
	case "es_ES":
		define('BAS_APP_ZONE', 'zone_2');
		break;
	case "pt_PT":
		define('BAS_APP_ZONE', 'zone_3');
		break;
	case "pt_MZ":
		define('BAS_APP_ZONE', 'zone_4');
		break;
	case "es_UP":
	default:
		define('BAS_APP_ZONE', 'zone_1');
}

// Hook - Hide pages for no admin users
function bas_exclude_pages_from_admin($query) {
 
	if ( !is_admin() )
		return $query;
	
	global $pagenow, $post_type;
	
	if ( !current_user_can( 'administrator' ) && is_admin() && $pagenow == 'edit.php' && $post_type == 'page' )
		$query->query_vars['post__not_in'] = array( '449', '456','373', '85', '415', '377','539','524'
		,'531','416','392','450','525','540','374'
		,'418','427','446','532','541','376','537'
		,'417','428','451','533','542','375','538' ); // Enter your page IDs here
  
}
add_filter( 'parse_query', 'bas_exclude_pages_from_admin' );

// Style login
function bas_login_enqueue_scripts() { ?>
    <style type="text/css">
        .login form {
			overflow: hidden;
		}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'bas_login_enqueue_scripts' );

// Style Admin
function bas_admin_enqueue_scripts() { 
if(Bas_WP_Util_Help::getUserRoleById() != 'administrator'){
	?>
		<style type="text/css">
			#toplevel_page_ws-plugin--s2member-start, #menu-posts-portfolio,
			#createuser h3 img, #your-profile h3 img,
			#your-profile p + h3, #your-profile p + h3 + table{
				display:none;
				visibility:hidden;
			}
		</style>
	<?php 
}
}
add_action( 'admin_enqueue_scripts', 'bas_admin_enqueue_scripts' );

/** user_register - Hook */
add_action("user_register", "bas_user_register", 10, 1);
function bas_user_register($user_id) {
    
	// Set default admin bar in front to off.
	update_user_meta( $user_id, 'show_admin_bar_front', 'false' );
    //update_user_meta( $user_id, 'show_admin_bar_admin', 'false' );
	
	// Update zone in meta user.
	//$bas_zone_socio = get_user_field('zone_socio', $user_id);
	//update_user_meta($user_id, 'bas_zone_socio', $bas_zone_socio);	
}
/** profile_update - Hook */
add_action( 'profile_update', 'bas_profile_update', 10, 2 );
function bas_profile_update( $user_id, $old_user_data ) {
	if($user_id == 1)
		return;
	
	// Do something
	
	//get_post_meta($user_id, "s2member_dashboard_data_id_provider_ga", true);
	
	//Bas_WP_Core::trace('hola');
	
	//Bas_WP_Core::trace(get_user_field('zone_socio', $user_id));
	
	// Update zone in meta user.
	//$bas_zone_socio = get_user_field('zone_socio', $user_id);
	//update_user_meta($user_id, 'bas_zone_socio', $bas_zone_socio);
}

//Bas_WP_Core::trace(get_user_field('bas_zone_socio', 16));

//Hook rewrite login url.
/*add_filter('site_url', 'wplogin_filter', 10, 3);
function wplogin_filter( $url, $path, $orig_scheme )
{
	$old  = array( "/(wp-login\.php)/");
	$new  = array( "login");
	return preg_replace( $old, $new, $url, 1);
}*/

//Hook into the Breadcrumb NavXT title filter, want the 4.2+ version with 2 args
add_filter('bcn_breadcrumb_title', 'bcn_ext_title_translater', 10, 2);
/**
 * This function is a filter for the bcn_breadcrumb_title filter, it runs through
 * the SitePress::the_category_name_filter function
 * 
 * @param string $title The title to be filtered (translated)
 * @param array $context The breadcrumb type array
 * @return string The string filtered through SitePress::the_category_name_filter
 */
function bcn_ext_title_translater($title, $context)
{
	//Need to make sure we have a taxonomy and that the SitePress object is available
	if(is_array($context) && isset($context[0]) && taxonomy_exists($context[0]) && class_exists('SitePress'))
	{
		//This may be a little dangerous due to the internal recursive calls for the function
		$title = SitePress::the_category_name_filter($title);
	}
	return $title;
}

// ----------------------------------------------------------------------
// Payment Notification Handler
// ----------------------------------------------------------------------
add_action('init', 'bas_payment_notification', 1);
function bas_payment_notification()
{
    if(isset($_GET['s2member_paypal_notify']))
    {
        
        // Get data.
        $notify_post = array();
        $key_prefix = 'bas_paypal_notify_';
        foreach ($_POST as $key => $value) {
            $notify_post[$key_prefix.$key] = $value;
        }
        
        $user_id = $notify_post[$key_prefix.'option_selection1'];
        //$user_paid_price = !empty($notify_post[$key_prefix.'mc_gross']) ? $notify_post[$key_prefix.'mc_gross']:'';
        $user_paid_receiver_id = !empty($notify_post[$key_prefix.'receiver_id']) ? $notify_post[$key_prefix.'receiver_id']:'';
        $user_paid_is_completed = $notify_post[$key_prefix.'payment_status'] == 'Completed' ? true:false;
        //$user_paid_txn_id = !empty($notify_post[$key_prefix.'txn_id']) ? $notify_post[$key_prefix.'txn_id']:'';
        
        // IS VALID
        if(bas_paypal_notify_validate(PAYPAL_SANDBOX) && $user_paid_is_completed && !empty($user_id) && $user_paid_receiver_id == PAYPAL_RECEIVER_ID)
        {
            // Save data for paid...
            update_user_meta( $user_id, 'bas_paypal_payment', $notify_post ); // Save all data
            update_user_meta( $user_id, 'bas_socio_status_paid', 'status_2' ); // Paid
            
            // Notification paid
            bas_user_notifications($user_id, 'user_paid');
        }
        else // IS INVALID
        {
            /*if(!empty($user_id))
            {
                update_user_meta( $user_id, 'bas_socio_status_paid', 'status_3' ); // Paid Error
                
                // Notification paid error
                bas_user_notifications($user_id, 'renovation');
            }*/
            
            // Notification admin paid error
            //bas_user_notifications(1, 'user_paid_error');
        }
        exit;
    }
}

// Paypal notify validate.
function bas_paypal_notify_validate($sandbox=false)
{
    if($sandbox)  
        $_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    else 
        $_url = 'https://www.paypal.com/cgi-bin/webscr';
    
    // Step 1: GET POST DATA RECIEVED
    $raw_post_data = file_get_contents('php://input');
    $raw_post_array = explode('&', $raw_post_data);
    $myPost = array();
    foreach ($raw_post_array as $keyval) {
      $keyval = explode ('=', $keyval);
      if (count($keyval) == 2)
         $myPost[$keyval[0]] = urldecode($keyval[1]);
    }
    // read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
    $req = 'cmd=_notify-validate';
    if(function_exists('get_magic_quotes_gpc')) {
       $get_magic_quotes_exists = true;
    } 
    foreach ($myPost as $key => $value) {        
       if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
            $value = urlencode(stripslashes($value)); 
       } else {
            $value = urlencode($value);
       }
       $req .= "&$key=$value";
    } 
    
    // Step 2: POST IPN data back to PayPal to validate
    $ch = curl_init($_url);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
    
    // In wamp-like environments that do not come bundled with root authority certificates,
    // please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set 
    // the directory path of the certificate as shown below:
    // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
    if(!($res = curl_exec($ch))) {
        // error_log("Got " . curl_error($ch) . " when processing IPN data");
        curl_close($ch);
        //exit;
        return false;
    }
    curl_close($ch);
    
    if (strcmp ($res, "VERIFIED") == 0) 
    {
        return true; // The IPN is verified, process it
    } 
    else if (strcmp ($res, "INVALID") == 0) 
    {
        return false; // IPN invalid, log for manual investigation
    }   
}
