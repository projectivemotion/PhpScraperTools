<?php
/**
 * Project: PhpScraperTools
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

require '../src/BaseScraper.php';

/**
 * Example how to send post data
 * 
 */

$Scraper    =   new \projectivemotion\PhpScraperTools\BaseScraper();

$response   =   $Scraper->cache_get('http://posttestserver.com/post.php?dir=projectivemotion/PhpScraperTools',
        // post data
      array('username' => 'amado',
            'password'  =>  'batteryhorsestaple'));

echo $response;