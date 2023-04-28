<?php
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    if(($_SESSION["customer_id"]=="")){
        header("location:http://localhost/rlf/view/customer/customer_login.php");
        die();
    }
?>