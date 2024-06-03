<?php

// Show fiels in user profile
add_action( 'show_user_profile', 'bas_add_custom_fields_user', 9 );
add_action( 'edit_user_profile', 'bas_add_custom_fields_user', 9 );

// Save fields data the user profile.
add_action( 'personal_options_update', 'bas_update_custom_fields_user' );
add_action( 'edit_user_profile_update', 'bas_update_custom_fields_user' );

function bas_add_custom_fields_user($user){ 
	?>
        <h3><?php _e('Personal information', 'finesse'); ?></h3>
        <table class="form-table">
        
        <tr>
        <td colspan="2">
        <div style="height:1px; line-height:1px; background:#CCCCCC;"></div>
        </td>
        </tr>
        
        <tr>
            <th><label for="institution_title"><?php _e('Institution and title', 'finesse'); ?></label></th>
            <td><input class="regular-text" type="text" id="institution_title" name="institution_title" value="<?php echo get_user_meta($user->ID, 'bas_institution_title', true); ?>" /></td>
        </tr>
        
        <tr>
            <th><label for="workplace"><?php _e('Workplace', 'finesse'); ?></label></th>
            <td><input class="regular-text" type="text" id="workplace" name="workplace" value="<?php echo get_user_meta($user->ID, 'bas_workplace', true); ?>" /></td>
        </tr>
        
        <tr>
            <th><label for="address"><?php _e('Address', 'finesse'); ?></label></th>
            <td><input class="regular-text" type="text" id="address" name="address" value="<?php echo get_user_meta($user->ID, 'bas_address', true); ?>" /></td>
        </tr>
        
        <tr>
            <th><label for="city"><?php _e('City', 'finesse'); ?></label></th>
            <td><input class="regular-text" type="text" id="city" name="city" value="<?php echo get_user_meta($user->ID, 'bas_city', true); ?>" /></td>
        </tr>
        
        <tr>
            <th><label for="postcode"><?php _e('Postcode', 'finesse'); ?></label></th>
            <td><input class="regular-text" type="number" id="postcode" name="postcode" value="<?php echo get_user_meta($user->ID, 'bas_postcode', true); ?>" /></td>
        </tr>
        
        <tr>
            <th><label for="state"><?php _e('State', 'finesse'); ?></label></th>
            <td><input class="regular-text" type="text" id="state" name="state" value="<?php echo get_user_meta($user->ID, 'bas_state', true); ?>" /></td>
        </tr>
        
        <tr>
            <th><label for="country"><?php _e('Country', 'finesse'); ?></label></th>
            <td><input class="regular-text" type="text" id="country" name="country" value="<?php echo get_user_meta($user->ID, 'bas_country', true); ?>" /></td>
        </tr>
        
        <tr>
            <th><label for="phone"><?php _e('Phone', 'finesse'); ?></label></th>
            <td><input class="regular-text" type="tel" id="phone" name="phone" value="<?php echo get_user_meta($user->ID, 'bas_phone', true); ?>" /></td>
        </tr>
        
        <tr>
            <th><label for="lines_research"><?php _e('Priority lines of research', 'finesse'); ?></label></th>
            <td><textarea id="lines_research" cols="68" rows="5" name="lines_research"><?php echo get_user_meta($user->ID, 'bas_lines_research', true); ?></textarea></td>
        </tr>
        
        <tr>
            <th><label for="contributions"><?php _e('Significant scientific contributions', 'finesse'); ?></label></th>
            <td><textarea id="contributions" cols="68" rows="5" name="contributions"><?php echo get_user_meta($user->ID, 'bas_contributions', true); ?></textarea></td>
        </tr>
        
        </table>
        
        <h3><?php _e('Account Settings', 'finesse'); ?></h3>
        <table class="form-table">
        
        <tr>
        <td colspan="2">
        <div style="height:1px; line-height:1px; background:#CCCCCC;"></div>
        </td>
        </tr>
        
        <tr>
            <th><label for="site_zone"><?php _e('Partner Zone', 'finesse'); ?>:</label></th>
			<?php 
            $bas_site_zone = get_user_meta($user->ID, 'bas_site_zone', true);
            $bas_site_zone = isset($bas_site_zone) ? $bas_site_zone:'zone_1'; // Default.
            ?>
            <td><select name="site_zone" id="site_zone">
            <option value="zone_1" <?php echo ($bas_site_zone == 'zone_1' ? 'selected="selected"':''); ?>><?php echo bas_get_site_zone_str('zone_1'); ?></option>
            <option value="zone_2" <?php echo ($bas_site_zone == 'zone_2' ? 'selected="selected"':''); ?>><?php echo bas_get_site_zone_str('zone_2'); ?></option>
            <option value="zone_3" <?php echo ($bas_site_zone == 'zone_3' ? 'selected="selected"':''); ?>><?php echo bas_get_site_zone_str('zone_3'); ?></option>
            <option value="zone_4" <?php echo ($bas_site_zone == 'zone_4' ? 'selected="selected"':''); ?>><?php echo bas_get_site_zone_str('zone_4'); ?></option>
            </select></td>
        </tr>
        
        <tr>
            <th><label for="option_plan"><?php _e('I wish to become a member as', 'finesse'); ?>:</label></th>
			<?php 
            $bas_option_plan = get_user_meta($user->ID, 'bas_option_plan', true);
            $bas_option_plan = isset($bas_option_plan) ? $bas_option_plan:'plan_1'; // Default.
            ?>
            <td><select name="option_plan" id="option_plan">
            <option value="plan_1" <?php echo ($bas_option_plan == 'plan_1' ? 'selected="selected"':''); ?>><?php echo bas_get_plan_str('plan_1', $bas_site_zone); ?></option>
            <option value="plan_2" <?php echo ($bas_option_plan == 'plan_2' ? 'selected="selected"':''); ?>><?php echo bas_get_plan_str('plan_2', $bas_site_zone); ?></option>
            <option value="plan_3" <?php echo ($bas_option_plan == 'plan_3' ? 'selected="selected"':''); ?>><?php echo bas_get_plan_str('plan_3', $bas_site_zone); ?></option>
            <option value="plan_4" <?php echo ($bas_option_plan == 'plan_4' ? 'selected="selected"':''); ?>><?php echo bas_get_plan_str('plan_4', $bas_site_zone); ?></option>
            </select></td>
        </tr>
        
        <tr>
            <th><label for="option_method_paid"><?php _e('Payment method', 'finesse'); ?>:</label></th>
			<?php 
            $bas_option_method_paid = get_user_meta($user->ID, 'bas_option_method_paid', true);
            $bas_option_method_paid = isset($bas_option_method_paid) ? $bas_option_method_paid:'method_2'; // Default.
            ?>
            <td><select name="option_method_paid" id="option_method_paid">
            <option value="method_1" <?php echo ($bas_option_method_paid == 'method_1' ? 'selected="selected"':''); ?>><?php echo bas_get_method_paid_str('method_1'); ?></option>
            <option value="method_2" <?php echo ($bas_option_method_paid == 'method_2' ? 'selected="selected"':''); ?>><?php echo bas_get_method_paid_str('method_2'); ?></option>
            </select></td>
        </tr>
        
        <tr>
            <th><label for="socio_status"><?php _e('Socio status', 'finesse'); ?>:</label></th>
			<?php 
            $bas_socio_status = get_user_meta($user->ID, 'bas_socio_status', true);
            $bas_socio_status = isset($bas_socio_status) ? $bas_socio_status:'status_1'; // Default.
            ?>
            <td><select name="socio_status" id="socio_status">
            <option value="status_1" <?php echo ($bas_socio_status == 'status_1' ? 'selected="selected"':''); ?>><?php echo bas_get_socio_status_str('status_1'); ?></option>
            <option value="status_2" <?php echo ($bas_socio_status == 'status_2' ? 'selected="selected"':''); ?>><?php echo bas_get_socio_status_str('status_2'); ?></option>
            <option value="status_3" <?php echo ($bas_socio_status == 'status_3' ? 'selected="selected"':''); ?>><?php echo bas_get_socio_status_str('status_3'); ?></option>
            </select>
            <span class="description">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <label><input type="checkbox" name="approval_email_message_send" id="approval_email_message_send" value="1">
                 <?php _e('Send approval email message to this User', 'finesse'); ?></label>
            </span>
            </td>
        </tr>
        
        <tr>
            <th><label for="socio_status_paid"><?php _e('Socio status paid', 'finesse'); ?>:</label></th>
            <?php 
            $bas_socio_status_paid = get_user_meta($user->ID, 'bas_socio_status_paid', true);
            $bas_socio_status_paid = isset($bas_socio_status_paid) ? $bas_socio_status_paid:'status_1'; // Default.
            ?>
            <td><select name="socio_status_paid" id="socio_status_paid">
            <option value="status_1" <?php echo ($bas_socio_status_paid == 'status_1' ? 'selected="selected"':''); ?>><?php echo bas_get_socio_status_paid_str('status_1'); ?></option>
            <option value="status_2" <?php echo ($bas_socio_status_paid == 'status_2' ? 'selected="selected"':''); ?>><?php echo bas_get_socio_status_paid_str('status_2'); ?></option>
            <!--option value="status_3" <?php //echo ($bas_socio_status_paid == 'status_3' ? 'selected="selected"':''); ?>><?php //echo bas_get_socio_status_paid_str('status_3'); ?></option-->
            </select>
            <span class="description">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <label><input type="checkbox" name="paid_email_message_send" id="paid_email_message_send" value="1">
                 <?php _e('Send paid completed email message to this User', 'finesse'); ?></label>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <label><input type="checkbox" name="renovation_email_message_send" id="renovation_email_message_send" value="1">
                 <?php _e('Send renovation email message to this User', 'finesse'); ?></label>
            </span>
            </td>
        </tr>
        
        </table>
	<?php            
}

