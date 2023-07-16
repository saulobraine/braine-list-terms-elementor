<?php
/**
* Plugin Name: List Terms - Braine
* Description: Create a list within set post type for simulate a taxonomy vertical menu
* Version: 1.0
* Author: Saulo Braine
* Author URI: https://braine.dev
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: list-ctp-braine
* Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

 /* ACTIVATION */
 register_activation_hook( __FILE__, function() {
	/* UPDATE PERMALINKS */
	flush_rewrite_rules();
});

/* DEACTIVATION */
register_deactivation_hook( __FILE__, function(){
	/* UPDATE PERMALINKS */
	flush_rewrite_rules();
});


// Including widget file
require_once(__DIR__ . '/widgets/widgets.php');