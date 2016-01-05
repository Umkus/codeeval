<?php

/**
 * Class ChallengeAbstract
 */
abstract class ChallengeAbstract
{
    /**
     * ChallengeAbstract constructor.
     */
    public function __construct()
    {
        if (!Cli::isCli()) {
            throw new \DomainException('This challenge is supposed to be run from cli');
        }

        $this->solve();
    }

    /**
     * Solves the challenge, a challenge entrypoint
     *
     * @return mixed
     */
    abstract public function solve();
}
