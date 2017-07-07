<?php

namespace Core\Stream;

use Core\Stream\StreamInterface;

abstract class Stream implements StreamInterface
{
	const STREAM_DIR_READ='r';
	const STREAM_DIR_WRITE='b';
	const STREAM_DIR_BOTH='rw';

	private $stream;
	private $direction;

	public function __construct($direction = self::STREAM_DIR_WRITE)
	{
		$this->openStream($direction);
	}

	abstract public function openStream($direction);

	abstract public function readStream();

	abstract public function writeStream($message);

	abstract public function closeStream();
}