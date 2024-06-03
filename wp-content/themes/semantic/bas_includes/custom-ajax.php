<?php

if (is_user_logged_in()) {
	
    add_action('wp_ajax_bas_user_edit', 'bas_user_edit_callback');
	
} else {
	
	add_action('wp_ajax_nopriv_bas_user_register', 'bas_user_register_callback');
	
}

// User Register
function bas_user_register_callback() {
	
	if (!isset($_POST['bas_nonce']) || !wp_verify_nonce( $_POST['bas_nonce'], 'bas_user_register') || !isset($_POST['_wp_http_referer'])
	|| !isset($_POST['site_zone']) || !isset($_POST['email']))
	{
		header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
		echo __('Sorry, required vars is not defined.', 'finesse');
		die();
	} else {
		
		// Captcha.
		if (is_captcha_form_enabled() && !is_captcha_code_valid()) {
			header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
			echo __('The reCAPTCHA code wasn\'t entered correctly.', 'finesse');
			die();
		}
		
		// Get data.
		$userdata = $usermeta = array();
		$auto_login = false;
		$user_notify = true;
		
		// Required data.
		$userdata['user_login'] = $_POST['email'];
		$userdata['user_email'] = $_POST['email'];
		$userdata['user_pass'] = wp_generate_password( 12, false );
		
		// Other data.
		$userdata['first_name'] = isset($_POST['first_name']) ? $_POST['first_name']:'';
		$userdata['last_name'] = isset($_POST['last_name']) ? $_POST['last_name']:'';
		
		// Meta data.
		$usermeta['bas_institution_title'] = isset($_POST['institution_title']) ? $_POST['institution_title']:'';
		$usermeta['bas_workplace'] = isset($_POST['workplace']) ? $_POST['workplace']:'';
		$usermeta['bas_address'] = isset($_POST['address']) ? $_POST['address']:'';
		$usermeta['bas_city'] = isset($_POST['city']) ? $_POST['city']:'';
		$usermeta['bas_postcode'] = isset($_POST['postcode']) ? $_POST['postcode']:'';
		$usermeta['bas_state'] = isset($_POST['state']) ? $_POST['state']:'';
		$usermeta['bas_country'] = isset($_POST['country']) ? $_POST['country']:'';
		$usermeta['bas_phone'] = isset($_POST['phone']) ? $_POST['phone']:'';
		$usermeta['bas_option_plan'] = isset($_POST['option_plan']) ? $_POST['option_plan']:'';
		$usermeta['bas_option_method_paid'] = isset($_POST['option_method_paid']) ? $_POST['option_method_paid']:'';
		$usermeta['bas_lines_research'] = isset($_POST['lines_research']) ? $_POST['lines_research']:'';
		$usermeta['bas_contributions'] = isset($_POST['contributions']) ? $_POST['contributions']:'';
		
		// Hide Meta data.
		$usermeta['bas_site_zone'] = isset($_POST['site_zone']) ? $_POST['site_zone']:'';
		$usermeta['bas_socio_status'] = 'status_2'; // Default -> socio pending
		$usermeta['bas_socio_status_paid'] = 'status_1'; // Default -> Not paid
		
		// Insert user.
		$user_id = wp_insert_user( $userdata );
		
		// Is there an error?
		if ( is_wp_error( $user_id ) ) {
   			header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
			echo $user_id->get_error_message();
			die();
		} else {
			
			// If no error, let's update the user meta too!
			if ( $usermeta )
				foreach ( $usermeta as $metakey => $metavalue ) {
					$metavalue = maybe_unserialize( $metavalue );
					update_user_meta( $user_id, $metakey, $metavalue );
				}
			
			// If we created a new user, maybe set password nag and send new user notification?
			//if ( $password_nag )
				//update_user_option( $user_id, 'default_password_nag', true, true );
			
			// Notification.
			if ( $user_notify )
				bas_new_user_notification( $user_id, $userdata['user_pass'] );
			
			// Is auto login.
			if($auto_login)
			{
				try {
					
					$login_data = array();
					$login_data['user_login'] = esc_sql($userdata['user_login']);
					$login_data['user_password'] = esc_sql($userdata['user_pass']);
					$login_data['remember'] = "true";
					$user_verify = wp_signon($login_data, true);
					
					if (is_wp_error($user_verify)) {
						header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
						echo __('Invalid username or password. Please try again!', 'finesse');
						die();
					} else {
						wp_set_current_user($user_verify->ID);
						wp_set_auth_cookie($user_verify->ID);
						die();
					}
				
				} catch (Exception $e) {
					die();
				}
			}
			
			die();
		}
	
	}
	
}

