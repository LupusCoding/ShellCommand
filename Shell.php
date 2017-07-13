<?php

require_once('Core'.DIRECTORY_SEPARATOR.'CoreLoader.php');

$AutoLoader = new \Core\CoreLoader();
$AutoLoader->register();

$ConsoleOutput = new \Core\Output\ConsoleOutput();

$header = <<<HEADER
+----------------------------------------------+
| ShellCommand                          v0.1.0 |
+----------------------------------------------+
| Author:  LupusCoding <LupusCoding@gmail.com> |
| License: MIT @ 2017                          |
+----------------------------------------------+

HEADER;

$ConsoleOutput->writeln($header);

$Shell = new \Core\ShellCore($ConsoleOutput);
