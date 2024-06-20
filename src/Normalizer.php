<?php
namespace SlimTwig;

class Normalizer {
	public static function normalize( $value ) {
		return is_array( $value ) ? array_map( [ __CLASS__, 'normalize' ], $value ) : self::process( $value );
	}

	public static function process( $text ): string {
		// Replace HTML tags with spaces.
		$text = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $text );
		$text = preg_replace( '@<[^>]*?>@s', ' ', $text );

		// Remove extra white spaces.
		$text = preg_replace( '/\s+/', ' ', $text );
		$text = trim( $text );

		return $text;
	}
}
