<?php

/**
 * Cli helper
 */
class Cli
{
    const ERR_UNDEFINED_ARGC = 'Please enable "register_argc_argv"';

    const ERR_OUT_OF_RANGE   = 'Requested a parameter index "%s" that does not exist';

    /**
     * Returns true if the script is invoked through the cli
     *
     * @return bool
     */
    public static function isCli()
    {
        return PHP_SAPI === 'cli';
    }

    /**
     * Returns all passed arguments, excluding the script name
     *
     * @throws RuntimeException If the $argv is undefined
     *
     * @return array
     */
    public static function getArguments()
    {
        global $argv;

        if (is_null($argv)) {
            throw new \RuntimeException(static::ERR_UNDEFINED_ARGC);
        }

        $arguments = array_slice($argv, 1);

        return $arguments;
    }

    /**
     * Returns an argument by index
     *
     * @param int $index Argument index
     *
     * @throws OutOfRangeException If the argument index is not present
     *
     * @return string
     */
    public static function getArgument($index)
    {
        $index     = (int) $index;
        $arguments = static::getArguments();

        if (!array_key_exists($index, $arguments)) {
            $message = sprintf(static::ERR_OUT_OF_RANGE, $index);
            throw new \OutOfRangeException($message);
        }

        return $arguments[$index];
    }
}

