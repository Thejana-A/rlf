<?php session_start();
    error_reporting(E_ERROR | E_PARSE);
    $sname= "localhost";
    $unmae= "root";
    $password = "";
    $db_name = "rlf";
    $conn = mysqli_connect($sname, $unmae, $password, $db_name);

    $order_id = $_GET['order_id'];
    $quotation_id = $_GET['quotation_id'];
    $total_price = $_GET['total_price'];
    $costume_name = $_GET['costume_name'];

    $advance_payment = ($total_price*40)/100;
    $balance_payment = ($total_price-$advance_payment);
    //print_r($quotation_id);
?>
<!DOCTYPE html>
<head>
    <title>Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="customer_css.css" />
</head>
<body style="background-image: url('../image/payment.jpg'); 
min-height:100%;
background-size: cover;
background-position: center; 
background-repeat: no-repeat; 
background-attachment: fixed;
margin: 0;
padding: 0;">
<button type="button" onclick="goback()" class="back">Go Back</button>
<form action="" method="post"  class="payment">

    <label for="name"><b>Customer Name</b></label>
    <input type="text"  value="<?php echo  $_SESSION['first_name']." ".$_SESSION['last_name'] ;?>" name="name" disabled>

    <input type="hidden" name="user_id" value="">

    <label for="username"><b>Address</b></label>
    <input type="text" value="<?php echo $_SESSION['city']?>" name="address" disabled>

        <label for="email"><b>Contact Number</b></label>
    <input type="text" value="<?php echo $_SESSION['contact_no']?>" name="con" disabled>

    <label for="contact"><b>Design Name</b></label>
    <input type="text" value="<?php echo $costume_name ?>" name="designname" disabled>

    <label for="address"><b>Price</b></label>
    <input type="text" value="Rs <?php echo $advance_payment ?>" name="price" disabled>


    <br />
    <br />
    <button type="pay" class="btn" name="signup">Pay with Card</button>


  </form>
  <script>
    function goback(){
        window.history.go(-1);
    }

    $('#ph').on('keypress',function(){
         var text = $(this).val().length;
         if(text > 9){
              return false;
         }else{
            $('#ph').text($(this).val());
         }
         
    });
</script>

</body>
</html>