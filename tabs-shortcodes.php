<?php
/**
 * Plugin Name: Tab Shortcodes
 * Description: Adds a few shortcodes to allow for tabbed content.
 * Version: 0.2
 * Author: Phil Buchanan
 * Author URI: http://philbuchanan.com
 */

# Make sure to not redeclare the class
if (!class_exists('Tab_Shortcodes')) :

class Tab_Shortcodes {

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
	
	}
	
	# Checks for boolean value
	static function parse_boolean($value) {
	
		return filter_var($value, FILTER_VALIDATE_BOOLEAN);
	
	}
	
	# Registers the minified tabs JavaScript file
	static function register_script() {
	
		wp_register_script('tab-shortcodes-script', plugins_url('tabs.js', __FILE__), array(), '0.2', true);
	
	}
	
	# Prints the minified tabs JavaScript file in the footer
	static function print_script() {
	
		# Check to see if shortcodes are used on page
		if (!self::$add_script) return;
		
		wp_enqueue_script('tab-shortcodes-script');
	
	}
	
	# Tabs wrapper shortcode
	static function tabs_shortcode($atts, $content = null) {
	
		# The shortcode is used on the page, so we'll need to load the JavaScript
		self::$add_script = true;
		
		# Create empty titles array
		self::$tab_titles = array();
		
		extract(shortcode_atts(array(), $atts));
		
		# Get all individual tabs content
		$tab_content = do_shortcode($content);
		
		# Start the tab navigation
		$out = '<ul class="tabs">';
		
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
		), $atts));
		
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

$Tab_Shortcodes = new Tab_Shortcodes;

endif;