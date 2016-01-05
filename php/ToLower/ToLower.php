<?php

/**
 * Lowercase challenge
 *
 * @see https://www.codeeval.com/open_challenges/20/
 */
class ToLower extends ChallengeAbstract
{
    /**
     * Solves the challenge
     */
    public function solve()
    {
        $filePath = Cli::getArgument(0);
        $file     = new File($filePath);
        $rows     = $file->toArray();

        foreach ($rows as &$row) {
            $row = strtolower($row);
        }
        unset($row);

        $rows = implode(PHP_EOL, $rows);

        print $rows;
    }
}