// User Edit
function bas_user_edit_callback() {
	
	if (!isset($_POST['bas_nonce']) || !wp_verify_nonce( $_POST['bas_nonce'], 'bas_user_edit') || !isset($_POST['_wp_http_referer'])
	|| !isset($_POST['email']))
	{
		header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
		echo __('Sorry, required vars is not defined.', 'finesse');
		die();
	} else {
		
		global $current_user;
		get_currentuserinfo();
		
		// Check User.
		$_role = Bas_WP_Util_Help::getUserRoleById($current_user->ID);
		$user_id = $current_user->ID;
		if (!isset($user_id) || !current_user_can( 'edit_user', $user_id ) || $user_id == 1 || $_role == 'administrator' || $_role == 'editor') {
			header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
			echo __('Not permission for this action.', 'finesse');
			die();
		}
		
		// Captcha.
		if (is_captcha_form_enabled() && !is_captcha_code_valid()) {
			header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
			echo __('The reCAPTCHA code wasn\'t entered correctly.', 'finesse');
			die();
		}
		
		// Get data.
		$userdata = $usermeta = array();
		$user_notify = true;
		
		// Required data.
		$userdata['ID'] = $user_id;
		$userdata['user_email'] = $_POST['email'];
		$is_change_pass = false;
		if(isset($_POST['password']) && $_POST['password'] != '')
		{
			$userdata['user_pass'] = $_POST['password'];
			$is_change_pass = true;
		}
		
		// Other data.
		$userdata['first_name'] = isset($_POST['first_name']) ? $_POST['first_name']:'';
		$userdata['last_name'] = isset($_POST['last_name']) ? $_POST['last_name']:'';
		
		// Meta data.
		$usermeta['bas_institution_title'] = isset($_POST['institution_title']) ? $_POST['institution_title']:'';
		$usermeta['bas_workplace'] = isset($_POST['workplace']) ? $_POST['workplace']:'';
		$usermeta['bas_address'] = isset($_POST['address']) ? $_POST['address']:'';
		$usermeta['bas_city'] = isset($_POST['city']) ? $_POST['city']:'';
		$usermeta['bas_postcode'] = isset($_POST['postcode']) ? $_POST['postcode']:'';
		$usermeta['bas_state'] = isset($_POST['state']) ? $_POST['state']:'';
		$usermeta['bas_country'] = isset($_POST['country']) ? $_POST['country']:'';
		$usermeta['bas_phone'] = isset($_POST['phone']) ? $_POST['phone']:'';
        $usermeta['bas_option_method_paid'] = isset($_POST['option_method_paid']) ? $_POST['option_method_paid']:'';
		$usermeta['bas_lines_research'] = isset($_POST['lines_research']) ? $_POST['lines_research']:'';
		$usermeta['bas_contributions'] = isset($_POST['contributions']) ? $_POST['contributions']:'';
		
		// Update user.
		$user_id = wp_update_user( $userdata );
		
		// Is there an error?
		if ( is_wp_error( $user_id ) ) {
   			header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
			echo $user_id->get_error_message();
			die();
		} else {
			
			// If no error, let's update the user meta too!
			if ( $usermeta )
				foreach ( $usermeta as $metakey => $metavalue ) {
					$metavalue = maybe_unserialize( $metavalue );
					update_user_meta( $user_id, $metakey, $metavalue );
				}
			
			// Notification.
			//if ( $user_notify )
				//bas_new_user_notification( $user_id, $userdata['user_pass'] );
			
			// Is change password.
			if ( $is_change_pass )	
				wp_logout();
			
			die();
		}
	
	}
	
}

