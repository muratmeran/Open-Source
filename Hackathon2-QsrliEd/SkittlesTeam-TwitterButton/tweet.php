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


/*
 * @description For more info about how OAuth works, please check out the following references
 * http://oauth.net/documentation/getting-started/
 * OR
 * http://framework.zend.com/manual/en/zend.oauth.introduction.html
 */

require('config.php');
require('Zend/Oauth/Consumer.php');

//Instanciate oauth consumber object
$oauth = new Zend_Oauth_Consumer($config);

//Fetch the request token
try {
    $request_token = $oauth->getRequestToken();
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

//If access token is fetched, save it into session for future reference
//$_SESSION['request_token'] = serialize($request_token);

//Parse token
$exploded_request_token = explode('=', str_replace('&', '=', $request_token));
$oauth_token = $exploded_request_token[1];

//Form the authentication URL
$authUrl .= $oauth_token;

//Display

$page_url = $_COOKIE['skittle_page_url'];
$page_title = $_COOKIE['skittle_page_title'];
$long = $page_url;	
$tweetlink = file_get_contents('http://dev.qsr.li/api.php?token=e2cc997dedfac1cf4a917b5b0468a09a&action=shorturl&format=simple&url='. $long .'&time='. time());

$access = $oauth->getAccessToken($_GET, unserialize($_SESSION['request_token']));
$_SESSION['access_token'] = serialize($access);


// get status from callback script
$statusMessage = $page_title .' '. $tweetlink;
// get access token from session
$access_token = unserialize($_SESSION['access_token']);
// configure client
$client = $access_token->getHttpClient($config);
// set twitter's update url
$client->setUri('http://api.twitter.com/1/statuses/update.json');
// specify method
$client->setMethod(Zend_Http_Client::POST);
// set parameters
$client->setParameterPost('status', $statusMessage);
// send request
$response = $client->request();
// decode response

$result = $response->getBody();


echo 'Shokran m3allem!';