function bas_update_custom_fields_user($user_id) {
	$usermeta = array();
	
	// Permisions.
	if ( !current_user_can( 'edit_user', $user_id ) || !is_admin() || !isset($_POST['site_zone']))
		return false;
	
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
	$usermeta['bas_site_zone'] = isset($_POST['site_zone']) ? $_POST['site_zone']:'zone_1';
	$usermeta['bas_socio_status'] = isset($_POST['socio_status']) ? $_POST['socio_status']:'status_1';
	$usermeta['bas_socio_status_paid'] = isset($_POST['socio_status_paid']) ? $_POST['socio_status_paid']:'status_1';
    
	if ( $usermeta )
		foreach ( $usermeta as $metakey => $metavalue ) {
			$metavalue = maybe_unserialize( $metavalue );
			update_user_meta( $user_id, $metakey, $metavalue );
		}
    
    // Approval notification
    if(isset($_POST['approval_email_message_send']) && $_POST['approval_email_message_send'] == 1)
       bas_user_notifications($user_id, 'approval');
    
    // Paid notification
    if(isset($_POST['paid_email_message_send']) && $_POST['paid_email_message_send'] == 1)
       bas_user_notifications($user_id, 'user_paid');
    
    // Renovation notification
    if(isset($_POST['renovation_email_message_send']) && $_POST['renovation_email_message_send'] == 1)
       bas_user_notifications($user_id, 'renovation');
}

