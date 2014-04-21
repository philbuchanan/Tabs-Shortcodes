<?php
/**
 * Plugin Name: Tabs Shortcodes
 * Description: Adds a few shortcodes to allow for tabbed content.
 * Version: 1.0.3
 * Author: Phil Buchanan
 * Author URI: http://philbuchanan.com
 */

# Make sure to not redeclare the class
if (!class_exists('Tabs_Shortcodes')) :

class Tabs_Shortcodes {

	static $add_script;
	static $tab_titles;
	
	function __construct() {
	
		$basename = plugin_basename(__FILE__);
		
		# Load text domain
		load_plugin_textdomain('tabs_shortcodes', false, dirname($basename) . '/languages/');
		
		# Register JavaScript
		add_action('wp_enqueue_scripts', array(__CLASS__, 'register_script'));
		
		# Add shortcodes
		add_shortcode('tabs', array(__CLASS__, 'tabs_shortcode'));
		add_shortcode('tab', array(__CLASS__, 'tab_shortcode'));
		
		# Print script in wp_footer
		add_action('wp_footer', array(__CLASS__, 'print_script'));
		
		# Add link to documentation
		add_filter("plugin_action_links_$basename", array(__CLASS__, 'add_documentation_link'));
		
		# Add activation notice (advising user to add CSS)
		register_activation_hook(__FILE__, array(__CLASS__, 'install'));
		add_action('admin_notices', array(__CLASS__, 'plugin_activation_notice'));
	
	}
	
	# Installation function
	static function install() {
	
		# Add notice option
		add_option('tabs_shortcodes_notice', 1, '', 'no');
	
	}
	
	# Add the activation notice
	static function plugin_activation_notice() {
	
		# Check for option before displaying notice
		if (get_option('tabs_shortcodes_notice')) {
		
			# We can now delete the option since the notice will be displayed
			delete_option('tabs_shortcodes_notice');
			
			# Generate notice
			$html = '<div class="updated"><p>';
			$html .= __('<strong>Important</strong>: Make sure to <a href="http://wordpress.org/plugins/tabs-shortcodes/other_notes/">add some CSS</a> to your themes stylesheet to ensure the tabs shortcodes display properly.', 'tabs_shortcodes');
			$html .= '</p></div>';
			
			# Display notice
			echo $html;
		
		}
	
	}
	
	# Registers the minified tabs JavaScript file
	static function register_script() {
	
		$min = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
		wp_register_script('tabs-shortcodes-script', plugins_url('tabs' . $min . '.js', __FILE__), array(), '1.0.3', true);
	
	}
	
	# Prints the minified tabs JavaScript file in the footer
	static function print_script() {
	
		# Check to see if shortcodes are used on page
		if (!self::$add_script) return;
		
		wp_enqueue_script('tabs-shortcodes-script');
	
	}
	
	# Tabs wrapper shortcode
	static function tabs_shortcode($atts, $content = null) {
	
		# The shortcode is used on the page, so we'll need to load the JavaScript
		self::$add_script = true;
		
		# Create empty titles array
		self::$tab_titles = array();
		
		extract(shortcode_atts(array(), $atts, 'tabs'));
		
		# Get all individual tabs content
		$tab_content = do_shortcode($content);
		
		# Start the tab navigation
		$out = '<ul id="tabs" class="tabs">';
		
		# Loop through tab titles
		foreach (self::$tab_titles as $key => $title) {
			$id = $key + 1;
			$out .= sprintf('<li><a href="#%s"%s>%s</a></li>',
				'tab-' . $id,
				$id == 1 ? ' class="active"' : '',
				$title
			);
		}
		
		# Close the tab navigation container and add tab content
		$out .= '</ul>';
		$out .= $tab_content;
		
		return $out;
	
	}
	
	# Tab item shortcode
	static function tab_shortcode($atts, $content = null) {
	
		extract(shortcode_atts(array(
			'title' => ''
		), $atts, 'tab'));
		
		# Add the title to the titles array
		array_push(self::$tab_titles, $title);
		
		$id = count(self::$tab_titles);
		
		return sprintf('<section id="%s" class="tab%s">%s</section>',
			'tab-' . $id,
			$id == 1 ? ' active' : '',
			do_shortcode($content)
		);
	
	}
	
	# Add documentation link on plugin page
	static function add_documentation_link($links) {
	
		array_push($links, sprintf('<a href="%s">%s</a>',
			'http://wordpress.org/plugins/tabs-shortcodes/',
			__('Documentation', 'tabs_shortcodes')
		));
		
		return $links;
	
	}

}

$Tabs_Shortcodes = new Tabs_Shortcodes;

endif;