<?php

/**
 * Register the backend rules and evaluation
 * 
 * @since 1.0.0
 */

class Bb_Extra_Conditional_Logic_Rules {

	public function init() {

		add_action( 'bb_logic_init', function() {
			BB_Logic_Rules::register( array(
				'bb-extra-conditional-logic/paged' => array($this, 'paged_evaluation')
			) );
		});
	}

	public function paged_evaluation( $rule ) {
		
		$paged = (get_query_var('paged')) ? get_query_var('paged') : false;

		// Evaluate the rule compared to the current page and return a boolean
		return BB_Logic_Rules::evaluate_rule( array(
			'value' => $paged,
			'operator' => $rule->operator,
			'compare' => $rule->value,
		) );
	}

}