// Add Custom columns users list.
add_filter('manage_users_columns', 'bas_users_columns', 9, 1);
function bas_users_columns($columns) {
    $columns['bas_site_zone'] = __('Partner Zone', 'finesse');
    $columns['bas_option_plan'] = __('Type Plan', 'finesse');
	$columns['bas_socio_status'] = __('Socio status', 'finesse');
    $columns['bas_socio_status_paid'] = __('Socio status paid', 'finesse');
    return $columns;
}

// Show data in columns.
add_action('manage_users_custom_column', 'bas_show_users_columns', 9, 3);
function bas_show_users_columns($value, $column_name, $id) {  
    switch ($column_name) {
        case 'bas_site_zone':
          return bas_get_site_zone_str(get_user_meta($id, $column_name, true));
		   break;
         case 'bas_option_plan':
          return bas_get_plan_str(get_user_meta($id, $column_name, true), get_user_meta($id, 'bas_site_zone', true));
           break;
		 case 'bas_socio_status':
          return bas_get_socio_status_str(get_user_meta($id, $column_name, true));
		   break;
         case 'bas_socio_status_paid':
          return bas_get_socio_status_paid_str(get_user_meta($id, $column_name, true));
           break;
    }
	return $value;
}

// Add Sortable columns.
/*add_filter('manage_users_sortable_columns', 'bas_users_sortable_columns', 9, 1);
function bas_users_sortable_columns($columns) {
    $columns['bas_site_zone'] = 'bas_site_zone';
    return $columns;
}*/

