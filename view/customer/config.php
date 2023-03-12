<?php
    require_once "stripe-php-master/init.php";

    $stripeDetails = array(
        "secretKey" => "sk_test_51Mg1uMKtrRPeZUTDtY16hNxVgjfiLP5PeyGdTWGC852sjH7cQYvRBBvx0tX85DJPz01WWCWoZcnnSsynnkjrBQvD00ixkRRQQJ",
        "publishableKey" => "pk_test_51Mg1uMKtrRPeZUTD5DADleqtWHCbg1DRUd8I0ivYuVt5crq5lfxSrAjyFJpsYwxB9fIUBOrQMqPtALMzt1cTgOOY006RIWo8Fp"
    );

    \Stripe\Stripe::setApiKey($stripeDetails["secretKey"]);
?>