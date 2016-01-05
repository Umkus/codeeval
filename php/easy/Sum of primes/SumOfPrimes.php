<?php

/**
 * Lowercase challenge
 *
 * @see https://www.codeeval.com/open_challenges/4/
 */
class SumOfPrimes extends ChallengeAbstract
{
    /**
     * @var int Sum of prime numbers
     */
    protected $sum = 2;

    /**
     * @var int Number of prime numbers found
     */
    protected $numbers = 1;

    /**
     * Solves the challenge
     */
    public function solve()
    {
        $number = 3;
        while ($this->numbers < 1000) {
            if ($this->isPrime($number)) {
                $this->sum += $number;
                $this->numbers++;
            }

            $number += 2;
        }

        print $this->sum . PHP_EOL;
    }

    /**
     * Returns true if the number is prime
     *
     * @author Michael Gorianskyi <michael.gorianskyi@westwing.de>
     *
     * @param int $number Number to check
     *
     * @return bool
     */
    protected function isPrime($number)
    {
        $top = (int) sqrt($number);

        for ($divider = 2; $divider <= $top; $divider++) {
            if ($number % $divider === 0) {
                return false;
            }
        }

        return true;
    }
}

