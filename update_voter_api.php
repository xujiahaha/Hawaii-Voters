<?php
	include('_global.php');

	$VID=$_REQUEST['VID'];
	$Contact = $_REQUEST['Contact'];
	$Comments = $_REQUEST['Comments'];
	
	$sql = "SELECT Contact, Comments FROM PLUMERIA_ST WHERE VID=$VID";

	$sqlTable = mysql_query($sql, $conn) or die("Couldn't perform query $sql (".__LINE__."): " . mysql_error() . '.');
	
	$status=0;
	$message="";
	
	if($sqlRecord = mysql_fetch_assoc($sqlTable))
	{		
		$Amount *= 1;
		$set="";
		if($Contact != $sqlRecord['Contact'])
		{
			$message .= ", Contact changed to $Contact";
			$set .= ", Contact='$Contact'";
		}
		
		if($Comments != $sqlRecord['Comments'])
		{
			$message .= ", Comments changed to $Comments";
			$set .= ", Comments='$Comments'";
		}

		if($set>'')
		{
			$set = substr($set, 2);
			$sql = "UPDATE PLUMERIA_ST SET $set WHERE VID='$VID'";	
			$sqlUpdate = mysql_query($sql, $conn) or die("Couldn't perform query $sql (".__LINE__."): " . mysql_error() . '.');
			$message = substr($message, 2);
			$status = 1;
		}
		else
		{
			$message = "Voter record not changed";
		}
	}
	else
	{
		$message="VID $VID not found.";
	}
	
	$json = json_encode([
		"datetime" => $datetime,
		"message" => $message,
		"status" => $status

	]);
	echo $json;

?>

