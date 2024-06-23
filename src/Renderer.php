<?php
namespace SlimTwig;

class Renderer {
	public static function render( string $text, $data ): string {
		// Don't render if no variables.
		if ( ! str_contains( $text, '{{' ) ) {
			return $text;
		}

		preg_match_all( '#{{\s*?([^}\s]+?)\s*?}}#', $text, $matches, PREG_PATTERN_ORDER );
		foreach ( $matches[1] as $key => $variable ) {
			$value = ( string )self::render_variable( $variable, $data );
			$text = str_replace( $matches[0][ $key ], $value, $text);
		}
		return $text;
	}

	private static function render_variable( string $variable, $data ) {
		return Data::get( $data, $variable, '' );
	}
}

