<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/RawMaterial.php');
    $args = $_POST;
    
    $rawMaterialModel = new RawMaterial($args); 
    switch($controllerName[1]){
        case "add":
            $rawMaterialModel->addRawMaterial();
            break;
        case "view":
            $rawMaterialModel->viewRawMaterial();
            break;
        case "update":
            $rawMaterialModel->updateRawMaterial();
            break;
        case "delete":
            $rawMaterialModel->deleteRawMaterial();
            break;
        
    } 
    
?>