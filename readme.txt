=== Tabs Shortcodes ===
Contributors: philbuchanan
Author URI: http://philbuchanan.com/
Donate Link: http://philbuchanan.com/
Tags: tab, tabs, shortcodes
Requires at least: 3.3
Tested up to: 4.1
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a few shortcodes to allow for tabbed content.

== Description ==
Adds a few shortcodes to allow for tabbed content.

**IMPORTANT:** If you are not comfortable using WordPress shortcodes, this plugin may not be for you. Additionally, you must be able to edit your themes main stylesheet in order to add the [necessary CSS](http://wordpress.org/plugins/tabs-shortcodes/other_notes/).

= Features =

* Adds two shortcodes for adding a tabbed interface to your site
* Select a specific tab by URL
* No default CSS added (you will **need** to [add your own](http://wordpress.org/plugins/tabs-shortcodes/other_notes/))
* Only adds JavaScript on pages that use the shortcodes (and doesn't require jQuery)

= The Shortcodes =

The two shortcodes that are added are:

`[tabs]`

and

`[tab title=""]`

= Basic Usage Example =

    [tabs]
    [tab title="First Tab"]Content for tab one goes here.[/tab]
    [tab title="Second Tab"]Content for tab two goes here.[/tab]
    [tab title="Third Tab"]Content for tab three goes here.[/tab]
    [/tabs]

This will output the following HTML:

    <ul class="tabs">
        <li><a href="#tab-1" class="active">First Tab</a></li>
        <li><a href="#tab-2">Second Tab</a></li>
        <li><a href="#tab-3">Third Tab</a></li>
    </ul>
    <section id="tab-1" class="tab active">Content for tab one goes here.</section>
    <section id="tab-2" class="tab">Content for tab two goes here.</section>
    <section id="tab-3" class="tab">Content for tab three goes here.</section>

= Settings =

There are no settings for the plugin. The only additional setup you will need to do is [add some css](http://wordpress.org/plugins/tabs-shortcodes/other_notes/) to style the tabs however you'd like. Adding the CSS is very important as the tabs will not display as tabs until you do so.

= Selecting a Tab by Default =

You can select a tab by default by added the tab number as an option in the opening `[tabs]` shortcode like this: 

`[tabs open="2"]`

This will open the second tab when the page loads.

= Selecting a Tab by URL =

You can select a tab by default using a hash in the URL. Simply add `#tab-1` after the trailing / of the URL to select tab number 1. Replace the number with the tab you'd like to select.

This example URL will select tab number 3:

`http://domain.com/your-page/#tab-3`

== Installation ==
1. Upload the 'tabs-shortcodes' folder to the '/wp-content/plugins/' directory.
2. Activate the plugin through the Plugins menu in WordPress.
3. Add the shortcodes to your content.
4. Add some [CSS](http://wordpress.org/plugins/tabs-shortcodes/other_notes/#Other-Notes) to your themes stylesheet to make the tabs look the way you want.

== Frequently Asked Questions ==

= Why isn't the JavaScript file loading on my site? =

This is most likely caused by a poorly coded theme. The plugin makes use of the `wp_footer()` function to load the JavaScript file. Check your theme to ensure that the `wp_footer()` function is being called right before the closing `</body>` tag in your themes footer.php file.

== Other Notes ==

= Sample CSS =

Here is some sample CSS to get you started. Make adjustments as necessary if you want to customize the look and feel of the tabs.

    /* Tabs Styles */
    ul.tabs {
        list-style: none;
        margin: 0;
        border-bottom: 1px solid #ccc;
    }
    ul.tabs li {display: inline-block;}
    ul.tabs a {
        display: block;
        position: relative;
        top: 1px;
        padding: 5px 10px;
        border: 1px solid transparent;
        text-decoration: none;
    }
    ul.tabs a.active {
        border-color: #ccc;
        border-bottom-color: #fff;
    }
    section.tab {
        display: none;
        margin-bottom: 15px;
        padding: 15px 0;
    }
    section.tab.active {display: block;}

= Issues/Suggestions =

For bug reports or feature requests or if you'd like to contribute to the plugin you can check everything out on [Github](https://github.com/philbuchanan/Tabs-Shortcodes/).

== Changelog ==
= 1.2 =
* Added an option to open a specific tab by default
* Now compatible up to WordPress 4.1

= 1.1.1 =
* Fixed breaking tabs when clicking outside tab area

= 1.1 =
* Added ability to select a specific tab based on the URL

= 1.0.3 =
* Compatibility with WordPress 3.9

= 1.0.2 =
* Added the shortcode parameter when calling shortcode_atts()

= 1.0.1 =
* Drastically simplified JavaScript

= 1.0 =
* Initial release

== Upgrade Notice ==
= 1.2 =
Added an option to open a specific tab by default.

= 1.1.1 =
Fixed breaking tabs when clicking outside tab area.

= 1.1 =
Added ability to select a specific tab based on the URL.

= 1.0.3 =
Compatibility with WordPress 3.9.

= 1.0.2 =
Added the shortcode parameter when calling shortcode_atts().

= 1.0.1 =
Drastically simplified JavaScript.

= 1.0 =
Initial release.