<?php 
 require("config.php");
// if (!empty($_POST)) {
$sql = "SELECT * FROM products";


$r = mysqli_query($conn,$sql);

$result = array();

while($row = mysqli_fetch_array($r)){
    array_push($result,
array(
	 //'id'=>$row['pro_id'],
        'pro_name'=>$row['pro_name'],
        'pro_desc'=>$row['pro_desc'],
        'pro_price'=>$row['pro_price'],
        //'image'=>$row['pro_image'],
        'pro_quantity'=>$row['pro_quantity']
       
    ));
}

echo json_encode(array('result'=>$result));

//mysqli_close($conn);
// } else {
     //   echo 'Close Garage';
    //}
