<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://belovdigital.agency
 * @since      1.0.0
 *
 * @package    Christmas_Music
 * @subpackage Christmas_Music/admin/partials
 */

// Enable xmas mood tooltip.
$xmasmusic_enable_tooltip = get_option( 'xmasmusic_enable_tooltip' ) ? get_option( 'xmasmusic_enable_tooltip' ) : '';

// Audio file.
$xmasmusic_file      = get_option( 'xmasmusic_file' ) ? intval( get_option( 'xmasmusic_file' ) ) : '';
$xmasmusic_file_name = '';

if ( $xmasmusic_file ) {
	$xmasmusic_file_name = basename( get_attached_file( $xmasmusic_file ) );
}

// Enable player on all pages.
$xmasmusic_enable_player = get_option( 'default_play', 'true' );

// Volume.
$xmasmusic_volume = get_option( 'xmasmusic_volume' ) ? intval( get_option( 'xmasmusic_volume' ) ) : 30;

// Autoplay.
$xmasmusic_autoplay = get_option( 'xmasmusic_autoplay', 'true' );

// Player position.
$xmasmusic_player_position = get_option( 'xmasmusic_player_position' ) ? get_option( 'xmasmusic_player_position' ) : 'bottom-right';

// Player style.
$xmasmusic_player_style = get_option( 'xmasmusic_player_style' ) ? get_option( 'xmasmusic_player_style' ) : 'circle';

// Enable player animation.
$xmasmusic_player_animation = get_option( 'xmasmusic_player_animation' ) ? get_option( 'xmasmusic_player_animation' ) : '';

// Background color of player.
$button_background = get_option( 'button_bg' ) ? get_option( 'button_bg' ) : '#ff0000';

// Color of play/pause icon.
$icon_color = get_option( 'button_color' ) ? get_option( 'button_color' ) : '#ffffff';
?>

