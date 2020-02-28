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
				'bb-extra-conditional-logic/paged' => array($this, 'paged_evaluation'),
				'bb-extra-conditional-logic/post-format' => array ($this, 'post_format_evaluation')
			) );
		});
	}

	/**
	 * Paged Evaluation
	 *
	 * @param [type] $rule
	 * @return void
	 * @since 1.0.0
	 */
	public function paged_evaluation( $rule ) {
		
		$paged = (get_query_var('paged')) ? get_query_var('paged') : false;

		// Evaluate the rule compared to the current page and return a boolean
		return BB_Logic_Rules::evaluate_rule( array(
			'value' => $paged,
			'operator' => $rule->operator,
			'compare' => $rule->value,
		) );
	}

	/**
	 * Post Format Evaluation
	 *
	 * @param [type] $rule
	 * @return void
	 * @since 1.0.0
	 */
	public function post_format_evaluation( $rule ) {

		$post_format = "standard"; // Default if no post_format set

		if( get_post_format() ) {
			$post_format = strval( get_post_format() );
		}
		
		// Evaluate the post format compared to the current post
		return BB_Logic_Rules::evaluate_rule( array(
			'value' => $post_format,
			'operator' => $rule->operator,
			'compare' => $rule->format,
		) );

	}

}
