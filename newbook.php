<?php

require("config.php");

if (!empty($_POST)) {
$uid=$_POST['uid'];
$make=$_POST['make'];
$model=$_POST['model'];
$garage=$_POST['garage'];
$plate=$_POST['plate'];
$date=$_POST['date'];


$query="INSERT INTO bookings(`unique_id`,`make` ,`model`,`Garage`,`date`,`created_on`,`plate` ) VALUES('$uid','$make','$model','$Garage','2020-02-02',NOW(),'$plate');";

$result = $conn->query($query);
if ($conn->query($query) == TRUE) {

echo json_encode( "
	<script>
	alert('$plate added into  customers');

	
	</script>");
} else {
    echo json_encode("Error: <br>" . $conn->error);
}

{

    echo 'Close Garage';
}

?>
