<?php

namespace Core\Output;

use Core\Output\Output;
use Core\Stream\ConsoleStream;

class ConsoleOutput extends Output
{
	protected $verbosity;
	protected $stream;

	public function __construct($verbosity = self::VERBOSITY_NORMAL)
	{
		parent::__construct(new ConsoleStream());
	}

	protected function doWrite($message)
	{
		$this->stream->writeStream($message);
	}
}