<?php

namespace Core;

use Core\ShellAbstract;
use Core\ShellInterface;
use Core\Output\Output;
use Core\Input\Token;
use Core\Input\TokenList;

class ShellCore extends ShellAbstract
{
	private $input;
	private $output;

	private $tokens = null;

	public function __construct(Output $output)
	{
		parent::__construct();

		$this->output = $output;

		if($this->getCall() === 'core:help' || $this->getCall() === null) {
			printf($this->getUsage());
			return;
		}

		$this->configure();

		$this->execute();
	}

	private function getClass($caller=null)
	{
		$global=false;
		if($caller === null) {
			$caller = $this->getCall();
			$global = true;
		}
		if(preg_match('/:/', $caller) === false) {
			throw new \InvalidArgumentException('No action defined or not valid format. Format has to be path:to:action');
		}

		$parts = explode(':', $caller);

		$path  = implode('/', $parts).'.php';
		$class = (string)chr(92).preg_replace('/:/', chr(92), $caller);

		if($global === true) {
			$this->setSuper('_class', $class);
			$this->setSuper('_path', $path);
		} else {
			if($caller == $this->getCall()) {
				throw new \LogicException('FATAL ERROR: Recursive function call detected');
			}
		}

		return array(
				'_class' => $class, 
				'_path' => $path,
			);
	}

	private function loadAction($path=null, $class=null)
	{
		if($path === null || $class === null) {
			$path = $this->getSuper('_path')->getValue();
			$class = $this->getSuper('_class')->getValue();
		
		}

		if(!$path) {
			throw new \InvalidArgumentException('Unexpacted error while getting path.');
		}
		if(!$class) {
			throw new \InvalidArgumentException('Unexpacted error while getting class name.');
		}

		include($path);

		return new $class();
	}

	private function configure()
	{
		$this->setSuper('_server', $_SERVER['HTTP_HOST']);
		$this->setSuper('_root', $_SERVER['DOCUMENT_ROOT']);

		// @Todo: Add default configuration

		$this->tokens = new TokenList();

		$this->getClass();
	}

	private function execute()
	{
		$action = $this->loadAction(null, null);

		if(!$action) {
			throw new \LogicException('Action \''.$this->getSuper('_class').'\' does not exist.');
		}
		$action->config();
		$action->run();
	}

	public function execAction($action)
	{
		$class = $this->getClass($action);
		$action = $this->loadAction($class['_path'], $class['_class']);

		if(!$action) {
			throw new \LogicException('Action \''.$class['_class'].'\' does not exist.');
		}
		$action->config();
		$action->run();
	}

	public function getUsage()
	{
		return <<<USAGE
Usage:  php -f Shell.php [action] --[arguments] -[options]
  
[actions]
  core:help                   show this help
  
[options]
  -v                          verbose
  
[arguments]
  --debug                     activate debug output
  
USAGE;
	}
}