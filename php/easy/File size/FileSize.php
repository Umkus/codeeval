<?php

/**
 * Outputs the file size
 *
 * @see https://www.codeeval.com/open_challenges/20/
 */
class FileSize extends ChallengeAbstract
{
    /**
     * Solves the challenge
     */
    public function solve()
    {
        $filePath = Cli::getArgument(0);
        $file     = new File($filePath);

        print $file->getSize();
    }
}

