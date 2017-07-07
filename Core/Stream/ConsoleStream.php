<?php

namespace Core\Stream;

use \Core\Stream\StreamInterface;
use \Core\Stream\Stream;

class ConsoleStream extends Stream implements StreamInterface
{
	private $stream;
	private $direction;

	public function openStream($direction = self::STREAM_DIR_WRITE)
	{
		$this->direction = $direction;
		$this->stream = @fopen('php://stdout', $direction) ?: fopen('php://output', $direction);

		return $this;
	}

	public function readStream() {} // @Todo: how to do this???

	public function writeStream($message)
	{
		if(false === (@fwrite($this->stream, $message))) {
			throw new \RuntimeException('Unable to write output');
		}

		fflush($this->stream);
	}

	public function closeStream()
	{
		return fclose($this->stream);
	}
}