<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Costume quotations</title>
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
                    <a href="#">Manager </a> > Costume designs quotations
                </div>
                <div class="link-row-small">
                    <a href="#" class="right-button">Create a costume quotation</a>
                </div>
                <div id="list-box-small">
                    <center>
                        <h2>Costume designs quotations</h2>
                    </center>

                    <form method="post" action="" class="search-panel">
                        
                        <input type="text" name="" id="" placeholder="Search" class="text-field" />
                        <input type="submit" value="search" style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                        <b>Issued on : </b><br />
                        <div class="search-panel-row">
                            <div class="search-panel-row-left">
                                From : <input type="date" name="" id="" class="date-field" />
                            </div>
                            <div class="search-panel-row-right">
                                To&nbsp&nbsp : <input type="date" name="" id="" class="date-field" />
                            </div>
                        </div>
                        <b>Valid till : </b><br />
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
                            <b>Quotation ID</b>
                            <b>Customer name</b>
                            <b>Issued date</b>
                            <b>valid till</b>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0003</span>
                            <span>John Doe</span>
                            <span>2022-01-01</span>
                            <span>2022-06-01</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0006</span>
                            <span>John A</span>
                            <span>2022-02-01</span>
                            <span>2022-07-01</span>
                            <a href="#" class="green">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0010</span>
                            <span>John Doe</span>
                            <span>&nbsp</span>
                            <span>&nbsp</span>
                            <a href="#" class="grey">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0011</span>
                            <span>John B</span>
                            <span>2022-01-05</span>
                            <span>2022-06-05</span>
                            <a href="#" class="red">View</a>
                            <hr />
                        </div>
                        <div class="item-data-row">
                            <span>0026</span>
                            <span>Harry P</span>
                            <span>2022-01-01</span>
                            <span>2022-06-01</span>
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
