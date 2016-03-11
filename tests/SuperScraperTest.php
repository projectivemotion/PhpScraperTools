<?php
/**
 * Project: PhpScraperTools
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\PhpScraperTools\Tests;


use org\bovigo\vfs\vfsStream;
use projectivemotion\PhpScraperTools\SuperScraper;

class SuperScraperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SuperScraper
     */
    protected $scraper;

    protected function setUp()
    {
        $this->scraper  =   new SuperScraper();
    }

    public function testCookie()
    {
        // cannot use vfsstream with curl.. :(
        $cookiesfile    =   sys_get_temp_dir() . DIRECTORY_SEPARATOR . md5(microtime(true)) . '.txt';

        $this->assertFileNotExists($cookiesfile);

        $this->scraper->setCookieFileName($cookiesfile);
        $this->scraper->getCurl('https://www.bing.com/');

        $this->assertFileExists($cookiesfile);

        unlink($cookiesfile);
    }

    public function testJsonHeaders()
    {
        $headers    =   implode("\n", $this->scraper->getRequestHeaders(NULL, true));
        $this->assertRegExp('#X-Requested-With:#', $headers);


        $headers    =   implode("\n", $this->scraper->getRequestHeaders('{json}', true));
        $this->assertRegExp('#application/json#', $headers);
    }

    public function testCookieFilename()
    {
        $this->assertEquals($this->scraper->getCookieFileName(), $this->scraper->getCookieFilePath());
    }
    
}