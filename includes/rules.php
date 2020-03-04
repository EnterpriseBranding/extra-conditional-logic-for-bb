<?php

/**
 * Register the backend rules and evaluation
 * 
 * @since 1.0.0
 */

class Extra_Conditional_Logic_For_Bb_Rules {

	public function init() {

		add_action( 'bb_logic_init', function() {
			BB_Logic_Rules::register( array(
				'extra-conditional-logic-for-bb/paged' => array($this, 'paged_evaluation'),
				'extra-conditional-logic-for-bb/post-format' => array ($this, 'post_format_evaluation'),
				'extra-conditional-logic-for-bb/user-country-code' => array($this, 'user_country_code'),
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
	
	/**
	 * User Country Code
	 * 
	 * @param [type] $rule
	 * @return void
	 * @since 1.0.0
	 * 
	 * Credit: https://thewpdaily.com/row-module-based-visitor-country-location-beaver-builder/
	 */
	
	public function user_country_code( $rule ) {
		// Get local IP address
    $ip = $_SERVER['REMOTE_ADDR'];
 
		if ( 
			isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && 
			filter_var( @$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP )
			) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
        
 
    if (
			isset( $_SERVER['HTTP_CLIENT_IP'] ) && 
			filter_var( @$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP )
			) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			}
    
    // Get local geolocation data as json type
    $json = file_get_contents('http://www.geoplugin.net/json.gp?ip=' . $ip );
    $data = json_decode($json);
    $countryCode = strtoupper( substr( $data->geoplugin_currencyCode, 0, 2) );
 
    if( $rule->operator == "includes" || $rule->operator == "does_not_include" ) {
        $codes = $rule->compare;
        $rule->compare = $countryCode;
        $countryCode = explode( ',', strtoupper( $codes ) );
    }
    
    return BB_Logic_Rules::evaluate_rule( array(
        'value'     	=> $countryCode,
        'operator'    => $rule->operator,
        'compare'     => strtoupper( $rule->compare ),
    ) );
	}

}
