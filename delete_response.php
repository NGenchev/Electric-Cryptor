<?php
	require_once('includes/database_config.php');
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
		extract($_POST);
		$masterA = encrypt($master);
		$sql = "SELECT * FROM users WHERE `user_id` = '$userID' AND `user_mPassword` = '$masterA'";
		$res = $dbh->prepare($sql);
		$res->execute();
		$counter = $res->rowCount();
		if($counter == 1)
		{
			$sql = "DELETE FROM passwords WHERE `pw_uID` = '$userID' AND `pw_id` ='$pwID'";
			$res = $dbh->prepare($sql);
			$res->execute();
			$counter = $res->rowCount();
			if($counter == 1)
				$data = array(
					"valid" => true
				);
			else
				$data = array(
					"valid" => false
				);
		}
		else
			$data = array(
				"valid" => false
			);
		echo json_encode($data);
	endif;
