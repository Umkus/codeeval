<?php

/**
 * Challenge builder for CodeEval
 *
 * Since CodeEval only accepts a single file - concat them all together!
 * Run this file from within the directory with the challenge.php file
 */

require_once __DIR__ . '/File.php';
require_once __DIR__ . '/Cli.php';

copy('challenge.php', 'built_challenge.php');

$challengeFile = new File('built_challenge.php');
$content       = $challengeFile->read();

preg_match_all("~^.*'([^']+\\.php)'.*$~iUm", $content, $found, PREG_SET_ORDER);

if (!$found) {
    die('No files found to require');
}

foreach ($found as $match) {
    list($statement, $path) = $match;

    $file        = new File($path);
    $fileContent = $file->read();
    $fileContent = str_replace('<?php', '', $fileContent);
    $fileContent = trim($fileContent) . PHP_EOL;
    $content     = str_replace($statement, $fileContent, $content);
}

$challengeFile->write($content);



