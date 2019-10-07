<?php

if (!defined('ABSPATH')) exit;

define('THEGEM_GDPR_PLUGIN_ROOT_FILE', __FILE__);
define('THEGEM_GDPR_PLUGIN_ROOT_DIR', __DIR__);

require plugin_dir_path(__FILE__).'inc/classes/thegem-gdpr.php';
require plugin_dir_path(__FILE__).'inc/classes/thegem-gdpr-cf7.php';
require plugin_dir_path(__FILE__).'inc/classes/thegem-gdpr-wp.php';

$thegem_gdpr = new TheGemGdpr();
$thegem_gdpr->run();

if (!function_exists('boolval')) {
	function boolval($var){
		return !! $var;
	}
}