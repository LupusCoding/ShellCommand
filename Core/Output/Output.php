<?php

namespace Core\Output;

abstract class Output implements OutputInterface
{
	
	protected $verbosity;
	protected $stream;

	public function __construct($stream = null, $verbosity = self::VERBOSITY_NORMAL) // @Todo: implement formatter class?
	{
		$this->verbosity = (int)$verbosity;
		$this->stream = $stream ?: null; // @Todo: get stream class
	}

	public function write($message, $newline = false)
	{
		if($this->verbosity === self::VERBOSITY_SILENT) {
			return;
		}

		$newline = (string)($newline===true ? PHP_EOL : '' );

		$this->doWrite($message.$newline);
	}

	public function writeln($message)
	{
		$this->write($message, true);
	}

	public function setVerbosity($level)
	{
		$this->verbosity = (int)$level;
	}

	public function getVerbosity()
	{
		return $this->verbosity;
	}

	abstract protected function doWrite($message);
}