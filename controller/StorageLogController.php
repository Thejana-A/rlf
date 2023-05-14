<?php
    require_once(__DIR__.'/BaseController.php');
    require_once('../model/StorageLog.php');
    
    $args = $_POST;
    $storageLogModel = new StorageLog($args); 
    switch($controllerName[1]){
        case "manage":
            $storageLogModel->manageStorage();
            break;

        
    } 
    
?>