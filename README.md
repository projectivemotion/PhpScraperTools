# php-scraper-tools
PHP Curl Wrapper. Written for use in web scraping.

[![Build Status](https://travis-ci.org/projectivemotion/php-scraper-tools.svg?branch=master)](https://travis-ci.org/projectivemotion/php-scraper-tools)

## Installation
> composer require projectivemotion/php-scraper-tools

## Features
* Quick and easy cookie, cache, and verbose configuration
  * `->verboseOn()`
  * `->verboseOff()`
  * `->cacheOn()`
  * `->cacheOff()`
  * `->setCookieFileName()`
* Automatic referrer header
* Easy ajax posts
  * `->getCurl('/ajax.php', ['q' => 'search string'], TRUE)`
* Customizable headers
* Easy POST/GET
  * `->getCurl('/login.php', ['username' => 'myuser', 'pass' => 'mypass'])`
* Enabling cache will save responses to filesystem so you can analyze them.



      $scraper = new CacheScraper();
      
      $scraper->setCacheDir('./');
      
      $scraper->cacheOn();
      
      $response = $scraper->get_cache('/mypage.php', ['search' => 'somethingtosearchfor']);

## Usage
See `demo/` directory


## License
The MIT License (MIT)

Copyright (c) 2016  Amado Martinez

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
