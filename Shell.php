<?php

require_once('Core'.DIRECTORY_SEPARATOR.'CoreLoader.php');

$AutoLoader = new \Core\CoreLoader();
$AutoLoader->register();

$ConsoleOutput = new \Core\Output\ConsoleOutput();

$header = <<<HEADER
+----------------------------------------------+
| Shell Core                            v0.1.0 |
+----------------------------------------------+
| Author:  LupusCoding <LupusCoding@gmail.com> |
| License: CC BY-NC 4.0                        |
+----------------------------------------------+

HEADER;

$ConsoleOutput->writeln($header);

$Shell = new \Core\ShellCore($ConsoleOutput);