// Order Columns.
/*add_filter('request', 'bas_status_column_orderby');
function bas_status_column_orderby($vars) {
    if ( isset( $vars['orderby'] ) && 'bas_site_zone' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'bas_site_zone',
            'orderby' => 'meta_value',
        ) );
    }
    return $vars;
}*/

// Help -> Get site zones.
function bas_get_site_zones()
{
    $_array = array(
        'zone_1'=>'ULEPICC FEDERAL',
        'zone_2'=>'ULEPICC ESPAÑA',
        'zone_3'=>'ULEPICC BRASIL',
        'zone_4'=>'ULEPICC MOZAMBIQUE',
    );
	
	return $_array;
}
function bas_get_site_zone_str($key) {
	$_array = bas_get_site_zones();
	$value = $_array[$key];
	if(is_array($value))
		$value = $value[0];
	return $value;
}

// Help -> Get method paids.
function bas_get_method_paids()
{
    $_array = array(
        'method_1'=> __('Paypal', 'finesse'),
        'method_2'=> __('Bank Transfer', 'finesse'),
    );
	
	return $_array;
}
function bas_get_method_paid_str($key) {
	$_array = bas_get_method_paids();
	$value = $_array[$key];
	if(is_array($value))
		$value = $value[0];
	return $value;
}

// Help -> Get plans.
function bas_get_plans($zone)
{
    switch ($zone) {
    case "zone_2":
        $_array = array(
            'plan_1'=> 'Socio individual (30€)',
            'plan_2'=> 'Estudiantes (10€)',
            'plan_3'=> 'Investigadores en situación de desempleo (5€)',
            'plan_4'=> 'Socio institucional (100€)',
        );
        break;
    case "zone_3":
        $_array = array(
            'plan_1'=> 'Associados efetivos (R$150,00)',
            'plan_2'=> 'Associados estudantes de graduação (R$75,00)',
            'plan_3'=> 'Associados institucionais (R$ 1500,00)',
            'plan_4'=> 'Associados beneméritos (R$7500,00)',
        );
        break;
        break;
    case "zone_4":
        $_array = array(
            'plan_1'=> 'Associados efetivos (R$150,00)',
            'plan_2'=> 'Associados estudantes de graduação (R$75,00)',
            'plan_3'=> 'Associados institucionais (R$ 1500,00)',
            'plan_4'=> 'Associados beneméritos (R$7500,00)',
        );
        break;
        break;
    case "zone_1":
    default:
        $_array = array(
            'plan_1'=> 'Socio individual (30€)',
            'plan_2'=> 'Estudiantes (10€)',
            'plan_3'=> 'Investigadores en situación de desempleo (5€)',
            'plan_4'=> 'Socio institucional (100€)',
        );
        break;
    }
    
	return $_array;
}
function bas_get_plan_str($key, $zone) {
	$_array = bas_get_plans($zone);
	$value = $_array[$key];
	if(is_array($value))
		$value = $value[0];
	return $value;
}

