<?php
session_start();
include('DB_Connect.php');
$status="";
if (isset($_POST['make']) && $_POST['make']!=""){
$make = $_POST['make'];
$result = mysqli_query(
$conn,
"SELECT * FROM `product` WHERE ``='$make'"
);
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
$make = $row['make'];
$price = $row['price'];
$image = $row['image'];
 
$cartArray = array(
 $make=>array(
 'name'=>$name,
 'make'=>$make,
 'price'=>$price,
 'quantity'=>1,
 'image'=>$image)
);
 
if(empty($_SESSION["shopping_cart"])) {
    $_SESSION["shopping_cart"] = $cartArray;
    $status = "<div class='box'>Product is added to your cart!</div>";
}else{
    $array_keys = array_keys($_SESSION["shopping_cart"]);
    if(in_array($make,$array_keys)) {
 $status = "<div class='box' style='color:red;'>
 Product is already added to your cart!</div>"; 
    } else {
    $_SESSION["shopping_cart"] = array_merge(
    $_SESSION["shopping_cart"],
    $cartArray
    );
    $status = "<div class='box'>Product is added to your cart!</div>";
 }
 
 }
}
?>
<?php
if(!empty($_SESSION["shopping_cart"])) {
$cart_count = count(array_keys($_SESSION["shopping_cart"]));
?>
<div class="cart_div">
<a href="cart.php"><img src="cart-icon.png" /> Cart<span>
<?php echo $cart_count; ?></span></a>
</div>
<?php
}
?>

