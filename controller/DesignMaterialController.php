<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/DesignMaterial.php');
    
    $args = $_POST;
    $designMaterialModel = new DesignMaterial($args, $_POST["design_id"]); 
    switch($controllerName[1]){
        case "add_material_quantity":   
            $designMaterialModel->insertMaterialQuantity();
            break;
    }
?>