// Help -> Get socio status.
function bas_get_socio_status()
{
    $_array = array(
		'status_1'=> __('Desactivate', 'finesse'),
		'status_2'=> __('Pending', 'finesse'),
		'status_3'=> __('Activate', 'finesse'),
    );
	
	return $_array;
}
function bas_get_socio_status_str($key) {
	$_array = bas_get_socio_status();
	$value = $_array[$key];
	if(is_array($value))
		$value = $value[0];
	return $value;
}

// Help -> Get socio status paid.
function bas_get_socio_status_paid()
{
    $_array = array(
        'status_1'=> __('Not paid', 'finesse'),
        'status_2'=> __('Paid', 'finesse'),
        'status_3'=> __('Paid Error', 'finesse'),
    );
    
    return $_array;
}
function bas_get_socio_status_paid_str($key) {
    $_array = bas_get_socio_status_paid();
    $value = $_array[$key];
    if(is_array($value))
        $value = $value[0];
    return $value;
}

function get_countries()
{
    $country_array = array(
        'AF'=>'AFGHANISTAN',
        'AL'=>'ALBANIA',
        'DZ'=>'ALGERIA',
        'AS'=>'AMERICAN SAMOA',
        'AD'=>'ANDORRA',
        'AO'=>'ANGOLA',
        'AI'=>'ANGUILLA',
        'AQ'=>'ANTARCTICA',
        'AG'=>'ANTIGUA AND BARBUDA',
        'AR'=>'ARGENTINA',
        'AM'=>'ARMENIA',
        'AW'=>'ARUBA',
        'AU'=>'AUSTRALIA',
        'AT'=>'AUSTRIA',
        'AZ'=>'AZERBAIJAN',
        'BS'=>'BAHAMAS',
        'BH'=>'BAHRAIN',
        'BD'=>'BANGLADESH',
        'BB'=>'BARBADOS',
        'BY'=>'BELARUS',
        'BE'=>'BELGIUM',
        'BZ'=>'BELIZE',
        'BJ'=>'BENIN',
        'BM'=>'BERMUDA',
        'BT'=>'BHUTAN',
        'BO'=>'BOLIVIA',
        'BA'=>'BOSNIA AND HERZEGOVINA',
        'BW'=>'BOTSWANA',
        'BV'=>'BOUVET ISLAND',
        'BR'=>'BRAZIL',
        'IO'=>'BRITISH INDIAN OCEAN TERRITORY',
        'BN'=>'BRUNEI DARUSSALAM',
        'BG'=>'BULGARIA',
        'BF'=>'BURKINA FASO',
        'BI'=>'BURUNDI',
        'KH'=>'CAMBODIA',
        'CM'=>'CAMEROON',
        'CA'=>'CANADA',
        'CV'=>'CAPE VERDE',
        'KY'=>'CAYMAN ISLANDS',
        'CF'=>'CENTRAL AFRICAN REPUBLIC',
        'TD'=>'CHAD',
        'CL'=>'CHILE',
        'CN'=>'CHINA',
        'CX'=>'CHRISTMAS ISLAND',
        'CC'=>'COCOS (KEELING) ISLANDS',
        'CO'=>'COLOMBIA',
        'KM'=>'COMOROS',
        'CG'=>'CONGO',
        'CD'=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE',
        'CK'=>'COOK ISLANDS',
        'CR'=>'COSTA RICA',
        'CI'=>'COTE D IVOIRE',
        'HR'=>'CROATIA',
        'CU'=>'CUBA',
        'CY'=>'CYPRUS',
        'CZ'=>'CZECH REPUBLIC',
        'DK'=>'DENMARK',
        'DJ'=>'DJIBOUTI',
        'DM'=>'DOMINICA',
        'DO'=>'DOMINICAN REPUBLIC',
        'TP'=>'EAST TIMOR',
        'EC'=>'ECUADOR',
        'EG'=>'EGYPT',
        'SV'=>'EL SALVADOR',
        'GQ'=>'EQUATORIAL GUINEA',
        'ER'=>'ERITREA',
        'EE'=>'ESTONIA',
        'ET'=>'ETHIOPIA',
        'FK'=>'FALKLAND ISLANDS (MALVINAS)',
        'FO'=>'FAROE ISLANDS',
        'FJ'=>'FIJI',
        'FI'=>'FINLAND',
        'FR'=>'FRANCE',
        'GF'=>'FRENCH GUIANA',
        'PF'=>'FRENCH POLYNESIA',
        'TF'=>'FRENCH SOUTHERN TERRITORIES',
        'GA'=>'GABON',
        'GM'=>'GAMBIA',
        'GE'=>'GEORGIA',
        'DE'=>'GERMANY',
        'GH'=>'GHANA',
        'GI'=>'GIBRALTAR',
        'GR'=>'GREECE',
        'GL'=>'GREENLAND',
        'GD'=>'GRENADA',
        'GP'=>'GUADELOUPE',
        'GU'=>'GUAM',
        'GT'=>'GUATEMALA',
        'GN'=>'GUINEA',
        'GW'=>'GUINEA-BISSAU',
        'GY'=>'GUYANA',
        'HT'=>'HAITI',
        'HM'=>'HEARD ISLAND AND MCDONALD ISLANDS',
        'VA'=>'HOLY SEE (VATICAN CITY STATE)',
        'HN'=>'HONDURAS',
        'HK'=>'HONG KONG',
        'HU'=>'HUNGARY',
        'IS'=>'ICELAND',
        'IN'=>'INDIA',
        'ID'=>'INDONESIA',
        'IR'=>'IRAN, ISLAMIC REPUBLIC OF',
        'IQ'=>'IRAQ',
        'IE'=>'IRELAND',
        'IL'=>'ISRAEL',
        'IT'=>'ITALY',
        'JM'=>'JAMAICA',
        'JP'=>'JAPAN',
        'JO'=>'JORDAN',
        'KZ'=>'KAZAKSTAN',
        'KE'=>'KENYA',
        'KI'=>'KIRIBATI',
        'KP'=>'KOREA DEMOCRATIC PEOPLES REPUBLIC OF',
        'KR'=>'KOREA REPUBLIC OF',
        'KW'=>'KUWAIT',
        'KG'=>'KYRGYZSTAN',
        'LA'=>'LAO PEOPLES DEMOCRATIC REPUBLIC',
        'LV'=>'LATVIA',
        'LB'=>'LEBANON',
        'LS'=>'LESOTHO',
        'LR'=>'LIBERIA',
        'LY'=>'LIBYAN ARAB JAMAHIRIYA',
        'LI'=>'LIECHTENSTEIN',
        'LT'=>'LITHUANIA',
        'LU'=>'LUXEMBOURG',
        'MO'=>'MACAU',
        'MK'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF',
        'MG'=>'MADAGASCAR',
        'MW'=>'MALAWI',
        'MY'=>'MALAYSIA',
        'MV'=>'MALDIVES',
        'ML'=>'MALI',
        'MT'=>'MALTA',
        'MH'=>'MARSHALL ISLANDS',
        'MQ'=>'MARTINIQUE',
        'MR'=>'MAURITANIA',
        'MU'=>'MAURITIUS',
        'YT'=>'MAYOTTE',
        'MX'=>'MEXICO',
        'FM'=>'MICRONESIA, FEDERATED STATES OF',
        'MD'=>'MOLDOVA, REPUBLIC OF',
        'MC'=>'MONACO',
        'MN'=>'MONGOLIA',
        'MS'=>'MONTSERRAT',
        'MA'=>'MOROCCO',
        'MZ'=>'MOZAMBIQUE',
        'MM'=>'MYANMAR',
        'NA'=>'NAMIBIA',
        'NR'=>'NAURU',
        'NP'=>'NEPAL',
        'NL'=>'NETHERLANDS',
        'AN'=>'NETHERLANDS ANTILLES',
        'NC'=>'NEW CALEDONIA',
        'NZ'=>'NEW ZEALAND',
        'NI'=>'NICARAGUA',
        'NE'=>'NIGER',
        'NG'=>'NIGERIA',
        'NU'=>'NIUE',
        'NF'=>'NORFOLK ISLAND',
        'MP'=>'NORTHERN MARIANA ISLANDS',
        'NO'=>'NORWAY',
        'OM'=>'OMAN',
        'PK'=>'PAKISTAN',
        'PW'=>'PALAU',
        'PS'=>'PALESTINIAN TERRITORY, OCCUPIED',
        'PA'=>'PANAMA',
        'PG'=>'PAPUA NEW GUINEA',
        'PY'=>'PARAGUAY',
        'PE'=>'PERU',
        'PH'=>'PHILIPPINES',
        'PN'=>'PITCAIRN',
        'PL'=>'POLAND',
        'PT'=>'PORTUGAL',
        'PR'=>'PUERTO RICO',
        'QA'=>'QATAR',
        'RE'=>'REUNION',
        'RO'=>'ROMANIA',
        'RU'=>'RUSSIAN FEDERATION',
        'RW'=>'RWANDA',
        'SH'=>'SAINT HELENA',
        'KN'=>'SAINT KITTS AND NEVIS',
        'LC'=>'SAINT LUCIA',
        'PM'=>'SAINT PIERRE AND MIQUELON',
        'VC'=>'SAINT VINCENT AND THE GRENADINES',
        'WS'=>'SAMOA',
        'SM'=>'SAN MARINO',
        'ST'=>'SAO TOME AND PRINCIPE',
        'SA'=>'SAUDI ARABIA',
        'SN'=>'SENEGAL',
        'SC'=>'SEYCHELLES',
        'SL'=>'SIERRA LEONE',
        'SG'=>'SINGAPORE',
        'SK'=>'SLOVAKIA',
        'SI'=>'SLOVENIA',
        'SB'=>'SOLOMON ISLANDS',
        'SO'=>'SOMALIA',
        'ZA'=>'SOUTH AFRICA',
        'GS'=>'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
        'ES'=>'SPAIN',
        'LK'=>'SRI LANKA',
        'SD'=>'SUDAN',
        'SR'=>'SURINAME',
        'SJ'=>'SVALBARD AND JAN MAYEN',
        'SZ'=>'SWAZILAND',
        'SE'=>'SWEDEN',
        'CH'=>'SWITZERLAND',
        'SY'=>'SYRIAN ARAB REPUBLIC',
        'TW'=>'TAIWAN, PROVINCE OF CHINA',
        'TJ'=>'TAJIKISTAN',
        'TZ'=>'TANZANIA, UNITED REPUBLIC OF',
        'TH'=>'THAILAND',
        'TG'=>'TOGO',
        'TK'=>'TOKELAU',
        'TO'=>'TONGA',
        'TT'=>'TRINIDAD AND TOBAGO',
        'TN'=>'TUNISIA',
        'TR'=>'TURKEY',
        'TM'=>'TURKMENISTAN',
        'TC'=>'TURKS AND CAICOS ISLANDS',
        'TV'=>'TUVALU',
        'UG'=>'UGANDA',
        'UA'=>'UKRAINE',
        'AE'=>'UNITED ARAB EMIRATES',
        'GB'=>'UNITED KINGDOM',
        'US'=>'UNITED STATES',
        'UM'=>'UNITED STATES MINOR OUTLYING ISLANDS',
        'UY'=>'URUGUAY',
        'UZ'=>'UZBEKISTAN',
        'VU'=>'VANUATU',
        'VE'=>'VENEZUELA',
        'VN'=>'VIET NAM',
        'VG'=>'VIRGIN ISLANDS, BRITISH',
        'VI'=>'VIRGIN ISLANDS, U.S.',
        'WF'=>'WALLIS AND FUTUNA',
        'EH'=>'WESTERN SAHARA',
        'YE'=>'YEMEN',
        'YU'=>'YUGOSLAVIA',
        'ZM'=>'ZAMBIA',
        'ZW'=>'ZIMBABWE',
    );
	
	return $country_array;
}