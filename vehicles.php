<?php 
 require("config.php");
// if (!empty($_POST)) {
$sql = "SELECT * FROM Vehicles";


$r = mysqli_query($conn,$sql);

$result = array();

while($row = mysqli_fetch_array($r)){
    array_push($result,
array(
	 'id'=>$row['id'],
        'make'=>$row['Make'],
        'model'=>$row['Model'],
        'plate'=>$row['Plate'],
        //'image'=>$row['image']
    ));
}

echo json_encode(array('result'=>$result));

//mysqli_close($conn);
// } else {
     //   echo 'Close Garage';
    //}
