<?php

namespace Vandpibe\Emoji;

use Symfony\Component\Finder\Finder;

/**
 * @package Vandpibe
 */
class Emoji implements \IteratorAggregate, \Countable
{
    protected $initialized = false;
    protected $emojis = array();

    /**
     * @param string $path
     * @param Finder $finder
     */
    public function __construct($path = null, Finder $finder = null)
    {
        $path   = $path ?: __DIR__ . '/Resources/images';
        $finder = $finder ?: new Finder();
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

        $this->finder->files()->name('*.png');

        foreach ($this->finder->in($this->path) as $file) {
            $this->emojis[] = substr($file->getFilename(), 0, -4);
        }
    }

    /**
     * Returns the filename minus the extension which is used as a 
     * @param \SplFileInfo $file
     */
    protected function file(\SplFileInfo $file)
    {
        return substr($file->getFilename(), 0, -4);
    }
}
