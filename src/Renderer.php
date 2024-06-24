<?php
namespace SlimTwig;

class Renderer {
	public static function render( string $text, $data ): string {
		preg_match_all( '#{{\s*?([^}\s]+?)\s*?}}#', $text, $matches, PREG_SET_ORDER );
		foreach ( $matches as $variable ) {
			$value = (string) self::render_variable( $variable[1], $data );
			$text  = str_replace( $variable[0], $value, $text );
		}
		return $text;
	}

	private static function render_variable( string $variable, $data ) {
		return Data::get( $data, $variable, '' );
	}
}
