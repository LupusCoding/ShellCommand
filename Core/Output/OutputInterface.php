<?php

namespace Core\Output;

interface OutputInterface
{
	const VERBOSITY_SILENT  = 1;
	const VERBOSITY_NORMAL  = 2;
	const VERBOSITY_VERBOSE = 3;
	const VERBOSITY_DEBUG   = 4;

	public function write($message, $newline = false);

	public function writeln($message);

	public function setVerbosity($level);

	public function getVerbosity();

}