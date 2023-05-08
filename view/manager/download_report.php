<?php

    //print_r($_POST["report_content"]);
    namespace Dompdf;
    require_once 'dompdf/autoload.inc.php';
    $report_content = $_POST["report_content"];
    //print_r("<html><head><link rel='stylesheet' type='text/css' href='../css/merchandiser/data_form_style.css' /><link rel='stylesheet' type='text/css' href='../css/merchandiser/view_list_style.css' /></head><body>".$report_content."</body></html>");

    if(isset($_POST['pdf_download'])){
        $dompdf = new Dompdf(); 
        $dompdf->loadHtml($report_content);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("",array("Attachment" => false));
        exit(0);
    } 
?>
    