<?php
	include('_global.php');
	$Name = $_REQUEST['Name'];
	$Perm_ABS = $_REQUEST['Perm_ABS'];
	$PFTV = $_REQUEST['PFTV'];
	$sql = "SELECT Name,CONCAT(GROUP_CONCAT(DISTINCT LastName),' Residence') AS Addressee, MailAddress, MailCity, MailState, MailZip FROM PLUMERIA_ST";
	$where = "";
	$query_message = "";
	if($Name>''){
		$where .= " AND Name LIKE '%$Name%'";
		$query_message .= ", Name = ". $Name;
	} 
	if($Perm_ABS>''){
		if($Perm_ABS == 'Yes'){
			$where .= " AND PERM_ABS='P'";
		}else{
			$where .= " AND PERM_ABS=''";	
		}
		$query_message .= ", Permanent Absentee = ". $PFTV;
	}
	if($PFTV>''){
		if($PFTV == 'Yes'){
			$where .= " AND (PFTV='V' OR PFTV='A')";
		}else if($PFTV == 'No'){
			$where .= " AND (PFTV<>'V' AND PFTV<>'A' AND PFTV<>'')";
		}else{
			$where .= " AND PFTV=''";	
		}
		$query_message .= ", Voted in Primary = ". $PFTV;
	}
	if($where>'') $sql .= ' WHERE ' . substr($where, 5);
	$sql .= " GROUP BY MailAddress, MailZip";
	if($query_message>'') $query_message = substr($query_message, 2);
	$sqlTable = mysql_query($sql, $conn) or die("Couldn't perform query $sql (".__LINE__."): " . mysql_error() . '.');
	$sqlFields = mysql_num_fields($sqlTable);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Search Results</title>

	<meta name="viewport" content="width=device-width, user-scalable=yes">
	
	  <!-- jQuery -->
  	<script src="http://code.jquery.com/jquery-3.1.1.js"></script>
 	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
  	<!-- Latest compiled and minified CSS -->
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  	<!-- Optional theme -->
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

  	<!-- Latest compiled and minified JavaScript -->
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="http://www.w3schools.com/lib/w3data.js"></script>

</head>
<body>
<!-- navbar -->
<div w3-include-html="navbar.html"></div> 
<script>
	w3IncludeHTML();
</script>
<div class="container-fluid">
<h1>Search Results</h1>
<br>
	<p style="color: blue">Query: <?php echo $query_message; ?></p>
	<br />
	<p><span class="glyphicon glyphicon-download-alt"></span>&nbsp;<a href="download.php?Name=<?php echo $Name; ?>&amp;Perm_ABS=<?php  echo $Perm_ABS; ?>&amp;PFTV=<?php  echo $PFTV; ?>">Download data to .csv file</a></p>
<br>
<table class="table table_striped" border=1 cellspacing=0 cellpadding=5 id="search_results_table">
	<tr>
		<th>Name</th>
		<th>Address</th>
		<th>City</th>
		<th>State</th>
		<th>Zip</th>
	</tr>





	<?php
		$numRecords=0;

		while($sqlRecord = mysql_fetch_assoc($sqlTable))
		{
			$numRecords+=1;
			
	?>
			<tr><td><?php echo $sqlRecord['Addressee']; ?></td>
				<td><?php echo $sqlRecord['MailAddress']; ?></td>
				<td><?php echo $sqlRecord['MailCity']; ?></td>
				<td><?php echo $sqlRecord['MailState']; ?></td>
				<td><?php echo $sqlRecord['MailZip']; ?></td>
			</tr>

	<?php
		}
	?>

</table>
	<p><span style="font-size: 14pt; color:#CC0000">
	<?php echo "$numRecords records total";?> <span>
	</p>
	


</div>

</body>
</html>