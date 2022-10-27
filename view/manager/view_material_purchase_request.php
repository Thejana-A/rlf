<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View material purchase request</title>
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
                    <a href="#">Manager </a> >
                    <a href="#">Raw material purchase request </a> > View
                </div>

                <div id="form-box">
                    <form method="post" action="">
                        <center>
                            <h2>View material purchase requests</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Order ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Supplier contact no : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Merchandiser ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Merchandiser name : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation issuing date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation Valid till :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Expected delivery date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="" id="" disabled />
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>ID - material name(size)</b>
                            </div>
                            <div class="form-row-data">
                                <span><b>Quantity</b></span>
                                <span><b>Measuring Unit</b></span>
                                <span><b>Price(LKR)</b></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0005-Black anchor button-S(S)
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0005-Blue thin thread-L(L)
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0005-Black anchor button-L(L)
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
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
                                Approval (By manager) :
                            </div>
                            <div class="form-row-data">
                                <table width="60%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="manager_approval" class="input-radio" id="" /> Approve
                                        </td>
                                        <td>
                                            <input type="radio" name="manager_approval" class="input-radio" id="" /> Reject
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Approval description :
                            </div>
                            <div class="form-row-data">
                                <textarea id="" name="" rows="4" cols="40"></textarea>
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
                
                <div id="form-box">
                    <form method="post" action="">
                        <center>
                            <h2>View material purchase requests</h2>
                        </center>
                    
                        <div class="form-row">
                            <div class="form-row-theme">
                                Quotation ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Order ID : 
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" disabled />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                <b>ID - material name(size)</b>
                            </div>
                            <div class="form-row-data">
                                <span><b>Quantity</b></span>
                                <span><b>Measuring Unit</b></span>
                                <span><b>Quantity received</b></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0005-Black anchor button-S(S)
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0005-Blue thin thread-L(L)
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                0005-Black anchor button-L(L)
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" disabled />
                                <input type="text" name="" id="" class="column-textfield" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Material received on :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Payment (LKR) :
                            </div>
                            <div class="form-row-data">
                                <input type="text" name="" id="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-theme">
                                Payment date :
                            </div>
                            <div class="form-row-data">
                                <input type="date" name="" id="" />
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
