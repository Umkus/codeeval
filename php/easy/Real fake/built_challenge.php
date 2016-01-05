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

/**
 * File helper
 */
class File
{
    const ERR_FILE_NOT_FOUND = 'File "%s" does not exist';

    /**
     * @var resource
     */
    protected $fp;

    /**
     * @var string
     */
    protected $path;

    /**
     * Constructor
     *
     * @param string $path
     * @param bool   $create
     *
     * @throws InvalidArgumentException If the file doesn't exist
     */
    public function __construct($path, $create = false)
    {
        $this->path = $path;

        if (!$this->exists() && !$create) {
            $message = sprintf(static::ERR_FILE_NOT_FOUND, $path);
            throw new \InvalidArgumentException($message);
        }

        if ($create) {
            file_put_contents($path, '');
        }
    }

    public function getFilePointer()
    {
        return $this->fp;
    }

    public function getPath()
    {
        return $this->path;
    }

    /**
     * Returns true if file path exists
     *
     * @return bool
     */
    public function exists()
    {
        return file_exists($this->path);
    }

    /**
     * Returns file contents as an array
     *
     * @return array
     */
    public function toArray()
    {
        $lines = file($this->path);
        $lines = array_filter($lines);

        foreach ($lines as &$line) {
            $line = trim($line);
        }
        unset($line);

        return $lines;
    }

    public function read()
    {
        return file_get_contents($this->path);
    }

    public function write($string)
    {
        file_put_contents($this->path, $string);
    }

    public function concat(File $file)
    {
        return file_put_contents($this->path, $file->read());
    }

    public function getSize()
    {
        return filesize($this->path);
    }
}

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


new RealFake();
