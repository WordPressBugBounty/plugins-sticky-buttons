<?php

namespace StickyButtons\Publish;

defined( 'ABSPATH' ) || exit;

class Singleton {
	private static $instance;
	private array $value = [];

	private function __construct() {}

	public static function getInstance() {
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	public function setValue($key, $value) {
		$this->value[$key] = $value;
	}

	public function getValue(): array {
		return $this->value;
	}

	public function hasKey( $key ) : bool {
		return array_key_exists( $key, $this->value );
	}

	public function getValueByKey($key) {
		if($this->hasKey($key)) {
			return $this->value[$key];
		}

		// Return null or throw an exception if the key does not exist
		return null;
	}
}