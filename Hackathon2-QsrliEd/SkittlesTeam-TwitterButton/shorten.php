<?php

	$long = 'http://www.youtube.com';	
	echo file_get_contents('http://dev.qsr.li/api.php?token=e2cc997dedfac1cf4a917b5b0468a09a&action=shorturl&format=simple&url='. $long);

?>