<div class="wrap hide-notices">
	<!-- Empty h2 for the admin notices view -->
	<h2></h2>

	<div class="christmas-music-settings">

		<div class="christmas-music-settings-main">

			<div class="christmas-music-settings-top">
				<h1><?php echo esc_html__( 'Christmas Music Settings', 'christmas-music' ); ?></h1>
				<div class="christmas-music-settings-logo-wrapper">
					<img src="<?php echo esc_url( XMAS_MUSIC_DIR_URL . 'admin/images/christmas-music-logo.svg' ); ?>" alt="Christmas Music Logo" />
				</div>
			</div>

			<form method="post" action="options.php">
				<?php settings_fields( 'xmasmusic-plugin-settings-group' ); ?>
				<?php do_settings_sections( 'xmasmusic-plugin-settings-group' ); ?>

				<h2><?php echo esc_html__( 'General Options', 'christmas-music' ); ?></h2>
				<hr>
				<div class="christmas-music-settings-group">
					<div class="christmas-music-setting">
						<label class="christmas-music-checkbox-setting">
							<input type="checkbox" name="xmasmusic_enable_tooltip" value="true" <?php checked( 'true', $xmasmusic_enable_tooltip ); ?> />
							<div></div>
							<span><?php echo esc_html__( 'Add "Enable Xmas Mood" tooltip', 'christmas-music' ); ?></button>
						</label>
						<p class="christmas-music-setting-description"><?php echo esc_html__( "Some browsers don't allow autoplay on the first visit (before any user interaction happens), we added this feature to bring our play button to visitor's attention when that limitation happens.", 'christmas-music' ); ?></p>
					</div>

					<div class="christmas-music-setting">
						<p class="christmas-music-setting-label"><?php echo esc_html__( 'Replace music with your own MP3 or WAV', 'christmas-music' ); ?></p>
						<div class="christmas-music-file-setting-wrapper">
							<label class="christmas-music-file-setting">
								<input class="christmas-music-file" type="hidden" name="xmasmusic_file" value="<?php echo esc_attr( $xmasmusic_file ); ?>" />
								<button class="christmas-music-file-button" type="button"><?php echo esc_html__( 'Choose File', 'christmas-music' ); ?></button>
								<div class="christmas-music-file-name"><?php echo esc_html( $xmasmusic_file_name ); ?></div>
							</label>
							<div class="christmas-music-file-remove" style="display:<?php echo $xmasmusic_file_name ? 'inline-block' : 'none'; ?>;"></div>
						</div>
						<p class="christmas-music-setting-description"><?php echo esc_html__( 'Format "WAV" is currently not supported in IE and Edge browsers', 'christmas-music' ); ?></p>
					</div>

					<div class="christmas-music-setting">
						<label class="christmas-music-checkbox-setting">
							<input type="checkbox" name="default_play" value="true" <?php checked( 'true', $xmasmusic_enable_player ); ?> />
							<div></div>
							<span><?php echo esc_html__( 'Play on all pages (entire website)', 'christmas-music' ); ?></button>
						</label>
						<p class="christmas-music-setting-description"><?php echo esc_html__( 'If unchecked, you can add Christmas Music presence to any page or post or custom post type individually (go to the indiviudal page/post/cpt, you’ll find the settings at the top of the right sidebar)', 'christmas-music' ); ?></p>
					</div>

					<div class="christmas-music-setting">
						<p class="christmas-music-setting-label"><?php echo esc_html__( 'Volume level', 'christmas-music' ); ?></p>
						<div class="christmas-music-volume-setting">
							<img src="<?php echo esc_url( XMAS_MUSIC_DIR_URL . 'admin/images/volume.svg' ); ?>" alt="icon" />
							<input class="christmas-music-range-setting" type="range" name="xmasmusic_volume" min="0" max="100" step="1" value="<?php echo esc_attr( $xmasmusic_volume ); ?>" />
							<div class="christmas-music-volume-value"><span><?php echo esc_html( $xmasmusic_volume ); ?></span>%</div>
						</div>
					</div>

					<div class="christmas-music-setting">
						<label class="christmas-music-checkbox-setting">
							<input type="checkbox" name="xmasmusic_autoplay" value="true" <?php checked( 'true', $xmasmusic_autoplay ); ?> />
							<div></div>
							<span><?php echo esc_html__( 'Autoplay', 'christmas-music' ); ?></button>
						</label>
						<p class="christmas-music-setting-description"><?php echo __( 'If unchecked, audio will not play until visitor clicks the "play" button', 'christmas-music' ); ?></p>
					</div>
				</div>

				<hr>

				<h2><?php echo esc_html__( 'Styling Options', 'christmas-music' ); ?></h2>
				<hr>
				<div class="christmas-music-settings-group">		  

				<div class="christmas-music-setting">
					<p class="christmas-music-setting-label"><?php echo esc_html__( 'Choose position of the button on your website', 'christmas-music' ); ?></p>
					<div class="christmas-music-position-setting">
						<div class="christmas-music-position-row">
							<label class="christmas-music-radio-setting">
								<input type="radio" name="xmasmusic_player_position" value="top-left" <?php checked( 'top-left', $xmasmusic_player_position ); ?> />
								<div></div>
							</label>
							<label class="christmas-music-radio-setting">
								<input type="radio" name="xmasmusic_player_position" value="top-right" <?php checked( 'top-right', $xmasmusic_player_position ); ?> />
								<div></div>
							</label>
						</div>
						<div class="christmas-music-position-row">
							<label class="christmas-music-radio-setting">
								<input type="radio" name="xmasmusic_player_position" value="bottom-left" <?php checked( 'bottom-left', $xmasmusic_player_position ); ?> />
								<div></div>
							</label>
							<label class="christmas-music-radio-setting">
								<input type="radio" name="xmasmusic_player_position" value="bottom-right" <?php checked( 'bottom-right', $xmasmusic_player_position ); ?> />
								<div></div>
							</label>
						</div>
					</div>
				</div>

				<div class="christmas-music-setting">
					<p class="christmas-music-setting-label"><?php echo esc_html__( 'Choose button style', 'christmas-music' ); ?></p>
					<div class="christmas-music-radio-group">
						<label class="christmas-music-radio-setting">
							<input type="radio" name="xmasmusic_player_style" value="circle" <?php checked( 'circle', $xmasmusic_player_style ); ?> />
							<div></div>
							<span><?php echo esc_html__( 'Circle', 'christmas-music' ); ?></button>
						</label>
						<label class="christmas-music-radio-setting">
							<input type="radio" name="xmasmusic_player_style" value="square" <?php checked( 'square', $xmasmusic_player_style ); ?> />
							<div></div>
							<span><?php echo esc_html__( 'Square', 'christmas-music' ); ?></button>
						</label>
					</div>
				</div>

				<div class="christmas-music-setting">
					<label class="christmas-music-checkbox-setting">
						<input type="checkbox" name="xmasmusic_player_animation" value="true" <?php checked( 'true', $xmasmusic_player_animation ); ?> />
						<div></div>
						<span><?php echo esc_html__( 'Add soft animation (pulse) to the button', 'christmas-music' ); ?></button>
					</label>
				</div>

				<div class="christmas-music-setting" style="max-width: 100%;">
					<label class="christmas-music-color-setting">
						<div><input type="text" name="button_bg" id="button_bg" value="<?php echo esc_attr( $button_background ); ?>" data-default-color="#ff0000"/></div>
						<div class="christmas-music-setting-label"><?php echo esc_html__( 'Background color of the play/pause button', 'christmas-music' ); ?></div>
					</label>
					<label class="christmas-music-color-setting">
						<div><input type="text" name="button_color" id="button_color" value="<?php echo esc_attr( $icon_color ); ?>" data-default-color="#ffffff"/></div>
						<div class="christmas-music-setting-label"><?php echo esc_html__( 'Icon color of the play/pause button', 'christmas-music' ); ?></div>
					</label>
				</div>

				<?php submit_button(); ?>
			</form>

		</div>

	</div>

	<div class="christmas-music-settings-sidebar">
		<h3><?php echo esc_html__( 'Faq', 'christmas-music' ); ?></h3>
			<p><?php echo esc_html__( '1. You can find more info about this plugin', 'christmas-music' ); ?> <a href="https://wordpress.org/plugins/christmas-music/" target="_blank"><?php echo __( 'here', 'christmas-music' ); ?></a>.</p>
			<p><?php echo esc_html__( '2. If something doesn’t work or you’re stuck with the settings, don’t hesitate to submit your ticket', 'christmas-music' ); ?> <a href="https://wordpress.org/support/plugin/christmas-music/" target="_blank"><?php echo __( 'here', 'christmas-music' ); ?></a>.<br><?php echo __( 'We reply the same day.', 'christmas-music' ); ?></p>
			<h3><?php echo esc_html__( 'Notes', 'christmas-music' ); ?></h3>
			<p><?php echo __( 'Some browsers do not allow autoplay, it also differs for the different versions of the browsers. The strictest browser for our plugin is Mozilla Firefox, it doesn’t allow autoplay at all.<br>These browser terms change pretty often and randomly so we can’t always notice that instantly. Please bear with us.', 'christmas-music' ); // phpcs:ignore ?></p>
			<p><?php echo esc_html__( 'However, we do our best to keep this plugin compatible with the browsers as much as possible.', 'christmas-music' ); ?></p>
	</div>

</div>
