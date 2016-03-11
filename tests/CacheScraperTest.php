<?php
/**
 * Project: PhpScraperTools
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\PhpScraperTools\Tests;


use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamWrapper;
use projectivemotion\PhpScraperTools\CacheScraper;

class CacheScraperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CacheScraper
     */
    protected $scraper;
    public function setUp()
    {
        $this->scraper   =   new CacheScraper();
    }

    public function testCacheOff()
    {
        $root = vfsStream::setup();
        $this->scraper->cacheOff();
        $this->assertFalse($root->hasChildren());

        $this->scraper->cache_get('http://posttestserver.com/post.php?dir=projectivemotion/PhpScraperTools');

        $this->assertFalse($root->hasChildren());

    }

    public function testCacheOnOff()
    {
        $root = vfsStream::setup();

        $this->scraper->setCacheDir($root->url());

        $this->scraper->cacheOn();

        $this->scraper->cache_get('http://posttestserver.com/post.php?dir=projectivemotion/PhpScraperTools');

        $this->assertCount(1, $root->getChildren());

        $this->testCacheOff();

        $this->scraper->cache_get('http://posttestserver.com/post.php?dir=projectivemotion/PhpScraperTools/newurl');

        $this->assertCount(1, $root->getChildren());
    }

    public function testCacheOn()
    {
        $root = vfsStream::setup();

        $this->scraper->cacheOn();
        $this->assertFalse($root->hasChildren());

        $this->scraper->setCacheDir($root->url());

        $this->scraper->cache_get('http://posttestserver.com/post.php?dir=projectivemotion/PhpScraperTools');

        $this->assertTrue($root->hasChildren());

        $cfile = $root->getChildren();

        vfsStream::newFile($cfile[0]->getName())->at($root)->setContent('hello world.');

        $cache_result   =   $this->scraper->cache_get('http://posttestserver.com/post.php?dir=projectivemotion/PhpScraperTools');

        $this->assertEquals('hello world.', $cache_result);
    }

    public function testCacheDisable()
    {
        $root   =   vfsStream::setup();

        $this->scraper->cacheOn();

        $this->assertFalse($root->hasChildren());

        $this->scraper->cache_get('http://posttestserver.com/post.php?dir=projectivemotion/PhpScraperTools', false, false, true);

        $this->assertFalse($root->hasChildren());

    }

    public function testDefaultCacheDir()
    {
        $cacheDir   =   $this->scraper->getCacheDir();
        $this->assertFileExists($cacheDir);
    }
}