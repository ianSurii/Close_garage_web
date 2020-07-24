<?php 
include 'config.php';
//if(isset($_POST['uid'])){
//$email=$_POST['uid'];
$sql = "SELECT * FROM bookings";


$r = mysqli_query($conn,$sql);

$result = array();

while($row = mysqli_fetch_array($r)){
    array_push($result,array(
	 'bookno'=>$row['booking_number'],
        'make'=>$row['make'],
        'model'=>$row['model'],
        'plate'=>$row['plate'],
        'date'=>$row['date']
    ));

}
echo json_encode(array('result'=>$result));

//else{
//echo json_encode("no bookings avilable");
//}

//else{
//echo json_encode("failed");
//}

mysqli_close($conn);
?>
