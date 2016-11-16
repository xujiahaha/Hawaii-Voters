<?php
	include('_global.php');
	$Name=$_REQUEST['Name'];
	$Perm_ABS=$_REQUEST['Perm_ABS'];
	$PFTV=$_REQUEST['PFTV'];
	$sql="SELECT Name,CONCAT(GROUP_CONCAT(DISTINCT LastName),' Residence') AS Addressee, MailAddress, MailCity, MailState, MailZip FROM PLUMERIA_ST";
	$where="";
	if($Name>'') $where .= " AND Name LIKE '%$Name%'";
	if($Perm_ABS>''){
		if($Perm_ABS == 'Yes'){
			$where .= " AND PERM_ABS='P'";
		}else{
			$where .= " AND PERM_ABS=''";
		}
	}
	if($PFTV>''){
		if($PFTV == 'Yes'){
			$where .= " AND (PFTV='V' OR PFTV='A')";
		}else if($PFTV == 'No'){
			$where .= " AND (PFTV<>'V' AND PFTV<>'A' AND PFTV<>'')";
		}else{
			$where .= " AND PFTV=''";
		}
	}
	if($where>'') $sql .= ' WHERE ' . substr($where,5);
	$sql .= " GROUP BY MailAddress, MailZip";
	$sqlTable = mysql_query($sql, $conn) or die("Couldn't perform query $sql (".__LINE__."): " . mysql_error() . '.');

	$output = "Name,Address,City,State,Zip\n";
	while($sqlRecord=mysql_fetch_assoc($sqlTable)){
		$output.='"'.$sqlRecord['Addressee'].'","'.$sqlRecord['MailAddress'].'","'.$sqlRecord['MailCity'].'","'.$sqlRecord['MailState'].'","'.$sqlRecord['MailZip'].'"'."\n";
	}
	
	header('Content-type: application/csv');
	header('Content-Disposition: attachment; filename=mail_addresses.csv');
	echo $output;
	
?>






