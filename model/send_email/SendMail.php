<?php

require_once(__DIR__ . '/vendor/autoload.php');

class SendMail{

    private $recepientName;
    private $recepientEmail;
    private $otpCode;
    private $message;

    function __construct($recepientFirstName, $recepientLastName, $recepientEmail, $otpCode, $message) {
        $this->recepientName = $recepientFirstName." ".$recepientLastName;
        $this->recepientEmail = $recepientEmail;
        $this->otpCode = $otpCode;
        $this->message = $message;   
    }

    public function sendTheEmail(){
        $credentials = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');
        $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(new GuzzleHttp\Client(),$credentials);

        $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
            'subject' => 'from the PHP SDK!',
            'sender' => ['name' => 'Sendinblue', 'email' => 'rlfapparelfactory@gmail.com'],
            'replyTo' => ['name' => 'Sendinblue', 'email' => 'rlfapparelfactory@gmail.com'],
            'to' => [[ 'name' => $this->recepientName, 'email' => $this->recepientEmail]],
            'htmlContent' => '<html><body><h3>Your OTP code is '.$this->otpCode.'</h3><p>'.$this->message.'</p></body></html>',
            'params' => ['bodyMessage' => 'made just for you!']
        ]);

        try {
            $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
            //print_r($result);
        } catch (Exception $e) {
            echo $e->getMessage(),PHP_EOL;
        }

    }

}

?>
