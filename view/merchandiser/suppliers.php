<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Suppliers</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/view_list_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Merchandiser </a> > Suppliers
                </div>
                
                <div id="list-box-small">
                    <center>
                        <h2>Suppliers</h2>
                    </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />   
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Supplier ID</b>
                            <b>Supplier name</b>
                            <b>City</b>
                            <b>Contact no</b>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>John Honter</span>
                            <span>Piliyandala</span>
                            <span>0777762043</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0006</span>
                            <span>John A</span>
                            <span>Kottawa</span>
                            <span>0777762045</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0010</span>
                            <span>John B</span>
                            <span>Galle</span>
                            <span>0777762044</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0011</span>
                            <span>John C</span>
                            <span>Kandy</span>
                            <span>0777762046</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0026</span>
                            <span>Harry P</span>
                            <span>Jaffna</span>
                            <span>0777762049</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
