<?php
/**
 * Twitter Button Hackathon
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license available
 * http://en.wikipedia.org/wiki/BSD_licenses
 * @Author		Rakan Alhneiti, Abdelrahman Salem
 * @package    Twitter_Example
 * @copyright  Copyright (c) 2011 N2V. (http://www.n2v.com)
 * @license    http://en.wikipedia.org/wiki/BSD_licenses     new BSD license
 */
    $defaultShortener = "http://dev.qsr.li/api.php?token=5c917af867d5a0ba5f0a2bf2aa8792b6&action=shorturl&format=simple&url=";
    
    $url = filter_var($_GET['url'], FILTER_SANITIZE_URL);
    $shortener = filter_var($_GET['shortener'], FILTER_SANITIZE_URL);
    
    if($shortener == "default") $shortener = $defaultShortener;
    
    $shortUrl = file_get_contents($shortener.$url);
    
    print $shortUrl;