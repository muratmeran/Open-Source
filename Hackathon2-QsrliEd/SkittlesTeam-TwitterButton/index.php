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
$_SESSION['request_token'] = serialize($request_token);

//Parse token
$exploded_request_token = explode('=', str_replace('&', '=', $request_token));
$oauth_token = $exploded_request_token[1];

//Form the authentication URL
$authUrl .= $oauth_token;

//Display
echo "<a href='$authUrl'>Click here to authorize this app with twitter</a>";

							 /*
// get status from callback script
$statusMessage ='test';
// get access token from session
$access_token = unserialize($oauth_token);
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
$data = Zend_Json::decode($response->getBody());
$result = $response->getBody();
// check if status was updated
if (isset($data->text)) {
	// status updated 
    $result = 'profile updated';
}else{
// failed to update status 
$result='failed to update';
}

echo $result;*/