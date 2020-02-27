<?php
/**
 * Plugin Name: Beaver Builder Extra Conditional Logic
 * Plugin URI: http://www.wpbeaverbuilder.com
 * Description: Adds extra options to Beaver Builder's conditional logic settings
 * Version: 1.0.0
 * Author: Seth Stevenson
 * Author URI: https://sethstevenson.net
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'BB_EXTRA_CONDITIONAL_LOGIC_DIR', plugin_dir_path( __FILE__ ) );
define( 'BB_EXTRA_CONDITIONAL_LOGIC_URL', plugins_url( '/', __FILE__ ) );
define( 'BB_EXTRA_CONDITIONAL_LOGIC_VERSION', '1.0.0');

/**
 * The core plugin class
 * 
 * @since 1.0.0
 * 
 * Defines the core actions for the plugin. Registers backend
 * and frontend functionality with WordPress
 */

class Bb_Extra_Conditional_Logic {

	public function run() {

		require_once BB_EXTRA_CONDITIONAL_LOGIC_DIR . 'includes/rules.php';

		$backend_rules = new Bb_Extra_Conditional_Logic_Rules();
		$backend_rules->init();
		
		add_action( 'bb_logic_enqueue_scripts', function() {
			wp_enqueue_script(
				'bb-extra-conditional-logic-rules',
				BB_EXTRA_CONDITIONAL_LOGIC_URL . 'js/rules.js',
				array( 'bb-logic-core' ),
				BB_EXTRA_CONDITIONAL_LOGIC_VERSION,
				true
			);
		} );
	}
}

function run_bb_extra_conditional_logic() {
	$plugin = new Bb_Extra_Conditional_Logic();
	$plugin->run();
}

run_bb_extra_conditional_logic();