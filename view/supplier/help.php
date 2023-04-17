<?php require_once 'redirect.php' ?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Help</title>
    <link rel="stylesheet" type="text/css" href="../supplier/css/data_form_style.css" />
    <link rel="stylesheet" type="text/css" href="../supplier/css/view_list_style.css" />
    <style>
    #myTable {
        border-collapse: collapse;
        width: 95%;
        border: 1px solid #ddd;
        font-size: 10px;
        text-align: justify;
        text-justify: inter-word;
    }

    #myTable th,
    #myTable td {
        text-align: left;
        padding: 12px;
    }

    #myTable tr {
        border-bottom: 1px solid #ddd;
    }

    #myTable tr.header,
    #myTable tr:hover {
        background-color: #aaaaaa;
    }
    </style>
</head>

<body>
    <?php include 'header.php';?>

    <div id="page-body">
        <?php include 'leftnav.php';?>

        <div id="page-content">
            <div id="breadcrumb">
                <a href="index.php">Welcome </a> >
                Help
            </div>

            <div id="form-box" style="width:50%;">
                <center>
                    <h2>Help</h2>
                </center>

                <form method="post" action="" class="search-panel">

                    <input type="text" id="myInput" placeholder="Search" onkeyup="myFunction()" class="text-field" />
                    <input type="submit" value="search"
                        style="padding:3px;padding-left:10px;padding-right:10px;" /><br />
                    <br>
                </form>


                <table id="myTable">
                    <tr class="header">
                        <th style="width:60%;">Question</th>
                        <th style="width:40%;">Answer</th>
                    </tr>
                    <tr>
                        <td>How long will it take for my order to arrive</td>
                        <td>All standard orders will be shipped four to five business days of confirmation from our team
                            that they have received your order. If your order includes an item that we indicated will be
                            shippedat a later date, we will only ship the entire order out together once the item
                            arrives.</td>
                    </tr>
                    <tr>
                        <td>Can I return or exchange an item I bought on sale?</td>
                        <td>Unfortunately, all items purchased during a sale or marked at a discounted rate cannot be
                            exchanged or refunded. If you send them back to us for a return we will not be able to
                            process a refund. If you have any questions about sizing, fit, or fabric, please reach out
                            to our customer service before placing your order. </td>
                    </tr>
                    <tr>
                        <td>How do I place a return or exchange?</td>
                        <td>It’s our goal to ensure you have the best possible experience with us, and so we offer
                            returns valid for 30 days from the date of arrival. As such, you will be responsible for
                            paying for your own shipping costs for returning your item. </td>
                    </tr>
                    <tr>
                        <td>I think I got the sizing wrong on my order, can I exchange it for a different size?</td>
                        <td>We’re happy to send you the right size and do an exchange! Otherwise, we only replace items
                            if they have arrived defective or damaged. If you need to exchange it for the same item in a
                            different size, send us an email at rlfapparel@yahoo.com before sending your item. </td>
                    </tr>
                    <tr>
                        <td>Laughing Bacchus Winecellars</td>
                        <td>Canada</td>
                    </tr>
                    <tr>
                        <td>Magazzini Alimentari Riuniti</td>
                        <td>Italy</td>
                    </tr>
                    <tr>
                        <td>North/South</td>
                        <td>UK</td>
                    </tr>
                    <tr>
                        <td>Paris specialites</td>
                        <td>France</td>
                    </tr>
                </table>

                <script>
                function myFunction() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("myInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("myTable");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
                </script>
                </div> 
                
                <?php include 'footer.php';?>

</body>

</html>