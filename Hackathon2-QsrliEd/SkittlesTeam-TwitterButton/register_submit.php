<?php

	require_once './mysql_config.php';
	
	$email = trim($_POST['email']);
	$skittleurl = trim($_POST['skittleurl']);
	if ($_POST['shortening'] == 'on') {
		$shortening = 1;
	} else {
		$shortening = 0;
	}
	$shorteningurl = trim($_POST['shorteningurl']);
	if ($_POST['counting'] == 'on') {
		$counting = 1;
	} else {
		$counting = 0;
	}
	
	if ($email == '' || $skittleurl == '') {
		echo 'Oops! Ga3ed tet5awwath?!!';
	} else {
		$upload = false;
		$uploaded_name = '';
		if ($_FILES['tweetimg']['name'] != '') {
			$new_name = time();
			$file_parts = explode('.', $_FILES['tweetimg']['name']);
			$ext = $file_parts[count($file_parts) - 1];
			$new_name = $new_name .'.'. $ext;
			$upload = move_uploaded_file($_FILES['tweetimg']['tmp_name'], './tweetimgs/'. $new_name);
			if ($upload) $uploaded_name = $new_name;
		}
	
		$query = mysql_query("insert into `skittles`
			(`email`, `skittleurl`, `tweetimg`, `shortening`, `shorteningurl`, `counting`)
			values
			('". $email ."', '". $skittleurl ."', '". $uploaded_name ."', ". $shortening .", '". $shorteningurl ."', ". $counting .")");
		if ($query) {
			echo 'Yeslamo!! Olgofff:<br>';
			echo '
				<textarea rows="6" cols="70"><script type="text/javascript" src="http://localhost/hackathon/twitter/skittles/myskittle.php?id='. mysql_insert_id() .'"></script></textarea>
			';
		}
	}

?>