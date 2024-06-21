<?php
namespace SlimTwig;

class Renderer {
	/**
	 * Render a text with variables like {{ name.first_name }} {{ post.title }}.
	 * 
	 */
	public static function render( string $text, $data ): string {
		// Don't render if no variables.
		if ( ! str_contains( $text, '{{' ) ) {
			// Parse shortcodes, blocks, etc.
			return Normalizer::normalize( $text );
		}

		preg_match_all( '#{{\s*?([^}\s]+?)\s*?}}#', $text, $matches, PREG_PATTERN_ORDER );
		foreach ( $matches[1] as $key => $variable ) {
			$value = ( string )self::render_variable( $variable, $data );
			$text = str_replace( $matches[0][ $key ], $value, $text);
		}

		return Normalizer::normalize( $text );
	}

	private static function render_variable( string $variable, $data ): string {
		return Data::get( $data, $variable, '' );
	}
}

