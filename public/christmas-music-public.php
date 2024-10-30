<?php

/**
 * Adding scripts for public side
 */
function christmas_music_enqueue_public_scripts() {
	wp_enqueue_style( 'christmas-music-public-styles', XMAS_MUSIC_DIR_URL . 'public/css/christmas-music-public.css', array(), XMAS_MUSIC_VERSION );
	wp_enqueue_script( 'christmas-music-public-cookie', XMAS_MUSIC_DIR_URL . 'public/js/js.cookie.min.js', array(), XMAS_MUSIC_VERSION, true );
	wp_enqueue_script( 'christmas-music-public-scripts', XMAS_MUSIC_DIR_URL . 'public/js/christmas-music-public.js', array( 'christmas-music-public-cookie' ), XMAS_MUSIC_VERSION, true );

	// Enable xmas mood tooltip.
	$xmasmusic_enable_tooltip = get_option( 'xmasmusic_enable_tooltip' ) ? sanitize_text_field( get_option( 'xmasmusic_enable_tooltip' ) ) : '';

	// Audio file.
	$xmasmusic_file     = intval( get_option( 'xmasmusic_file' ) );
	$xmasmusic_file_url = $xmasmusic_file ? wp_get_attachment_url( $xmasmusic_file ) : XMAS_MUSIC_DIR_URL . 'public/audio/christmas-music.mp3';

	// Volume.
	$xmasmusic_volume = get_option( 'xmasmusic_volume' ) ? intval( get_option( 'xmasmusic_volume' ) ) : 30;

	// Autoplay.
	$xmasmusic_autoplay = sanitize_text_field( get_option( 'xmasmusic_autoplay', 'true' ) );

	// Player position.
	$xmasmusic_player_position = get_option( 'xmasmusic_player_position' ) ? sanitize_text_field( get_option( 'xmasmusic_player_position' ) ) : 'bottom-right';

	// Player style.
	$xmasmusic_player_style = get_option( 'xmasmusic_player_style' ) ? sanitize_text_field( get_option( 'xmasmusic_player_style' ) ) : 'circle';

	// Enable player animation.
	$xmasmusic_player_animation = get_option( 'xmasmusic_player_animation' ) ? sanitize_text_field( get_option( 'xmasmusic_player_animation' ) ) : '';

	// Background color of player.
	$button_background = get_option( 'button_bg' ) ? sanitize_text_field( get_option( 'button_bg' ) ) : '#ff0000';

	// Color of play/pause icon.
	$icon_color = get_option( 'button_color' ) ? sanitize_text_field( get_option( 'button_color' ) ) : '#ffffff';

	$xmasmusic_settings = array(
		'enableTooltip'    => $xmasmusic_enable_tooltip,
		'audioFileUrl'     => $xmasmusic_file_url,
		'volume'           => $xmasmusic_volume,
		'autoplay'         => $xmasmusic_autoplay,
		'position'         => $xmasmusic_player_position,
		'style'            => $xmasmusic_player_style,
		'animation'        => $xmasmusic_player_animation,
		'buttonBackground' => $button_background,
		'iconColor'        => $icon_color,
	);

	wp_localize_script( 'christmas-music-public-scripts', 'xmasMusicSettings', $xmasmusic_settings );
}


/**
 * Global options condition
 */
function christmas_music_global_setting() {
	if ( filter_var( get_option( 'default_play', 'true' ), FILTER_VALIDATE_BOOLEAN ) === true ) {
		add_action( 'wp_enqueue_scripts', 'christmas_music_enqueue_public_scripts' );
	}
}

add_action( 'init', 'christmas_music_global_setting' );


/**
 * Singular options condition
 */
function christmas_music_post_setting() {
	global $post;

	if ( $post ) {
		$xmasmusic_post_meta = get_post_meta( $post->ID, 'xmasmusic_meta_box_check', true );

		if ( 'on' === $xmasmusic_post_meta && is_singular() ) {
			add_action( 'wp_enqueue_scripts', 'christmas_music_enqueue_public_scripts' );
		}
	}
}

add_action( 'wp', 'christmas_music_post_setting' );
