<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/CostumeQuotation.php');
    
    $args = $_POST;
    $costumeQuotationModel = new CostumeQuotation($args); 
    switch($controllerName[1]){
        case "add":
            $costumeQuotationModel->addCostumeQuotation();
            break;
        case "view":
            $costumeQuotationModel->viewCostumeQuotation();
            break;
        case "update":
            $costumeQuotationModel->updateCostumeQuotation();
            break;

    } 
    
?>