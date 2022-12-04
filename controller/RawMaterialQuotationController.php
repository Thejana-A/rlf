<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/RawMaterialQuotation.php');
    $args = $_POST;
    
    $rawMaterialQuotationModel = new RawMaterialQuotation($args); 
    switch($controllerName[1]){
        case "add":
            $rawMaterialQuotationModel->addMaterialQuotation();
            break;
        case "manager_view":
            $rawMaterialQuotationModel = new RawMaterialQuotation($_POST); 
            $data = $rawMaterialQuotationModel->viewMaterialQuotation();
            $row = http_build_query($data); 
            header("location: http://localhost/rlf/view/manager/view_material_quotation.php?data[]=$row");
            break;
        case "update":
            $rawMaterialQuotationModel->updateMaterialQuotation();
            break;
    } 
    
?>