// ----------------------------------------------------------------------
// CRON FUNCTIONS
// ----------------------------------------------------------------------

// Year period renovation
function bas_active_year_period_for_renovation() {
    global $wpdb;
    
    // Get all socios.
    $bas_zone_capabilities = array(
    serialize(array('subscriber'=>true)));
    
    $bas_args = array(
        'blog_id'      => $GLOBALS['blog_id'],
        //'role'         => '',
        //'meta_key'     => '',
        //'meta_value'   => '',
        //'meta_compare' => '',
        'meta_query'    => array(
                            
                            'relation' => 'AND',
                             
                            array(
                                'key' => 'bas_socio_status',
                                'value' => 'status_3',
                                'compare' => '='
                                ),
                            
                            array(
                                'key' => 'bas_socio_status_paid',
                                'value' => 'status_2',
                                'compare' => '='
                                ),
                               
                            array(
                                'key' => $wpdb->prefix . 'capabilities',
                                'value' => $bas_zone_capabilities,
                                'compare' => 'IN'
                                ),
                            
                        ),
        'include'      => array(),
        'exclude'      => array(),
        'orderby'      => 'display_name',
        'order'        => 'ASC',
        'offset'       => '',
        'search'       => '',
        'number'       => '',
        'count_total'  => false,
        'fields'       => 'all',
        'who'          => ''
    );
    $bas_users = get_users($bas_args);
    
    foreach ($bas_users as $user) {
        
        // Change to Not Paid    
        update_user_meta( $user->ID, 'bas_socio_status_paid', 'status_1' );
        
        // Send Renovation paid notification
        bas_user_notifications($user->ID, 'renovation');
    }
    
    // Send Admin notification
    bas_user_notifications(1, 'new_renovation_paid_period');
}
   
// ----------------------------------------------------------------------
// HELPS
// ----------------------------------------------------------------------

// User notification function
function bas_new_user_notification( $user_id, $plaintext_pass = '' ) {

	$user = new WP_User( $user_id );

	$user_login = stripslashes( $user->user_login );
	$user_email = stripslashes( $user->user_email );

	$message  = sprintf( __('New user registration on %s:', 'finesse'), get_option('blogname') ) . "\r\n\r\n";
	$message .= sprintf( __('Username: %s'), $user_login ) . "\r\n";
	$message .= sprintf( __('E-mail: %s'), $user_email ) . "\r\n\r\n";
    
    $message .= __('Credentials partners', 'finesse').':'. "\r\n\r\n";
    $message .= '(1º) '.__('Partner', 'finesse').': '.$_POST['socio_aval_1']. "\r\n";
    $message .= '(2º) '.__('Partner', 'finesse').': '.$_POST['socio_aval_2']. "\r\n\r\n";
    
    // Email to
    $to = get_option('admin_email');
    switch ($site_zone) {
        case "zone_2":
            $to = 'info.es@ulepicc.com';
            break;
        case "zone_3":
            $to = 'info.br@ulepicc.com';
            break;
        case "zone_4":
            $to = 'info.mz@ulepicc.com';
            break;
        case "zone_1":
        default:
            $to = 'info@ulepicc.com';
    }
    
	@wp_mail(
		$to,
		sprintf(__('[%s] New User Registration'), get_option('blogname') ),
		$message
	);

	if ( empty( $plaintext_pass ) )
		return;
	
	$login_url = isset($_POST['login_url']) ? $_POST['login_url']:wp_login_url('/account/');
	
	$message  = sprintf( __("Welcome to %s! Here's how to log in:", 'finesse'), get_option('blogname')) . "\r\n\r\n";
	
	$message .= __('The association ULEPICC soon will contact you via email and provide the necessary data to complete the registration process as a new partner.', 'finesse') . "\r\n\r\n";
    
    $message .=  __('Your login to the website of the association are:', 'finesse') . "\r\n\r\n";
    
	$message .= $login_url . "\r\n\r\n";
    
	$message .= sprintf( __('Username: %s'), $user_login ) . "\r\n";
	$message .= sprintf( __('Password: %s'), $plaintext_pass ) . "\r\n\r\n";
    
    // Firma.
    $message .=  sprintf( __('For any questions, you can contact the association in the mail %s', 'finesse'), get_option('admin_email') ) . "\r\n\r\n";
    $message .=  __('Kind regards,', 'finesse') . "\r\n\r\n";
    $message .=  'Unión Latina de Economía Política de la Información, la Comunicación y la Cultura (ULEPICC)' . "\r\n\r\n";

	wp_mail(
		$user_email,
		sprintf( __('[%s] Your username and password', 'finesse'), get_option('blogname') ),
		$message
	);
}

