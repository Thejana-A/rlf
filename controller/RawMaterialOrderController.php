<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/RawMaterialOrder.php');
    $args = $_POST;
    
    $rawMaterialOrderModel = new RawMaterialOrder($args);  
    switch($controllerName[1]){
        case "add":
            $rawMaterialOrderModel->addMaterialOrder();
            break;
        case "update":
            $rawMaterialOrderModel->updateMaterialOrder();
            break;
        case "manager_view":
            $data = $rawMaterialOrderModel->viewMaterialOrder(); 
            session_start();
            $_SESSION["row"] = $data;
            header("location: http://localhost/rlf/view/manager/view_material_purchase_request.php?data=true");
            break;
        case "merchandiser_view":
            $data = $rawMaterialOrderModel->viewMaterialOrder(); 
            session_start();
            $_SESSION["row"] = $data;
            header("location: http://localhost/rlf/view/merchandiser/view_material_purchase_request.php?data=true");
            break;
        case "supplier_view":
            $data = $rawMaterialOrderModel->viewMaterialOrder();
            //print_r($data);
            //$row = http_build_query($data);
            session_start();
            $_SESSION["row"] = $data; 
            //header("location: http://localhost/rlf/view/supplier/accept_purchase_request.php?data[]=$row");
            header("location: http://localhost/rlf/view/supplier/accept_purchase_request.php?data=true");
            break;

    }
?>