<?php

namespace Core\Input;

use Core\Input\Token;

class TokenList
{
	private $length = 0;
	private $tokens = array();

	public function addToken($token)
	{
		if(is_array($token)) {
			if( !in_array('key', array_keys($token)) || !in_array('value', array_keys($token)) ) {
				throw new \InvalidArgumentException('Missing parameters or parameters not valid.');
			}
			if(!in_array('accept_value', $token)) {
				$token['accept_value'] = false;
			}
			$token = new Token($token['key'], $token['value'], $token['accept_value']);
		}

		if(!$token instanceof Token) {
			throw new \InvalidArgumentException('Token must be instance of Token class.');
		}

		$this->tokens[$token->getKey()] = $token;
		$this->length++;

		return $this;
	}

	public function getToken($key)
	{
		if($this->existToken($key)) {
			return $this->tokens[$key];
		}
		return null;
	}

	public function removeToken($key)
	{
		if($this->existToken($key)) {
			unset($this->tokens[$key]);
			$this->length--;
		}

		return $this;
	}

	public function existToken($key)
	{
		if( in_array($key, array_keys($this->tokens)) ) {
			return true;
		}
		return false;
	}
}