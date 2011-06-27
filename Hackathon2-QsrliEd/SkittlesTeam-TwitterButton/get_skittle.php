<?php

	require_once './mysql_config.php';
	
	$skittleid = intval($_POST['id']);
	
	$query = mysql_query('select * from `skittles` where `skittleid` = '. $skittleid);
	$skittle = mysql_fetch_assoc($query);
	
	$skittle['tweetimg'] = 'http://localhost/hackathon/twitter/skittles/tweetimgs/'. $skittle['tweetimg'];
	
	echo json_encode($skittle);

?>