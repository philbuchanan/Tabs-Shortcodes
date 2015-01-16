<?php
/**
 * Plugin Name: Tabs Shortcodes
 * Description: Adds a few shortcodes to allow for tabbed content.
 * Version: 1.2
 * Author: Phil Buchanan
 * Author URI: http://philbuchanan.com
 */

# Make sure to not redeclare the class
if (!class_exists('Tabs_Shortcodes')) :

class Tabs_Shortcodes {

	private $add_script;
	private $tab_titles;
	
	function __construct() {
	
		$basename = plugin_basename(__FILE__);
		
		# Load text domain
		load_plugin_textdomain('tabs_shortcodes', false, dirname($basename) . '/languages/');
		
		# Register JavaScript
		add_action('wp_enqueue_scripts', array($this, 'register_script'));
		
		# Add shortcodes
		add_shortcode('tabs', array($this, 'tabs_shortcode'));
		add_shortcode('tab', array($this, 'tab_shortcode'));
		
		# Print script in wp_footer
		add_action('wp_footer', array($this, 'print_script'));
		
		# Add link to documentation
		add_filter("plugin_action_links_$basename", array($this, 'add_documentation_link'));
		
		# Add activation notice (advising user to add CSS)
		register_activation_hook(__FILE__, array($this, 'install'));
		add_action('admin_notices', array($this, 'plugin_activation_notice'));
	
	}
	
	# Installation function
	public function install() {
	
		# Add notice option
		add_option('tabs_shortcodes_notice', 1, '', 'no');
	
	}
	
	# Add the activation notice
	public function plugin_activation_notice() {
	
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
	public function register_script() {
	
		$min = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
		wp_register_script('tabs-shortcodes-script', plugins_url('tabs' . $min . '.js', __FILE__), array(), '1.2', true);
	
	}
	
	# Prints the minified tabs JavaScript file in the footer
	public function print_script() {
	
		# Check to see if shortcodes are used on page
		if (!$this->add_script) return;
		
		wp_enqueue_script('tabs-shortcodes-script');
	
	}
	
	# Tabs wrapper shortcode
	public function tabs_shortcode($atts, $content = null) {
	
		# The shortcode is used on the page, so we'll need to load the JavaScript
		$this->add_script = true;
		
		# Create empty titles array
		$this->tab_titles = array();
		
		extract(shortcode_atts(array(
			'open' => ''
		), $atts, 'tabs'));
		
		if (!$open) {
			$open = false;
		}
		
		$script_data = array(
			'open' => $open
		);
		
		wp_localize_script('tabs-shortcodes-script', 'tabsShortcodesSettings', $script_data);
		
		# Get all individual tabs content
		$tab_content = do_shortcode($content);
		
		# Start the tab navigation
		$out = '<ul id="tabs" class="tabs">';
		
		# Loop through tab titles
		foreach ($this->tab_titles as $key => $title) {
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
	public function tab_shortcode($atts, $content = null) {
	
		extract(shortcode_atts(array(
			'title' => ''
		), $atts, 'tab'));
		
		# Add the title to the titles array
		array_push($this->tab_titles, $title);
		
		$id = count($this->tab_titles);
		
		return sprintf('<section id="%s" class="tab%s">%s</section>',
			'tab-' . $id,
			$id == 1 ? ' active' : '',
			do_shortcode($content)
		);
	
	}
	
	# Add documentation link on plugin page
	public function add_documentation_link($links) {
	
		array_push($links, sprintf('<a href="%s">%s</a>',
			'http://wordpress.org/plugins/tabs-shortcodes/',
			__('Documentation', 'tabs_shortcodes')
		));
		
		return $links;
	
	}

}

$Tabs_Shortcodes = new Tabs_Shortcodes;

endif;