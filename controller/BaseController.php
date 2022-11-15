<?php
    $controllerName = explode("/",$_POST["framework_controller"]);
    switch($controllerName[0]){
        case "employee":
            include_once ( __DIR__.'/EmployeeController.php');
            break;
        case "raw_material":
            include_once ( __DIR__.'/RawMaterialController.php');
            break;
        
    } 
    
?>


