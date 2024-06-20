<?php
namespace SlimTwig;

use \SlimTwig\Data;
use \SlimTwig\Normalizer;

class Renderer {
	/**
	 * Render a text.
	 *
	 * A text can be rendered as an array or a simple string.
	 * Because of that, we have to render each variable and combine later.
	 * 
	 * @param  string        $text
	 * @param  array         $data
	 * @return string
	 */
	public static function render( string $text, array $data = [], $default = '' ): string {
		// Don't render if no variables.
		if ( ! str_contains( $text, '{{' ) ) {
			// Parse shortcodes, blocks, etc.
			return Normalizer::normalize( $text );
		}

		preg_match_all( '#{{\s*?([^}\s]+?)\s*?}}#', $text, $matches, PREG_PATTERN_ORDER );

		// One variable.
		if ( count( $matches[1] ) === 1 ) {
			$var       = $matches[1][0];
			$var_value = self::render_variable( $var, $data, $default );
			// Allows to parse post.categories as array. In case of string, allow both dynamic and static texts.
			$text = is_array( $var_value ) ? $var_value : strtr( $text, [ $var => $var_value ] );

			// Parse shortcodes, blocks, etc.
			return Normalizer::normalize( preg_replace( "/\{\{|\}\}/", "", $text ) );
			
		}

		// If many variables in the text, render each one and replace later.
		$replacements = [];
		$count        = 1;
		foreach ( $matches[1] as $var ) {
			$var_value            = self::render_variable( $var, $data, $default );
			$replacements[ $var ] = $var_value;
			if ( is_array( $var_value ) ) {
				$count = max( $count, count( $var_value ) );
			}
		}

		$return = [];
		for ( $i = 0; $i < $count; $i++ ) {
			$row_replacements = [];
			foreach ( $replacements as $var => $var_value ) {
				$replacement              = is_array( $var_value ) ? ( $var_value[ $i ] ?? '' ) : $var_value;
				$row_replacements[ $var ] = $replacement;
			}
			$return[] = strtr( $text, $row_replacements );
		}
		$text = $count === 1 ? reset( $return ) : $return;

		// Parse shortcodes, blocks, etc.
		return Normalizer::normalize( preg_replace( "/\{\{|\}\}/", "", $text ) );
	}

	/**
	 * Render variable with variables
	 *
	 * @param  string        $content
	 * @param  array         $context
	 * @return string
	 */
	private static function render_variable( string $vari, array $data, string $default ): string {
		return Data::get( $data, $vari ) ?? $default;
	}
}

