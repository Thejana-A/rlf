<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Costume orders</title>
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
                    <a href="#">Merchandiser </a> > Costume orders
                </div>
                
                <div class="link-row-small">
                    <a href="./add_costume_order_onsite.php" class="right-button">Add new costume order</a>
                </div>
                <div id="list-box-small">
                    <center>
                        <h2>Costume orders</h2>
                    </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        <b>Order placed on : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="" id="" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="" id="" class="date-field" />
                            </div>
                        </div>
                        <b>Expected delivery date : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="" id="" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="" id="" class="date-field" />
                            </div>
                        </div>   
                    </form>

                    <div class="item-list">
                        <div class="item-heading-row">
                            <b>Customer name</b>
                            <b>Order status</b>
                            <b>Order placed on</b>
                            <b>EDD</b>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>John Doe</span>
                            <span>Pending</span>
                            <span>2022-10-01</span>
                            <span>2022-12-01</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>John A</span>
                            <span>Confirmed</span>
                            <span>2022-06-01</span>
                            <span>2023-01-01</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>John Doe</span>
                            <span>Confirmed</span>
                            <span>2022-08-01</span>
                            <span>2022-12-01</span>
                            <a href="#" class="red">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>John C</span>
                            <span>Completed</span>
                            <span>2022-01-05</span>
                            <span>2022-12-15</span>
                            <a href="#" class="green">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>Harry P</span>
                            <span>Completed</span>
                            <span>2022-07-01</span>
                            <span>2022-11-30</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>Harry P</span>
                            <span>Delivered</span>
                            <span>2022-01-01</span>
                            <span>2022-03-01</span>
                            <a href="#" class="green">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>Harry P</span>
                            <span>Accepted</span>
                            <span>2022-01-01</span>
                            <span>2022-03-01</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>Harry P</span>
                            <span>Rejected</span>
                            <span>2022-01-01</span>
                            <span>2022-03-01</span>
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
