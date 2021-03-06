<?php

namespace Kraken\_Module\Filesystem\_Partial\Filesystem;

use Kraken\Filesystem\Filesystem;
use Kraken\Filesystem\FilesystemInterface;
use Kraken\Test\TModule;
use Kraken\Throwable\Exception\Runtime\WriteException;

trait FsApiSetPrivatePartial
{
    /**
     * @see TestCase::getTest
     * @return TModule
     */
    abstract public function getTest();

    /**
     * @return string
     */
    abstract public function getPrefix();

    /**
     * @param string $path
     * @param null $replace
     * @param string $with
     * @return string
     */
    abstract public function getPrefixed($path, $replace = null, $with = '');

    /**
     * @param string $path
     * @param null $replace
     * @param string $with
     * @return string
     */
    abstract public function getPath($path, $replace = null, $with = '');

    /**
     * @param string $path
     * @param string $typeFilter
     * @param bool $recursive
     * @param string $filePattern
     * @return array
     */
    abstract public function getPathData($path = '', $typeFilter = '', $recursive = false, $filePattern = '');

    /**
     * @return FilesystemInterface
     */
    abstract public function createFilesystem();

    /**
     *
     */
    public function testApiSetPrivate_SetsPrivate_WhenFileDoesExist_WhenNodeIsPublic()
    {
        $test = $this->getTest();
        $fs = $this->createFilesystem();

        $test->assertEquals(Filesystem::VISIBILITY_PUBLIC, $fs->getVisibility($this->getPrefixed('FILE_A')));
        $fs->setPrivate($this->getPrefixed('FILE_A'));
        $test->assertEquals(Filesystem::VISIBILITY_PRIVATE, $fs->getVisibility($this->getPrefixed('FILE_A')));
    }

    /**
     *
     */
    public function testApiSetPrivate_SetsPrivate_WhenFileDoesExist_WhenNodeIsPrivate()
    {
        $test = $this->getTest();
        $fs = $this->createFilesystem();

        $test->assertEquals(Filesystem::VISIBILITY_PRIVATE, $fs->getVisibility($this->getPrefixed('FILE_D')));
        $fs->setPrivate($this->getPrefixed('FILE_D'));
        $test->assertEquals(Filesystem::VISIBILITY_PRIVATE, $fs->getVisibility($this->getPrefixed('FILE_D')));
    }

    /**
     *
     */
    public function testApiSetPrivate_SetsPrivate_WhenDirectoryDoesExist_WhenNodeIsPublic()
    {
        $test = $this->getTest();
        $fs = $this->createFilesystem();

        $test->assertEquals(Filesystem::VISIBILITY_PUBLIC, $fs->getVisibility($this->getPrefixed('DIR_A')));
        $fs->setPrivate($this->getPrefixed('DIR_A'));
        $test->assertEquals(Filesystem::VISIBILITY_PRIVATE, $fs->getVisibility($this->getPrefixed('DIR_A')));
    }

    /**
     *
     */
    public function testApiSetPrivate_SetsPrivate_WhenDirectoryDoesExist_WhenNodeIsPrivate()
    {
        $test = $this->getTest();
        $fs = $this->createFilesystem();

        $test->assertEquals(Filesystem::VISIBILITY_PRIVATE, $fs->getVisibility($this->getPrefixed('DIR_D')));
        $fs->setPrivate($this->getPrefixed('DIR_D'));
        $test->assertEquals(Filesystem::VISIBILITY_PRIVATE, $fs->getVisibility($this->getPrefixed('DIR_D')));
    }

    /**
     *
     */
    public function testApiSetPrivate_ThrowsException_WhenPathDoesNotExist()
    {
        $test = $this->getTest();
        $fs = $this->createFilesystem();

        $test->setExpectedException(WriteException::class);

        $fs->setPrivate($this->getPrefixed('FILE_NULL'));
    }
}
