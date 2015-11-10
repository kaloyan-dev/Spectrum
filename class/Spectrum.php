<?php

class Spectrum {
	private static $schemes = array();

	public function create( $name = false, $base = false, $highlight = false, $notification = false, $action = false ) {
		if ( ! $name || ! $base || ! $highlight || ! $notification || ! $action ) {
			return;
		}

		$title    = sanitize_title( $name );
		$filename = SPECTRUM_SCHEME_DIR . $title . '.css';

		self::$schemes[$title] = array(
			'name'          => $name,
			'base'          => $base,
			'highlight'     => $highlight,
			'notification'  => $notification,
			'action'        => $action,
		);

		if ( ! file_exists( $filename ) ) {
			ob_start();
			require( SPECTRUM_DIR . '/spectrum.css' );
			$output  = ob_get_clean();

			$search  = array( '{base}', '{highlight}', '{notification}', '{action}' );
			$replace = array( $base, $highlight, $notification, $action );

			$output  = str_replace( $search, $replace, $output );

			file_put_contents( $filename, $output );
		}

		update_option( 'spectrum_color_schemes', self::$schemes );
	}
}