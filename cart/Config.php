<?php
session_start();
if (isset($_POST['email']) && isset($_POST['password'])) {

   
    $email = $_POST['email'];

$_SESSION['user']=$email;
}
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "project");
?>
