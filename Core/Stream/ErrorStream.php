<?php

namespace Core\Stream;

use \Core\Stream\StreamInterface;
use \Core\Stream\Stream;

class ErrorStream extends Stream implements StreamInterface
{
	private $stream;
	private $direction;

	public function openStream($direction = self::STREAM_DIR_READ)
	{
		$this->direction = $direction;
		if(false === ($this->stream = @fopen('php://stderr', $direction))) {
			throw new \RuntimeException('Unable to open stream');
		}

		return $this;
	}

	public function readStream() {
		return stream_get_contents($this->stream);
	}

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