// User notifications
function bas_user_notifications($user_id, $type) {
      
    $user = new WP_User($user_id);
    
    $user_email = stripslashes( $user->user_email );
    
    $site_zone = get_user_meta($user_id, 'bas_site_zone', true);
    
    // $login_url.
    $login_url = 'http://';
    $from_email = get_option('admin_email');
    switch ($site_zone) {
        case "zone_2":
            $login_url .= 'es.';
            $language_user = 'es_ES';
            $from_email = 'info.es@ulepicc.com';
            break;
        case "zone_3":
            $login_url .= 'br.';
            $language_user = 'pt_PT';
            $from_email = 'info.br@ulepicc.com';
            break;
        case "zone_4":
            $login_url .= 'mz.';
            $language_user = 'pt_MZ';
            $from_email = 'info.mz@ulepicc.com';
            break;
        case "zone_1":
        default:
            $login_url .= '';
            $language_user = 'es_ES'; // es_UP
    }
    $login_url .= 'ulepicc.com/account/';
    
    //load the new text domain.
    load_textdomain('lang_user', get_template_directory().'/lang/'.$language_user.'.mo' );
    
    $from_name = get_option('blogname');
    
    
    // Send Approval notification
    if($type == 'approval'){
        //$headers = "Content-type: text/html; charset=UTF-8\r\n";
        $headers = "From: $from_name <$from_email>\r\n";
        $headers .= "Reply-To: $from_email\r\n";
        
        $message  = __('Dear or partner:', 'lang_user') . "\r\n\r\n";
        
        $message .= __("Your application for registration as a member of ULEPICC approved. To complete the process must make payment of their membership fees. Click the link below to access your private area where you will find the necessary instructions for payment.", 'lang_user') . "\r\n\r\n";
        
        $message .= $login_url . "\r\n\r\n";
        
        // Firma.
        $message .=  sprintf( __('For any questions, you can contact the association in the mail %s', 'lang_user'), $from_email ) . "\r\n\r\n";
        $message .=  __('Kind regards,', 'lang_user') . "\r\n\r\n";
        $message .=  'Unión Latina de Economía Política de la Información, la Comunicación y la Cultura (ULEPICC)' . "\r\n\r\n";
        
        wp_mail(
            $user_email,
            sprintf( __('[%s] Your registration request has been approved as a partner', 'lang_user'), $from_name ),
            $message,
            $headers
        );
    }
    
    // Send Renovation notification
    if($type == 'renovation'){
        //$headers = "Content-type: text/html; charset=UTF-8\r\n";
        $headers = "From: $from_name <$from_email>\r\n";
        $headers .= "Reply-To: $from_email\r\n";
        
        $message  = __('Dear or partner:', 'lang_user') . "\r\n\r\n";
        
        $message .= __("Paying your dues expired on December 31. Starting today begins a period of 30 days to pay the new annual fee. Find instructions to make payment by accessing your private area at the following link.", 'lang_user') . "\r\n\r\n";
        
        $message .= $login_url . "\r\n\r\n";
        
        $message .= __("Remember not to make the payment of your fee within 30 days enabled the ULEPICC association shall transact its status as a partner.", 'lang_user') . "\r\n\r\n";
        
        // Firma.
        $message .=  sprintf( __('For any questions, you can contact the association in the mail %s', 'lang_user'), $from_email ) . "\r\n\r\n";
        $message .=  __('Kind regards,', 'lang_user') . "\r\n\r\n";
        $message .=  'Unión Latina de Economía Política de la Información, la Comunicación y la Cultura (ULEPICC)' . "\r\n\r\n";
        
        wp_mail(
            $user_email,
            sprintf( __('[%s] Your membership fee is expired. Make payment of the new fee', 'lang_user'), $from_name ),
            $message,
            $headers
        );
    }
    
    // Send user paid notification
    if($type == 'user_paid'){
        //$headers = "Content-type: text/html; charset=UTF-8\r\n";
        $headers = "From: $from_name <$from_email>\r\n";
        $headers .= "Reply-To: $from_email\r\n";
        
        $message  = __('Dear or partner:', 'lang_user') . "\r\n\r\n";
        
        $message .= __("I congratulate your payment of the membership fee to been completed successfully!", 'lang_user') . "\r\n\r\n";
        
        $message .= $login_url . "\r\n\r\n";
        
        // Firma.
        $message .=  sprintf( __('For any questions, you can contact the association in the mail %s', 'lang_user'), $from_email ) . "\r\n\r\n";
        $message .=  __('Kind regards,', 'lang_user') . "\r\n\r\n";
        $message .=  'Unión Latina de Economía Política de la Información, la Comunicación y la Cultura (ULEPICC)' . "\r\n\r\n";
        
        wp_mail(
            $user_email,
            sprintf( __('[%s] Payment of the membership fee completed', 'lang_user'), $from_name ),
            $message,
            $headers
        );
    }
    
    // Send paid error notification
    if($type == 'user_paid_error'){
        //$headers = "Content-type: text/html; charset=UTF-8\r\n";
        $headers = "From: $from_name <$from_email>\r\n";
        $headers .= "Reply-To: $from_email\r\n";
        
        $message  = __("Error in Pay", 'lang_user') . "\r\n\r\n";
        //$message .= $login_url . "\r\n\r\n";
        //$message .= sprintf( __('If you have any problems, please contact me at %s.', 'lang_user'), $from_email ) . "\r\n\r\n";
        
        wp_mail(
            get_option('admin_email'),
            sprintf( __('[%s] Error in Pay', 'lang_user'), $from_name ),
            $message,
            $headers
        );
    }
    
    // New renovation paid period
    if($type == 'new_renovation_paid_period'){
        //$headers = "Content-type: text/html; charset=UTF-8\r\n";
        $headers = "From: $from_name <$from_email>\r\n";
        $headers .= "Reply-To: $from_email\r\n";
        
        $message  = __("New pay period for the membership fee, all active users have been advised by email and was not updated their status to paid.", 'lang_user') . "\r\n\r\n";
        //$message .= $login_url . "\r\n\r\n";
        //$message .= sprintf( __('If you have any problems, please contact me at %s.', 'lang_user'), $from_email ) . "\r\n\r\n";
        
        wp_mail(
            get_option('admin_email'),
            sprintf( __('[%s] New pay period for the membership fee', 'lang_user'), $from_name ),
            $message,
            $headers
        );
    }
}
