<?php

namespace Core\Stream;

interface StreamInterface
{
	public function openStream($direction);

	public function readStream();

	public function writeStream($message);

	public function closeStream();
}
