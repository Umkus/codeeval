<?php

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


