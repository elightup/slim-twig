<?php
namespace App;

class SlimTwig {

	/**
	 * Get array element value with dot notation.
	 */
	public static function get( $array, $key, $default = '' ) {
		if ( is_null( $key ) ) {
			return $array;
		}

		if( ! strpos( $key, '.' ) !== false) {
			return ( string )$array[ $key ] ?? $default;
		}

		$keys = explode( '.', $key );
		foreach ( $keys as $key ) {
			if ( isset( $array[ $key ] ) ) {
				$array = $array[ $key ];
			}
			if ( is_object( $array[ $key ] ) ) {
				$array = $array->$key;
			}

			return default;
		}

		return $array;
	}

}

