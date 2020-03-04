<?php
/**
 * Plugin Name: Extra Conditional Logic for Beaver Builder
 * Plugin URI: https://github.com/sethstevenson/bb-extra-conditional-logic
 * Description: Adds extra options to Beaver Builder's conditional logic settings
 * Version: 1.0.0
 * Author: Seth Stevenson
 * Author URI: https://sethstevenson.net
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'EXTRA_CONDITIONAL_LOGIC_FOR_BB_DIR', plugin_dir_path( __FILE__ ) );
define( 'EXTRA_CONDITIONAL_LOGIC_FOR_BB_URL', plugins_url( '/', __FILE__ ) );
define( 'EXTRA_CONDITIONAL_LOGIC_FOR_BB_VERSION', '1.0.0');

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

		require_once EXTRA_CONDITIONAL_LOGIC_FOR_BB_DIR . 'includes/rules.php';

		$backend_rules = new Extra_Conditional_Logic_For_Bb_Rules();
		$backend_rules->init();
		
		add_action( 'bb_logic_enqueue_scripts', function() {
			wp_enqueue_script(
				'extra-conditional-logic-for-bb-rules',
				EXTRA_CONDITIONAL_LOGIC_FOR_BB_URL . 'js/rules.js',
				array( 'bb-logic-core' ),
				EXTRA_CONDITIONAL_LOGIC_FOR_BB_VERSION,
				true
			);
		} );
	}
}

function run_extra_conditional_logicfor_bb() {
	$plugin = new Extra_Conditional_Logic_For_Bb();
	$plugin->run();
}

run_extra_conditional_logic_for_bb();