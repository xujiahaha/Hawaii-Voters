<?php

include('_global.php');

$datetime = date('Y-m-d H:i:s');

$option = $_REQUEST['option'];

$sqlSelect = "SELECT Name, HouseNum, City, Zip, Status, PFTV, GFTV, PERM_ABS, Contact, Comments, VID FROM PLUMERIA_ST ORDER BY HouseNum";
$sqlTable = mysql_query($sqlSelect, $conn) or die("Couldn't perform query $sqlSelect (".__LINE__."): " . mysql_error() . '.');



$votings = [];


if($option == "odd"){
	while($sqlRecord = mysql_fetch_assoc($sqlTable)){
		if($sqlRecord['HouseNum'] != null && (int)substr($sqlRecord['HouseNum'], -1)%2==1){
			array_push($votings,$sqlRecord);
		}
	}
} else if($option == "even"){
	while($sqlRecord = mysql_fetch_assoc($sqlTable)){
		if($sqlRecord['HouseNum'] != null && (int)substr($sqlRecord['HouseNum'], -1)%2==0){
			array_push($votings,$sqlRecord);
		}
	}
} else if($option == "na"){
	while($sqlRecord = mysql_fetch_assoc($sqlTable)){
		if($sqlRecord['HouseNum'] == null){
			array_push($votings,$sqlRecord);
		}
	}
}else if($option == "all"){
	while($sqlRecord = mysql_fetch_assoc($sqlTable)){
			array_push($votings,$sqlRecord);	
	}
}  else {
	echo "Please set option as odd or even or all.";
}



echo json_encode(["datetime" => $datetime, "votings" => $votings]);

?>