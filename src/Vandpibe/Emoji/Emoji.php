<?php

namespace Vandpibe\Emoji;

/**
 * @package Vandpibe
 */
class Emoji implements \IteratorAggregate, \Countable
{
    protected $initialized = false;
    protected $emojis = array();

    /**
     * @param string $path
     */
    public function __construct($path = null)
    {
        $this->path   = $path ?: __DIR__ . '/Resources/images';
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function has($name)
    {
        $this->load();

        return in_array($name, $this->emojis);
    }

    /**
     * @return string[]
     */
    public function all()
    {
        $this->load();

        return $this->emojis;
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        $this->load();

        return count($this->emojis);
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        $this->load();

        return new \ArrayIterator($this->emojis);
    }

    /**
     * Runs through the given directory for png files and assumes
     * all .png are an emoji. It will only ever do this once.
     */
    protected function load()
    {
        if ($this->initialized) {
            return;
        }

        $this->initialized = true;

        foreach (glob($this->path . '/*.png') as $file) {
            $this->emojis[] = substr(basename($file), 0, -4);
        }
    }
}
