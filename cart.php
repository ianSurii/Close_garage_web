<?php
require("config.php");
mysqli_autocommit($conn, FALSE);

// look for a transfer is_numeric($_POST['uid']) && ($_POST['pro_id'])
if (!empty($_POST)) {
// $_POST['uid']=$uid;
// $_POST['pro_id']=$pro_id;
            $response = array(
                "error" => FALSE
            );

                $query_params = array(
                    ':email' => $_POST['email'],
                   ':uuid'=> $_POST['uid'],
                    ':pro_id'=>$_POST['pro_id']
                );

                try {
                    $stmt = $db->prepare($query);
                    $result = $stmt->execute($query_params);
                }

                catch (PDOException $ex) {

                    $response["error"] = TRUE;
                    $response["message"] = "Database Error1. Please Try Again!";
                    die(json_encode($response));
                }
                //check if exist

                $check_result=mysqli_query($conn,"SELECT FROM cart where pro_id=:pro_id && unique_id=:uuid");
                if ($check_result !== TRUE) {
                     $query_insert = mysqli_query($conn, "INSERT INTO cart(pro_id,pro_quantity,unique_id) VALUES (:pro_id,'1',:uuid)")  ;
                    if ($query_insert !== TRUE) {
                        mysqli_rollback($conn); 
                    }
                    else{
                        $query_update1 = mysqli_query($conn, "UPDATE products SET pro_quantity = pro_quantinty - '1' where pro_id=:pro_id");
                    }
                }
                else{
                    $query_update = mysqli_query($conn, "UPDATE cart SET pro_quantity = pro_quantinty + '1'");
                    if ($query_update !== TRUE) {
                        //roolback in case of errors
                        mysqli_rollback($conn); 
                        
                    }
                    else{
                        $query_update2 = mysqli_query($conn, "UPDATE products SET pro_quantity = pro_quantinty - '1' where pro_id=:pro_id");
                    }
                   
                }
 
    mysqli_commit($conn);
}

// $result = mysqli_query($conn, "SELECT * FROM cart");
// while ($row = mysqli_fetch_assoc($result)) {
//     $cart[] = $row;
// }
?>
