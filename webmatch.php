<?php
/**
 * Plugin Name: Callcap Webmatch
 * Plugin URI: http://www.callcap.com/help/webmatch-wordpress/
 * Description: Works with Webmatch by Callcap to associate pageviews with phonecalls and dynamically switch out phone numbers with your Webmatch phone numbers.
 * Version: 1.6.5
 * Author: Callcap
 * Author URI: http://www.callcap.com
 * License: GPL v2
 */


// --------------------------------------------------------------
// ACTIONS
// --------------------------------------------------------------

// add webmatch tracking code to pages
add_action( 'wp_enqueue_scripts', 'init_webmatch' );

// add the admin menu item
add_action( 'admin_menu', 'init_webmatch_menu' );

// place the webmatch code in the footer of the WP pages
add_action( 'wp_head', 'place_webmatch', 9);

// --------------------------------------------------------------
// FUNCTIONS
// --------------------------------------------------------------

// link to the callcap webmatch.js file
function init_webmatch () {
	wp_enqueue_script( 'init', '//webmatch.callcap.com/track/webmatch.js', array( ), '1.0', false );
}

// create the menu item in the admin panel
function init_webmatch_menu () {
	add_menu_page( 'Webmatch Options', 'Webmatch Options', 'administrator', 'webmatch-options', 'webmatch_menu_page', 'dashicons-phone' );
	add_action( 'admin_init', 'webmatch_menu_settings' );

	/* Register our stylesheet. */
	wp_register_style( 'webmatchStyle', plugins_url('style.css', __FILE__) );
	wp_enqueue_style( 'webmatchStyle' );

	// set up the database cell for our multidimensional array
	function webmatch_menu_settings() {
		register_setting( 'webmatch_menu_settings_group', 'callcap_campaigns');
	}

}

// create the settings form
// everything in the admin panel is populated from this page
function webmatch_menu_page () {
	include('webmatch-form.php');
}

// actually place the script on the page
function place_webmatch () {

	// store the entire list of campaigns in an array
	$aCampaign = get_option('callcap_campaigns');

	if (empty($aCampaign)) {

		echo "<!-- No Webmatch campaigns are currently set up. -->";

	} else { // if ANY campaigns are set
		echo "<!-- Callcap Webmatch for Wordpress-->
";
		echo "<script>
";

		$campaignIterator = 0;

		foreach ($aCampaign as $campaign) {

			// handle dynamic campaigns
			if ($campaign['campaign_type'] == "dynamic") {
				$dynamicHTML = "var webmatch_".$campaignIterator." = new Webmatch({
					rotate: '".$campaign['campaign_id']."',
					phone_format: '".$campaign['phone_format']."',
					phone_link: ".$campaign['phone_link'].",
					instance_class: '".$campaign['instance_class']."'";

				if ($campaign['utm_option'] == "pull_parameters") {
					$dynamicHTML .= ", pull_parameters: true";
				}

				if ($campaign['utm_option'] == "load_utm_parameters") {
					$dynamicHTML .= ", loadUtmParams: true";
				}

				if ($campaign['utm_term_for_search'] == "on") {
					$dynamicHTML .= ", useUtmTermForSearch: true";
				}

				$dynamicHTML .= "
}).init();
";

				echo $dynamicHTML;

			}

			// handle static campaigns
			if ($campaign['campaign_type'] == "static") {
				$staticHTML = "var webmatch_".$campaignIterator." = new Webmatch({
					u: '".$campaign['campaign_id']."'";
				if ($campaign['utm_option'] == "pull_parameters") {
					$staticHTML .= ", pull_parameters: true";
				}

				if ($campaign['utm_option'] == "load_utm_parameters") {
					$staticHTML .= ", loadUtmParams: true";
				}

				if ($campaign['utm_term_for_search'] == "on") {
					$staticHTML .= ", useUtmTermForSearch: true";
				}

				$staticHTML .= "
}).init();
";

				echo $staticHTML;

			}

			$campaignIterator++;

		} // end foreach

		echo "</script>";
	}

}


?>
