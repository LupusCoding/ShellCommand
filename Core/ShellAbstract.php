<?php

namespace Core;

use Core\Input\Token;
use Core\Input\TokenList;

abstract class ShellAbstract
{
	private $args = null;
	private $opts = null;
	private $super = null;
	private $path;
	private $call;

	public function __construct()
	{
		global $argv;

		$this->args = new TokenList();
		$this->opts = new TokenList();
		$this->super = new TokenList();

		$this->prepareGlobals($argv);
	}

	private function prepareGlobals($argv)
	{
		foreach (array_slice($argv, 1) as $parameter) {
			if (preg_match('/--/', $parameter)) {
				$this->parseArgument($parameter);

			} else if (preg_match('/-/', $parameter)) {
				$this->parseOption($parameter);

			} else if (preg_match('/:/', $parameter))  {
				$this->call = $parameter;

			}
		}
	}

	private function parseArgument($name)
	{
		if(false !== ($pos = strpos($name, '='))){
			$key = substr($name, 2, $pos-2);
			$value = substr($name, $pos+1);
		} else {
			$key = substr($name, 2);
			$value = null;
		}
		$this->args->addToken(array('key' => $key, 'value' => $value));
	}

	private function parseOption($name)
	{
		$key = substr($name, 1);
		$this->opts->addToken(array('key' => $key, 'value' => true));
	}

	public function getArg($key)
	{
		if($this->args->existToken($key)) {
			return $this->args->getToken($key);
		}
		return false;
	}

	public function getOpt($key)
	{
		if($this->opts->existToken($key)) {
			return $this->opts->getToken($key);
		}
		return false;
	}

	public function setSuper($key, $value)
	{
		$this->super->addToken(array('key' => $key, 'value' => $value));
		
		return $this;
	}

	public function getSuper($key)
	{
		if($this->super->existToken($key)) {
			return $this->super->getToken($key);
		}
		return false;
	}

	public function getCall()
	{
		return $this->call;
	}

	public function __set($key, $value)
	{
		$this->setSuper($key, $value);

		return $this;
	}

	public function __get($key)
	{
		if($this->args->existToken($key)) {
			return $this->args->getToken($key);
		}
		if($this->opts->existToken($key)) {
			return $this->opts->getToken($key);
		}
		if($this->super->existToken($key)) {
			return $this->super->getToken($key);
		}
		return false;
	}

}