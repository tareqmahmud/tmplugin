<?php

namespace TMPlugin\Traits;

/**
 * Trait FormError
 *
 * @package TMPlugin\Traits
 */
trait FormError {
	/**
	 * Property to hold all the errors
	 *
	 * @var array
	 */
	public $errors = [];

	/**
	 * Check is there any errors available or not based on the key
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	public function has_error( $key ) {
		return isset( $this->errors[ $key ] );
	}


	/**
	 * Get the error message based on the key
	 *
	 * @param $key
	 *
	 * @return false|mixed
	 */
	public function get_error( $key ) {
		if ( isset( $this->errors[ $key ] ) ) {
			return $this->errors[ $key ];
		}

		return false;
	}
}
