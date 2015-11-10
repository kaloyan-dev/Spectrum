<?php

! defined( 'SPECTRUM_DIR' )        ? define( 'SPECTRUM_DIR', dirname( __FILE__ ) ) : '';
! defined( 'SPECTRUM_SCHEME_DIR' ) ? define( 'SPECTRUM_SCHEME_DIR', dirname( __FILE__ ) . '\\schemes\\' ) : '';
! defined( 'SPECTRUM_URI' )        ? define( 'SPECTRUM_DIR', str_replace( dirname( __FILE__ ), ABSPATH, SPECTRUM_DIR ) ) : '';
! defined( 'SPECTRUM_SCHEME_URI' ) ? define( 'SPECTRUM_SCHEME_DIR', SPECTRUM_URI . '/schemes/' ) : '';

include_once( 'class/Spectrum.php' );

if ( ! is_admin() ) {
	return;
}

function spectrum_notice() {
	if ( ! is_writable( SPECTRUM_SCHEME_DIR ) ): ?>
		<div class="error">
			<p><?php _e( "Spectrum's CSS directory is not writable. Color schemes can't currently be saved.", "spectrum" ); ?></p>
		</div>
	<?php endif;
}
add_action( 'admin_notices', 'spectrum_notice' );

delete_option( 'spectrum_color_schemes' );

function spectrum_color_schemes() {
	
	# Fix paths for Windows
	$content_url  = untrailingslashit( dirname( dirname( get_stylesheet_directory_uri() ) ) );
	$content_dir  = untrailingslashit( dirname( dirname( get_stylesheet_directory() ) ) );
	$spectrum_dir = str_replace( '\\', '/', SPECTRUM_DIR );
	$content_dir  = str_replace( '\\', '/', $content_dir );
	$url          = str_replace( $content_dir, $content_url, $spectrum_dir );
	$schemes_url  = $url . '/schemes/';

	$schemes = get_option( 'spectrum_color_schemes' );

	if ( $schemes ) {
		foreach ( $schemes as $colors ) {

			$name         = $colors['name'];
			$title        = sanitize_title( $name );
			$base         = $colors['base'];
			$highlight    = $colors['highlight'];
			$notification = $colors['notification'];
			$action       = $colors['action'];

			wp_admin_css_color( $title, $name,
				$schemes_url . $title . '.css',
				array( $base, $highlight, $notification, $action )
			);
		}
	}
}

if ( is_writable( SPECTRUM_SCHEME_DIR ) ) {
	add_action( 'admin_init', 'spectrum_color_schemes' );
}