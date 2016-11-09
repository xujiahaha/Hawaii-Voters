<?php
	include('_global.php');
	$Name=$_REQUEST['Name'];
	$Perm_ABS=$_REQUEST['Perm_ABS'];
	$PFTV=$_REQUEST['PFTV'];
	$sql="SELECT Name, PFTV, PERM_ABS, MailAddress, MailCity, MailState, MailZip FROM PLUMERIA_ST";
	$where="";
	if($Name>'') $where .= " AND Name LIKE '%$Name%'";
	if($Perm_ABS>'') $where .= " AND PERM_ABS='$Perm_ABS'";
	if($PFTV>'') $where .= " AND PFTV='$PFTV'";
	if($where>'') $sql .= ' WHERE ' . substr($where,5);
	$sql .= " ORDER BY Name";
	
	$sqlTable = mysql_query($sql, $conn) or die("Couldn't perform query $sql (".__LINE__."): " . mysql_error() . '.');
	$sqlFields = mysql_num_fields($sqlTable);

	$csv_export = '';
	// create line with field names
	for($i = 0; $i < $sqlFields; $i++) {
  		$csv_export.= mysql_field_name($sqlTable,$i).',';
	}
	// newline (seems to work both on Linux & Windows servers)
	$csv_export.= '
	';
	
	// loop through database query and fill export variable
	while($row = mysql_fetch_array($sqlTable)) {
  		// create line with field values
  		for($i = 0; $i < $sqlFields; $i++) {
    			$csv_export.= $row[mysql_field_name($sqlTable,$i)].',';
  		}	
  		$csv_export.= '
		';	
	}
	
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=data.csv');
	echo $csv_export;
	
?>






