<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add costume order</title>
        <link rel="stylesheet" type="text/css" href="../css/merchandiser/data_form_style.css" />
    </head>

    <body>
        <?php include 'header.php';?>

        <div id="page-body">
            <?php include 'leftnav.php';?>

            <div id="page-content">
                <div id="breadcrumb">
                    <a href="#">Welcome </a> >
                    <a href="#">Login </a> >
                    <a href="#">Merchandiser </a> >
                    <a href="#">Costume orders </a> > Create a costume order
                </div>

                <div id="form-box">
                    <form method="post" action="">
                        <center>
                            <h2>Add costume order(onsite)</h2>
                        </center>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation ID : 
                            </div>
                            <div class="form-row-data">
                                <select name="" id="">
                                    <option>0001</option>
                                    <option>0002</option>
                                    <option>0004</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer contact no : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Customer email : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>ID - Design name</b>
                            </div>
                            <div class="form-row-data">
                                <span><b>Quantity</b></span>
                                <span><b>Unit price(LKR)</b></span>
                                <span><b>Price(LKR)</b></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Black T-shirt-S
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Black T-shirt-L
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Black T-shirt-XXL
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Total items :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Total price (LKR) :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>Advance payment (LKR) :</b>
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Advance payment date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Expected delivery date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="" id="" />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation issued on :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation valid till :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="" id="" disabled />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-submit">
                                <input type="submit" value="Save" />
                            </div>
                            <div class="form-row-reset">
                                <input type="reset" value="Cancel" />
                            </div>
                        </div> 
                    </form>
                </div>   
            </div> 
        </div> 

        <?php include 'footer.php';?>

    </body> 
</html>
