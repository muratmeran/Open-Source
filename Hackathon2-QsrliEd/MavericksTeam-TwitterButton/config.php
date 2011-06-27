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
session_start();

set_include_path(implode(PATH_SEPARATOR, array(
            realpath(dirname(__FILE__) . '/library'),
            get_include_path(),
        )));

$consumerKey = 'fhvPAkFaFg84qKZOgoMnsw'; //Change this value to your consumer key value
$consumerSecret = '6m1K55ItxVCrgAfKJPp1hY6ljvpJvBzBVo57ZLHmsA'; //Change this value to your consumer secret value

$config = array(
    //This should be the callback URL twitter will redirect the user to after the authorization page
    'callbackUrl' => 'http://test.com/callback.php',
    'siteUrl' => 'http://twitter.com/oauth',
    'consumerKey' => $consumerKey,
    'consumerSecret' => $consumerSecret
);

//Twitter authorization page URL
$authUrl = 'http://twitter.com/oauth/authenticate?oauth_token=';