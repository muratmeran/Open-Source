<?php

/**
 * Twitter OAuth example
 *
 * LICENSE
 *
 * This source file is subject to the Apache 2.0 license available
 * http://www.apache.org/licenses/LICENSE-2.0.html
 *
 * @package    Twitter_Example
 * @copyright  Copyright (c) 2011 N2V. (http://www.n2v.com)
 * @license    http://www.apache.org/licenses/LICENSE-2.0.html     Apache 2.0 License
 */
session_start();

set_include_path(implode(PATH_SEPARATOR, array(
            realpath(dirname(__FILE__) . '/library'),
            get_include_path(),
        )));

$consumerKey = 'Cpktz2LBme2vp6CkyWcsPQ'; //Change this value to your consumer key value
$consumerSecret = 'oQM4MOHdtqGmI1X46qkdDiqQei1IOMvE1MfhjXlkQ8'; //Change this value to your consumer secret value

$config = array(
    //This should be the callback URL twitter will redirect the user to after the authorization page
    'callbackUrl' => 'http://localhost/hackathon/twitter/skittles/tweet.php',
    'siteUrl' => 'http://twitter.com/oauth',
    'consumerKey' => $consumerKey,
    'consumerSecret' => $consumerSecret
);

//Twitter authorization page URL
$authUrl = 'http://twitter.com/oauth/authenticate?oauth_token=';