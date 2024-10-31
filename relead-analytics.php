<?php
/*
Plugin Name: Relead
Plugin URI: http://www.relead.com
Description: This is plugin for Relead.com users
Author: Relead.com
Version: 1.0
Author URI: http://www.relead.com/
Text Domain: relead-analytics
License: GPL2
*/


if ( !class_exists( 'ReleadAnalytics' ) ) {

class ReleadAnalytics {
	// Constructor
	function ReleadAnalytics() {
		// Initialise plugin
		add_action( 'init', array( &$this, 'init' ) );
		add_action( 'admin_init', array( &$this, 'admin_init' ) );
		
		add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
		
		add_action( 'wp_head', array( &$this, 'wp_head' ) );
		add_action( 'loop_start', array( &$this, 'loop_start' ) );
		add_action( 'loop_end', array( &$this, 'loop_end' ) );
		add_action( 'wp_footer', array( &$this, 'wp_footer' ) );
	}
	
	// Initialise plugin
	function init() {
		load_plugin_textdomain( 'relead-analytics', false, dirname( plugin_basename ( __FILE__ ) ).'/lang' );
	}
	
	// Initialise plugin - admin part
	function admin_init() {
	
		register_setting( 'relead-analytics', 'chaf_blog_footer' );
	}
	
	// Add Admin menu option
	function admin_menu() {
		add_submenu_page( 'options-general.php', 'Relead', 
			'Relead', 'manage_options', __FILE__, array( &$this, 'options_panel' ) );
	}
	

	
	// Display blog footer
	function wp_footer() {
            if ( !is_admin() && !is_feed() && !is_robots() && !is_trackback() ) {
                echo "<script type=\"text/javascript\">\nvar releadTrackingId = '" . get_option( 'chaf_blog_footer', true ) . "';\n\n(function() {\nvar rl = document.createElement('script');\nrl.type = 'text/javascript';\nrl.async = true;\nrl.src = (document.location.protocol == 'https:' ? 'https://' : 'http://') + 'relead.s3.amazonaws.com/tracking.relead.js';\nvar e = document.getElementsByTagName('script')[0];\ne.parentNode.insertBefore(rl, e);\n})();\n</script>\n";
            }    
	}
	
	// Handle options panel
	function options_panel() {
?>
<div class="wrap">
<?php screen_icon(); ?>
<h2><?php _e('Relead.com - Options', 'relead-analytics'); ?></h2>

<form name="dofollow" action="options.php" method="post">
<?php settings_fields( 'relead-analytics' ); ?>
<img style="margin-left:10px;margin-top:20px;" src="https://s3.amazonaws.com/relead/site/logo.png" />
<table class="form-table">
<tr>
<th scope="row" style="text-align:right; vertical-align:top;width: 110px;">
<label for="chaf_blog_footer"><?php _e('Relead Tracking ID:', 'relead-analytics'); ?></label>
</th>
<td>
<input type="text" style="width:230px;" id="chaf_blog_footer" name="chaf_blog_footer" value="<?php echo esc_html( get_option( 'chaf_blog_footer' ) ); ?>" placeholder="Enter your Relead tracking ID" /><br />Copy Tracking ID, which can be found in<br/>  the tracking code tab in Relead Settings at <br/><a href="http://www.relead.com/settings/">http://www.relead.com/settings/</a>
</td>
</tr>

</table>

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Save settings', 'relead-analytics'); ?>" /> 
</p>

</form>
</div>
<?php
	}
}

// Add functions from WP2.8 for previous WP versions
 if ( !function_exists( 'esc_html' ) ) {
	function esc_html( $text ) {
		return wp_specialchars( $text );
	}
}

if ( !function_exists( 'esc_attr' ) ) {
	function esc_attr( $text ) {
		return attribute_escape( $text );
	}
}

add_option( 'chaf_blog_footer', ''); 

$wp_custom_headers_and_footers = new ReleadAnalytics();

} /* END */

?>