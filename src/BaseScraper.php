<?php
/**
 * Project: PhpScraperTools
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\PhpScraperTools;


class BaseScraper
{
    protected   $domain = '';
    protected   $last_url =   '';

    protected   $curl_verbose   = false;
    protected   $use_cache      = false;

    protected   $cache_dir      =   '';
    protected   $cache_prefix   =   'scrape';
    protected   $cookie_name    =   'cookie.txt';

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        // initialize cookie_name, cache_prefix, etc..
    }

    public function verboseOn()
    {
        $this->curl_verbose =   true;
    }

    public function verboseOff()
    {
        $this->curl_verbose =   false;
    }

    public function cacheOn()
    {
        $this->use_cache    =   true;
    }

    public function cacheOff()
    {
        $this->use_cache    =   false;
    }

    public function setCachePrefix($prefix)
    {
        $this->cache_prefix =   $prefix;
    }

    public function setCacheDir($cache_dir)
    {
        $this->cache_dir = $cache_dir;
    }

    protected function getCurl($url, $post = NULL, $JSON = false)
    {
        if($url[0] == '/')
            $url = "http://$this->domain$url";

        $curl = curl_init($url);
        $headers = $this->getRequestHeaders($post, $JSON);

        $this->curl_setopt($curl);

        if($this->curl_verbose) {
            curl_setopt($curl, CURLOPT_STDERR, fopen('php://output', 'w+'));
            curl_setopt($curl, CURLOPT_VERBOSE, 1);
        }
        if($post){
            $string = is_string($post) ? $post : http_build_query($post);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $string);
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);


        $cookiefile = $this->getCookieFilePath();
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookiefile);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiefile);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl);

        $this->last_url =   $url;

        curl_close($curl);
        return $response;
    }

    protected function curl_setopt($ch)
    {
        // call curl_setupopt
    }

    public function getCookieFileName()
    {
        return $this->cookie_name;
    }

    public function setCookieFileName($cookie_name)
    {
        $this->cookie_name = $cookie_name;
    }

    public function getCookieFilePath()
    {
        return sys_get_temp_dir() . DIRECTORY_SEPARATOR . $this->getCookieFileName();
    }

    public function getCacheDir()
    {
        if(!$this->cache_dir)
            $this->setCacheDir(sys_get_temp_dir() . DIRECTORY_SEPARATOR);

        return $this->cache_dir;
    }

    public function cache_get($url, $post = NULL, $JSON = false, $disable_cache = false)
    {
        if(!$this->use_cache || $disable_cache) return $this->getCurl($url, $post, $JSON);

        $cachefile = $this->getCacheDir() . $this->cache_prefix . "-" .  md5($url . print_r($post, true)) . '.html';
        if(!file_exists($cachefile))
        {
            $content = $this->getCurl($url, $post, $JSON);
            if($content)
                file_put_contents($cachefile, $content);
        }else {
            if($this->curl_verbose)
            {
                echo "Cache: $url " . print_r($post, true), "\n";
            }
            $content = file_get_contents($cachefile);
        }

        return $content;
    }

    public function getDefaultHeaders()
    {
        return array(
            'Origin: http://' . $this->domain,
//            'Accept-Encoding: gzip, deflate',
            'Accept-Language: en-US,en;q=0.8,es;q=0.6',
            'Upgrade-Insecure-Requests: 1',
            'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36',
            'Cache-Control: max-age=0',
            'Connection: keep-alive', 'Expect: '
        );
    }

    /**
     * @return array
     */
    protected function getRequestHeaders($post = NULL, $JSON = false)
    {
        $headers = $this->getDefaultHeaders();

        $is_payload =   is_string($post);

        if($JSON)
        {
            $headers[]  =   'Accept: application/json, text/javascript, */*; q=0.01';
            $headers[]  =   'X-Requested-With: XMLHttpRequest';
            if($is_payload)
                $headers[]  =   'Content-Type: application/json';
        }else{
            $headers[]  =   'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
        }

        if($this->last_url)
            $headers[]  =   'Referer: ' . $this->last_url;

        return $headers;
    }
}
