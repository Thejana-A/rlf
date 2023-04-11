
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

<?php
    include("config.php");
    $order_id = $_POST['order_id'];
    $balance_payment= $_POST['balance_payment'];
    $token = $_POST["stripeToken"];
    $contact_name = $_POST["name"];
    $token_card_type = $_POST["stripeTokenType"];
    $phone           = $_POST["con"];
    $email           = $_POST["stripeEmail"];
    $address         = $_POST["address"];
    $amount          = $_POST["amount"]; 
    $desc            = $_POST["product_name"];
    $charge = \Stripe\Charge::create([
      "amount" => str_replace(",","",$amount) * 100,
      //"amount" => $amount,
      "currency" => 'lkr',
      "description"=>$desc,
      "source"=> $token,
    ]);

    if($charge){
      
      header("Location:success.php?amount=$amount&order_id=$order_id&balance_payment=$balance_payment");
    }
?>