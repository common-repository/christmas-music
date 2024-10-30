<?php

/**
 * Adding scripts for admin side
 *
 * @param string $hook Hook name.
 * @return void
 */
function christmas_music_enqueue_admin_scripts( $hook ) {
	if ( 'toplevel_page_xmas-music-settings' !== $hook ) {
		return;
	}

	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_media();
	wp_enqueue_script( 'christmas-music-admin-wp-helpers', XMAS_MUSIC_DIR_URL . 'admin/js/christmas-music-admin-wp-helpers.js', array( 'jquery', 'wp-color-picker' ), XMAS_MUSIC_VERSION, true );

	wp_enqueue_style( 'christmas-music-admin-styles', XMAS_MUSIC_DIR_URL . 'admin/css/christmas-music-admin.css', array(), XMAS_MUSIC_VERSION );
	wp_enqueue_script( 'christmas-music-admin-scripts', XMAS_MUSIC_DIR_URL . 'admin/js/christmas-music-admin.js', array(), XMAS_MUSIC_VERSION, true );
}

add_action( 'admin_enqueue_scripts', 'christmas_music_enqueue_admin_scripts' );


/**
 * Register settings
 */
function christmas_music_register_settings() {
	register_setting( 'xmasmusic-plugin-settings-group', 'xmasmusic_enable_tooltip' );
	register_setting( 'xmasmusic-plugin-settings-group', 'xmasmusic_file' );
	register_setting( 'xmasmusic-plugin-settings-group', 'default_play' );
	register_setting( 'xmasmusic-plugin-settings-group', 'xmasmusic_volume' );
	register_setting( 'xmasmusic-plugin-settings-group', 'xmasmusic_autoplay' );
	register_setting( 'xmasmusic-plugin-settings-group', 'xmasmusic_player_position' );
	register_setting( 'xmasmusic-plugin-settings-group', 'xmasmusic_player_style' );
	register_setting( 'xmasmusic-plugin-settings-group', 'xmasmusic_player_animation' );
	register_setting( 'xmasmusic-plugin-settings-group', 'button_bg' );
	register_setting( 'xmasmusic-plugin-settings-group', 'button_color' );
}

add_action( 'admin_init', 'christmas_music_register_settings' );


/**
 * Create options page
 */
function christmas_music_admin_menu() {
	add_menu_page( __( 'Christmas Music Settings', 'christmas-music' ), __( 'Christmas Music', 'christmas-music' ), 'manage_options', 'xmas-music-settings', 'christmas_music_settings_page', XMAS_MUSIC_DIR_URL . 'admin/images/xmas.svg' );
}

add_action( 'admin_menu', 'christmas_music_admin_menu' );


/**
 * Settings page template
 */
function christmas_music_settings_page() {
	ob_start();
	include 'partials/christmas-music-admin-display.php';
	echo ob_get_clean(); // phpcs:ignore
}


/**
 * Add plugin settings link
 *
 * @param array $xmaxmusic_links Plugin links.
 * @return array
 */
function christmas_music_settings_link( $xmaxmusic_links ) {
	$xmasmusic_settings_link = '<a href="admin.php?page=xmas-music-settings">' . __( 'Settings', 'christmas-music' ) . '</a>';
	array_unshift( $xmaxmusic_links, $xmasmusic_settings_link );

	return $xmaxmusic_links;
}

add_filter( 'plugin_action_links_' . XMAS_MUSIC_BASENAME, 'christmas_music_settings_link' );


/**
 * Create metabox for singular
 */
function christmas_music_meta_box_add() {
	$xmasmusic_types = get_post_types();
	foreach ( $xmasmusic_types as $xmasmusic_type ) {
		add_meta_box( 'xmasmusic-meta-box-id', sprintf( __( 'Christmas Music Settings', 'christmas-music' ) ), 'christmas_music_meta_box_cb', $xmasmusic_type, 'side', 'high' );
	}
}

add_action( 'add_meta_boxes', 'christmas_music_meta_box_add' );


/**
 * Metabox content
 *
 * @param WP_Post $post Post object.
 * @return void
 */
function christmas_music_meta_box_cb( $post ) {
	$xmasmusic_values = get_post_custom( $post->ID );
	$xmasmusic_check  = isset( $xmasmusic_values['xmasmusic_meta_box_check'] ) ? esc_attr( $xmasmusic_values['xmasmusic_meta_box_check'][0] ) : '';
	wp_nonce_field( 'xmasmusic_meta_box_nonce', 'meta_box_nonce' );
	?>
	<p>
		<input type="checkbox" name="xmasmusic_meta_box_check" id="xmasmusic_meta_box_check" <?php checked( $xmasmusic_check, 'on' ); ?> />
		<label for="xmasmusic_meta_box_check"><?php printf( __( 'Play Christmas music on this page', 'christmas-music' ) ); ?></label><br><br>
		<span style="display: block; font-style: italic; font-size: 12px;"><?php printf( __( '* affecting only if globally ', 'christmas-music' ) ); ?><a href="admin.php?page=xmas-music-settings" target="_blank"><?php printf( __( 'disabled here', 'christmas-music' ) ); ?></a></span>
	</p>
	<?php
}


/**
 * Save meta box data
 *
 * @param int $post_id Post ID.
 * @return void
 */
function christmas_music_meta_box_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! isset( $_POST['meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['meta_box_nonce'], 'xmasmusic_meta_box_nonce' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['xmasmusic_meta_box_check'] ) && $_POST['xmasmusic_meta_box_check'] ) {
		add_post_meta( $post_id, 'xmasmusic_meta_box_check', 'on', true );
	} else {
		delete_post_meta( $post_id, 'xmasmusic_meta_box_check' );
	}
}

add_action( 'save_post', 'christmas_music_meta_box_save' );
