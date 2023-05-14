<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/OrderMaterialReceived.php');
    $args = $_POST;
    
    $orderMaterialReceivedModel = new OrderMaterialReceived($args);  
    switch($controllerName[1]){
        case "add":
            $orderMaterialReceivedModel->insertQuantityReceived();
            break;

    
    }
?>