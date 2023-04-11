
<?php
session_start();
error_reporting(E_ERROR | E_PARSE);

$sname = "localhost";
$unmae = "root";
$password = "";
$db_name = "rlf";
$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$order_id = $_GET["order_id"];
$balance_payment = $_GET["balance_payment"];

// Prepare and bind statement
$stmt = $conn->prepare("UPDATE costume_order SET order_status=?, advance_payment=?, advance_payment_date=?, balance_payment=? WHERE order_id=?");
$stmt->bind_param("sisii", $status, $_GET["amount"], $advance_payment_date, $balance_payment, $order_id);

$status = "confirmed";
$advance_payment_date = date("Y-m-d");

// Execute statement
if ($stmt->execute()) {
    echo "Balance Payment is " . $balance_payment;
    
} else {
    echo "Error updating record: " . $conn->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap");
        .success-container {
            width: 50%;
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #bdc3c7;
            font-weight: bold;
            font-family: "Poppins", sans-serif;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <?php
        if (isset($_GET["amount"]) && !empty($_GET["amount"])) {

                echo "Your transaction has been successfully completed.";
                echo "Your order is confirmed.";

        }
        ?>
    </div>
</body>
</html>
