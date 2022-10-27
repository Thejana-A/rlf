<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Raw materials</title>
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
                    <a href="#">Manager </a> > View raw materials
                </div>
                <div class="link-row">
                    <a href="#" class="left-button">Material storage log</a>
                    <a href="#" class="right-button">Add new raw material</a>
                </div>
                <div id="list-box">
                    <center>
                        <h2>Raw materials</h2>
                    </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Material ID</b>
                            <b>Material name</b>
                            <b>Measuring unit</b>
                            <b>Available quantity</b>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>Blue thread-S</span>
                            <span>reels</span>
                            <span>0</span>
                            <a href="#" class="grey">Edit</a>
                            <a href="#" class="grey">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0006</span>
                            <span>Black poplyn-M</span>
                            <span>m</span>
                            <span>25</span>
                            <a href="#" class="green">Edit</a>
                            <a href="#" class="green">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0010</span>
                            <span>Blue anchor button-L</span>
                            <span>units</span>
                            <span>500</span>
                            <a href="#" class="green">Edit</a>
                            <a href="#" class="green">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0011</span>
                            <span>Blue anchor button-M</span>
                            <span>units</span>
                            <span>200</span>
                            <a href="#" class="green">Edit</a>
                            <a href="#" class="green">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                        <div class="item-data-row">
                            <span>0026</span>
                            <span>White raw clothe-S</span>
                            <span>m</span>
                            <span>0</span>
                            <a href="#" class="red">Edit</a>
                            <a href="#" class="red">Delete</a>
                            <hr class="manager-long-hr" />
                        </div>
                    </div>


                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
