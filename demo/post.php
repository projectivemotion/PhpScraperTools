<?php
/**
 * Project: PhpScraperTools
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

// copied this from doctrine's bin/doctrine.php
$autoload_files = array( __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../../autoload.php');

foreach($autoload_files as $autoload_file)
{
    if(!file_exists($autoload_file)) continue;
    require_once $autoload_file;
}
// end autoloader finder

/**
 * Example how to send post data
 * 
 */

$Scraper    =   new \projectivemotion\PhpScraperTools\CacheScraper();

$response   =   $Scraper->cache_get('http://posttestserver.com/post.php?dir=projectivemotion/PhpScraperTools',
        // post data
      array('username' => 'amado',
            'password'  =>  'batteryhorsestaple'));

echo $response;


if($argc < 2)
{
    return;
}

echo "\nTesting Proxy\n\n";
$proxyinfo  =   explode(':', $argv[1]);

// test a proxy
$Scraper    =   new \projectivemotion\PhpScraperTools\SuperScraper();
$Scraper->setProxy($proxyinfo[0], $proxyinfo[1]);

$response   =   $Scraper->Get('https://wtfismyip.com/text');

echo "Proxy IP: ", $response;