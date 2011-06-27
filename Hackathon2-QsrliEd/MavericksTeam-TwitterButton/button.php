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


/*
 * @description For more info about how OAuth works, please check out the following references
 * http://oauth.net/documentation/getting-started/
 * OR
 * http://framework.zend.com/manual/en/zend.oauth.introduction.html
 */

require('config.php');
require('Zend/Oauth/Consumer.php');
require('Zend/Json.php');


$title = filter_var($_GET['title'], FILTER_SANITIZE_STRING);
$url = filter_var($_GET['url'], FILTER_SANITIZE_URL);
$via = filter_var($_GET['via'], FILTER_SANITIZE_STRING);

if(isset($_GET['tweet'])==1) {
    $oauth = new Zend_Oauth_Consumer($config);

    if (isset($_GET['oauth_token']) && isset($_SESSION['request_token'])) {
        try {
            $Tweet = $title.' '.$url.' via '.$via;
            
            $access = $oauth->getAccessToken($_GET, unserialize($_SESSION['request_token']));
            $client = $access->getHttpClient($config);
            $client->setUri('http://api.twitter.com/1/statuses/update.json');
            $client->setMethod(Zend_Http_Client::POST);
            $client->setParameterGet('status', $Tweet);
            $response = $client->request();
            
            print "Thank you! Your tweet has been updated!";
            print "<br /><br /><a href='javascript: self.close()'>Click here to close this window</a>";
            print "<script type='text/javascript'>window.opener.updateNumTweets({$jsonObj->count});</script>";
        } catch (Exception $e) {
            print $e->getMessage();
            exit();
        }
    } elseif (!empty($_GET['denied'])) {
        echo "You've denied the application to access your info on twitter!";
    } else {
        echo "Request tokens and/or oauth token is invalid!";
    }
}
else {
    $callBackUrl = 'http://test.com/button.php?tweet=1&title='.urlencode($title).'&url='.urlencode($url)."&shortener=".urlencode($shortener)."&via=".urlencode($via);

    $config['callbackUrl'] = $callBackUrl;
    
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
    header('location: '.$authUrl);
}
    