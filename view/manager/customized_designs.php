<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Customized costume designs</title>
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
                    <a href="#">Manager </a> >Customized costume designs
                </div>
                
                <div id="list-box">
                    <center>
                        <h2>Customized costume designs</h2>
                    </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Design ID</b>
                            <b>Design name</b>
                            <b>Customer name</b>
                            <b>Fashion designer</b>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>Blue-long-sleeve</span>
                            <span>Jane Eyre</span>
                            <span>John A</span>
                            <a href="#" class="green">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0005</span>
                            <span>White Chinese collar</span>
                            <span>Sherlock H</span>
                            <span>&nbsp</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0006</span>
                            <span>Red dotted shirt</span>
                            <span>John Watson</span>
                            <span>&nbsp</span>
                            <a href="#" class="red">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0007</span>
                            <span>Blue T-shirt</span>
                            <span>James Kane</span>
                            <span>&nbsp</span>
                            <a href="#" class="green">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0009</span>
                            <span>Stripped white top</span>
                            <span>Peter ABC</span>
                            <span>Henry C</span>
                            <a href="#" class="green">View</a>
                            <hr />
                        </div>
                        
                    </div>
                </div>
                         
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
