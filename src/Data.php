<?php
namespace SlimTwig;

class Data {
	/**
	 * Render content with variables
	 *
	 * @param  string        $content
	 * @param  array         $context
	 * @return string
	 */
	public static function render( $content, array $context = [] ): string {
		foreach( $context as $key => $value ) {
			$new_value = htmlspecialchars( $value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' );
			$content = preg_replace('/\{\{' . $key . '\}\}/', $new_value, $content);
			$content = preg_replace('/\{\{ ' . $key . ' \}\}/', $new_value, $content);
		}

		return $content;
	}

	/**
	 * Get an item from an array or object using "dot" notation.
	 * Similar to data_get() function in Laravel.
	 *
	 * @link https://github.com/laravel/framework/blob/ae63a5b968f764ad0c5ecd86669bcc5fb8be90f7/src/Illuminate/Collections/helpers.php#L46
	 *
	 * @param  array|object  $target
	 * @param  string        $key
	 * @param  mixed         $default
	 * @return mixed
	 */
	public static function get( $target, string $key, $default = null ) {
		$key = explode( '.', $key );

		foreach ( $key as $segment ) {
			if ( is_array( $target ) && isset( $target[ $segment ] ) ) {
				$target = $target[ $segment ];
			} elseif ( is_object( $target ) && isset( $target->$segment ) ) {
				$target = $target->$segment;
			} else {
				return $default;
			}
		}

		return $target;
	}
}

