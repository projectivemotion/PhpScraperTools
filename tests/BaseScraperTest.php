<?php
/**
 * Project: PhpScraperTools
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\PhpScraperTools\Tests;
use projectivemotion\PhpScraperTools\BaseScraper;


/**
 * For backwards compatibility
 *
 * Class BaseScraperTest
 * @package projectivemotion\BaseScraper\Tests
 */
class BaseScraperTest extends CacheScraperTest
{
    /**
     * @var BaseScraper
     */
    protected $scraper;

    public function setUp()
    {
        $this->scraper  =   new BaseScraper();
    }
}
