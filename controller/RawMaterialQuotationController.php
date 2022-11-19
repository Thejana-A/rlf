<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/RawMaterialQuotation.php');
    $args = $_POST;
    
    $rawMaterialQuotationModel = new RawMaterialQuotation($args); 
    switch($controllerName[1]){
        case "add":
            $rawMaterialQuotationModel->addMaterialQuotation();
            break;
        case "view":
            $rawMaterialQuotationModel->viewMaterialQuotation();
            break;
        case "update":
            $rawMaterialQuotationModel->updateMaterialQuotation();
            break;
    } 
    
?>