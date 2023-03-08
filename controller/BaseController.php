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
        case "storage_log":
            include_once ( __DIR__.'/StorageLogController.php');
            break;
        case "raw_material_quotation":
            include_once ( __DIR__.'/RawMaterialQuotationController.php');
            break;
        case "raw_material_order":
            include_once ( __DIR__.'/RawMaterialOrderController.php');
            break;
        case "order_material_received":
            include_once ( __DIR__.'/OrderMaterialReceivedController.php');
            break;
        case "costume_design":
            include_once ( __DIR__.'/CostumeDesignController.php');
            break;
        case "design_material":
            include_once ( __DIR__.'/DesignMaterialController.php');
            break;
        case "costume_quotation":
            //print_r($_POST);
            include_once ( __DIR__.'/CostumeQuotationController.php');
            break;
        case "costume_order":
            include_once ( __DIR__.'/CostumeOrderController.php');
            break;
        
    } 
    
?>


