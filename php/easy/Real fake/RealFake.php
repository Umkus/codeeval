<?php

/**
 * Outputs the file size
 *
 * @see https://www.codeeval.com/open_challenges/227/
 */
class RealFake extends ChallengeAbstract
{
    /**
     * Solves the challenge
     */
    public function solve()
    {
        $filePath = Cli::getArgument(0);
        $file     = new File($filePath);
        $numbers  = $file->toArray();

        foreach ($numbers as $number) {
            $number = $this->filter($number);
            $isReal = $this->isReal($number);
            $status = $isReal ? 'Real' : 'Fake';

            print $status . PHP_EOL;
        }
    }

    /**
     * Removes non-number characters from the string
     *
     * @param string $number
     *
     * @return string
     */
    protected function filter($number)
    {
        return preg_replace('~[^0-9]~', '', $number);
    }

    /**
     * Returns true if the CC is real
     *
     * @param string $number
     *
     * @return bool
     */
    protected function isReal($number)
    {
        $integers = str_split($number);
        $sum      = 0;

        foreach ($integers as $key => $int) {
            if ($key % 2 === 0) {
                $sum += ($int * 2);
            } else {
                $sum += $int;
            }
        }

        return $sum % 10 === 0;
    }
}

