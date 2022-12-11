<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/OrderMaterialReceived.php');
    $args = $_POST;
    
    $orderMaterialReceivedModel = new OrderMaterialReceived($args);  
    switch($controllerName[1]){
        case "add":
            $orderMaterialReceivedModel->insertQuantityReceived();
            break;
        case "update":
            $orderMaterialReceivedModel->updateQuantityReceived();
            break;
        case "manager_view":
            $data = $orderMaterialReceivedModel->viewQuantityReceived();
            //print_r($data);
            $row = http_build_query($data); 
            header("location: http://localhost/rlf/view/manager/view_material_purchase_request.php?data[]=$row");
            break;
    
    }
?>