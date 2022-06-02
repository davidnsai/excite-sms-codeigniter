<?php
namespace App\Controllers;
use App\Libraries\ExciteSms;

class Example extends BaseController
{


	public function send_sms()
	{
		$message = "Message you would like to send";
		$excite = new ExciteSms(); // Instantiation of ExciteSms Object
		$excite->setRecipient('RECEIPIENT HERE');//Phone number with country code. In the case of multiple numbers seperate using comma
		$excite->setSenderId('YOUR_SENDER_ID_HERE');//Sender ID provided to your account
		$excite->setType('MESSAGE_TYPE_HERE');// message type you would like to send
		$excite->setMessage($message);// Actual message you would ike to send

		return $excite->sendSms(); // perform the action of sending the message
	}
