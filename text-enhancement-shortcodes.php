<?php
/*
 *

 Plugin Name: Text Enhancement Shortcodes - Dropcap, etc
 Plugin URI: http://davidherron.com/content/external-links-nofollow-favicon-open-external-window-etc-wordpress
 Description: Provide shortcodes to enhance text presentation
 Version: 0.1.0
 Author: David Herron
 Author URI: http://davidherron.com/wordpress
 slug: text-enhancement-shortcodes
 License:     GPL2
 License URI: https://www.gnu.org/licenses/gpl-2.0.html
 
   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License, version 2, as
   published by the Free Software Foundation.
   
   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   GNU General Public License for more details.
     
   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
   
*/

define("DHTXTENHANCEDIR", plugin_dir_path(__FILE__));
define("DHTXTENHANCEURL", plugin_dir_url(__FILE__));
// define("DHTXTENHANCESLUG",dirname(plugin_basename(__FILE__)));


function dh_txtenhance_enqueue_scripts() {
    wp_enqueue_style(DHTXTENHANCEURL . 'css/txtenhance-style.css');
}
add_action('wp_enqueue_scripts', 'dh_txtenhance_enqueue_scripts');

function dh_txtenhance_admin_init() {
    register_setting('dh-txtenhance-settings-group', 'dh_txtenhance_enable_dropcaps');
}
add_action('admin_init', 'dh_txtenhance_admin_init');

add_action('admin_menu', 'dh_txtenhance_plugin_menu');
function dh_txtenhance_plugin_menu() {
    add_options_page('Text enhancement shortcodes, dropcaps etc', 'Text enhancement, dropcaps etc',
                     'manage_options', 'dh_txtenhance_option_page', 'dh_txtenhance_option_page_fn');
}

function dh_txtenhance_option_page_fn() {
    $dh_txtenhance_enable_dropcaps = get_option('dh_txtenhance_enable_dropcaps');
    ?>
        <div class="wrap">
                <h2>Text enhancement shortcodes, dropcaps etc</h2>
                <div class="content_wrapper">
                        <div class="left">
                                <form method="post" action="options.php" enctype="multipart/form-data">
                                        <?php settings_fields( 'dh-txtenhance-settings-group' ); ?>

                <div>
                    <input type="checkbox" name="dh_txtenhance_enable_dropcaps" value="yes" <?php
                    if (!empty($dh_txtenhance_enable_dropcaps) && $dh_txtenhance_enable_dropcaps === "yes") {
                        ?>checked<?php
                    }
                    ?> > Enable the <tt>dropcaps</tt> shortcode?
                </div>
                    
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>

				</form>
			</div>
		</div>
	</div>
<?php
}

function dh_txtenhance_dropcaps($atts, $content = null, $tag) {
    $dh_txtenhance_enable_dropcaps = get_option('dh_txtenhance_enable_dropcaps');
    if (!empty($dh_txtenhance_enable_dropcaps) && $dh_txtenhance_enable_dropcaps === "yes") {
	return "<span class='.dh-txtenhance-dropcaps'>". do_shortcode($content) ."</span>";
    } else {
	return $content;
    }
}
add_shortcode('dropcaps', 'dh_txtenhance_dropcaps');

