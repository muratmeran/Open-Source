<?php

	header('Content-type: text/javascript');
	
	require_once './mysql_config.php';
	
	$skittleid = intval($_GET['id']);
	
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

?>

function setCookie(c_name,value,exdays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

$(document).ready(function() {

//	$('.skittle_tweet_button').click(function() {
		//window.open(, 'توّتها', 'width=500, height=500');
		//
	//	alert("A");
	//});
	
	//alert(window.location);
	//alert($('title').html());
	
	page_title = $('title').html();
	page_url = window.location;
	setCookie('skittle_page_title', page_title);
	setCookie('skittle_page_url', page_url);
	
	$.ajax({
	  type: 'POST',
	  url: 'http://localhost/hackathon/twitter/skittles/get_skittle.php',
	  data: 'id=<?php echo $skittleid; ?>',
	  success: function(skittle) {
			$('script[src*=skittle]').after('<a href="#" onclick="window.open(\'<?php echo $authUrl; ?>&page_title=\'+ page_title +\'&page_url=\'+ page_url,\'Skittle\',\'menubar=1,resizable=1,scrollbars=1,width=600,height=450\'); return false;"><img border="0" src="'+ skittle.tweetimg +'"></a>');
		},
	  dataType: 'json'
	});
});