<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Costume designs</title>
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
                    <a href="#">Merchandiser </a> > View costume designs
                </div>
                
                <div id="list-box">
                    <center>
                        <h2>Costume designs</h2>
                    </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />   
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Design ID</b>
                            <b>Design name</b>
                            <b>Size</b>
                            <b>Fashion designer</b>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>Blue collarless T-shirt-S</span>
                            <span>S</span>
                            <span>John Doe</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0006</span>
                            <span>Blue collarless T-shirt-M</span>
                            <span>M</span>
                            <span>John Doe</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0010</span>
                            <span>Red Chinese collar-S</span>
                            <span>S</span>
                            <span>Jennifer Lopez</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0011</span>
                            <span>Red Chinese collar-XXL</span>
                            <span>XXL</span>
                            <span>Jennifer Lopez</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0026</span>
                            <span>Gold top-XL</span>
                            <span>XL</span>
                            <span>John C</span>
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
