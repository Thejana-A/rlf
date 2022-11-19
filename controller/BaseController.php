<?php
    $controllerName = explode("/",$_POST["framework_controller"]);
    switch($controllerName[0]){
        case "employee":
            include_once ( __DIR__.'/EmployeeController.php');
            break;
        case "customer":
            include_once ( __DIR__.'/CustomerController.php');
            break;
        case "supplier":
            include_once ( __DIR__.'/SupplierController.php');
            break;
        case "raw_material":
            include_once ( __DIR__.'/RawMaterialController.php');
            break;
        case "raw_material_quotation":
            include_once ( __DIR__.'/RawMaterialQuotationController.php');
            break;
        case "costume_design":
            include_once ( __DIR__.'/CostumeDesignController.php');
            break;
        
        
    } 
    
?>


