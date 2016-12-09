<?php
	require_once('includes/database_config.php');
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
		extract($_POST);
		$sql = "SELECT * FROM users WHERE user_id = '{$userID}' AND user_type = '1'";
		$res = $dbh->prepare($sql);
		$res->execute();
		$counter = $res->rowCount();
		if($counter == 1)
		{
			$sql = "UPDATE users SET user_type = '0' WHERE user_id = '{$userID}'";
			$res = $dbh->prepare($sql);
			if($res->execute())
				$data = array(
					"valid"    => true,
					"msg" => "Success"
				);
		}
		else
		{
			$data = array(
				"valid" => false,
				"msg" => "Not Admin"
			);
		}
		echo json_encode($data);
	endif;
