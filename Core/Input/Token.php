<?php

namespace Core\Input;

class Token
{
	private $key;
	private $value;
	private $acceptValue;

	public function __construct($key, $value, $acceptValue = false)
	{
		$this->key = $key;
		$this->value = $value;
		$this->acceptValue = $accaptValue;
	}

	public function getKey()
	{
		return $this->key;
	}

	public function hasValue()
	{
		if($this->value != null && $this->value != '') {
			return true;
		}
		return false;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function getAcceptValue()
	{
		return $this->acceptValue;
	}

	public function __toString()
	{
		return (string)$this->getValue();
	}
}