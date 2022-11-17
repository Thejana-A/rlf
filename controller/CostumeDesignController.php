<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/CostumeDesign.php');
    $args = $_POST;
    
    $costumeDesignModel = new CostumeDesign($args); 
    switch($controllerName[1]){
        case "add":
            $costumeDesignModel->addDesign();
            break;
        case "view":
            $costumeDesignModel->viewDesign();
            break;
        case "update":
            $costumeDesignModel->updateDesign();
            break;
        case "delete":
            $costumeDesignModel->deleteDesign();
            break;
    } 
    
?>