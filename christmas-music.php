<?php
/**
 * The plugin bootstrap file.
 *
 * @since             1.0.0
 * @package           Christmas_Music
 *
 * @wordpress-plugin
 * Plugin Name:       Christmas Music
 * Plugin URI:        https://xmasmusicwp.com/
 * Description:       This plugin adds Christmas music to your site. Also has play/pause buttons at the bottom right corner of your site.
 * Version:           2.0.0
 * Requires at least: 4.0
 * Requires PHP:      5.6
 * Author:            Belov Digital Agency
 * Author URI:        https://belovdigital.agency
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       christmas-music
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Helper constants
 */
define( 'XMAS_MUSIC_VERSION', '2.0.0' );
define( 'XMAS_MUSIC_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'XMAS_MUSIC_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Plugin activation hook
 */
function activate_christmas_music() {
	// Add option for showing notice with link to settings.
	set_transient( 'christmas-music-setting-link-notice', true, 5 );
}

register_activation_hook( __FILE__, 'activate_christmas_music' );


/**
 * Notice with link to settings after plugin activation
 */
function christmas_music_setting_link_notice() {
	if ( get_transient( 'christmas-music-setting-link-notice' ) ) :
		?>
		<div class="notice notice-success updated is-dismissible">
			<p><?php echo __( 'Thank you for installing our Christmas Music plugin. The next step is to <a href="admin.php?page=xmas-music-settings">configure the settings of the plugin</a>.', 'christmas-music' ); ?></p>
		</div>
		<?php
		delete_transient( 'christmas-music-setting-link-notice' );
	endif;
}

add_action( 'admin_notices', 'christmas_music_setting_link_notice' );


/**
 * Plugin i18n
 */
function christmas_music_translation() {
	load_plugin_textdomain( 'christmas-music', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'christmas_music_translation' );


/**
 * Admin side settings
 */
require plugin_dir_path( __FILE__ ) . 'admin/christmas-music-admin.php';


/**
 * Public side settings
 */
require plugin_dir_path( __FILE__ ) . 'public/christmas-music-public.php';
