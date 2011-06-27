<?php

	require_once './mysql_config.php';

?>

<html>
	<head>
		
	</head>
	
	<body>
		<form method="post" action="register_submit.php" enctype="multipart/form-data">
			<table>
				<tr>
					<td>Email</td>
					<td><input type="text" name="email"></td>
				</tr>
				
				<tr>
					<td>Website URL</td>
					<td><input type="text" name="skittleurl"></td>
				</tr>
				
				<tr>
					<td>Sharing Image</td>
					<td><input type="file" name="tweetimg"></td>
				</tr>
				
				<tr>
					<td>Enable Shortening</td>
					<td>
						<input type="checkbox" name="shortening">
					</td>
				</tr>
				
				<tr>
					<td>Shortening Service</td>
					<td>
						<select name="shorteningurl">
							<option value="qsr.li">Qsr.li</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td>Enable Counting</td>
					<td>
						<input type="checkbox" name="counting">
					</td>
				</tr>
				
				<tr>
					<td></td>
					<td>
						<input type="submit" value=" Go > ">
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>