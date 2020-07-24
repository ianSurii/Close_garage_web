<?php 
 require("config.php");
// if (!empty($_POST)) {
$sql = "SELECT count(pro_id) from cart";


$r = mysqli_query($conn,$sql);

$result = array();

while($row = mysqli_fetch_array($r)){
    array_push($result,
array(
	 'count'=>$row['count(pro_id)'],
 
       
    ));
}

echo json_encode(array('countresult'=>$result));

// $sql = "SELECT count(pro_id) from cart where unique_id='13232ed3d'";


// $r = mysqli_query($conn,$sql);

// $result = array();

// while($row = mysqli_fetch_array($r)){
//     array_push($result,
// array(
// 	 'count'=>$row['count(pro_id)'],
 
       
//     ));
// }

// echo json_encode(array('countresult'=>$result));

?>
