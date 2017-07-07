<?php

namespace Core;

interface ShellInterface
{
	public function config();

	public function run();

	public function getUsage();
}