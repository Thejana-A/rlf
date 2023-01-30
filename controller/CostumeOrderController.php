<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/CostumeOrder.php');
    $args = $_POST;
    
    $costumeOrderModel = new CostumeOrder($args); 
    switch($controllerName[1]){
        case "add":
            $costumeOrderModel->addCostumeOrder();
            //print_r($_POST);
            break;
        case "manager_view":
            $data = $costumeOrderModel->viewCostumeOrder();
            //$row = http_build_query($data); 
            session_start();
            $_SESSION["row"] = $data;
            //header("location: http://localhost/rlf/view/manager/view_costume_order.php?data[]=$row");
            header("location: http://localhost/rlf/view/manager/view_costume_order.php?data=true");
            break;
        case "merchandiser_view":
            $data = $costumeOrderModel->viewCostumeOrder();
            //$row = http_build_query($data); 
            session_start();
            $_SESSION["row"] = $data;
            //header("location: http://localhost/rlf/view/merchandiser/view_costume_order.php?data[]=$row");
            header("location: http://localhost/rlf/view/merchandiser/view_costume_order.php?data=true");
            break;
        case "update":
            $costumeOrderModel->updateCostumeOrder();
            break;
    } 
    
?>