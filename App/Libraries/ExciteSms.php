<?php
namespace App\Libraries;
class ExciteSms
{
	/**
	 * Configuration
	 *
	 * @var \App\Config\Excite
	 */
	protected $config;

	protected $recipient ="";//Number to send message. Use comma (,) to send multiple numbers. Ex. 31612345678,8801721970168

	protected $sender_id ="";//The sender of the message. This can be a telephone number (including country code) or an alphanumeric string. In case of an alphanumeric string, the maximum length is 11 characters.

	protected $type =""; //The type of the message. For text message you have to insert plain as sms type.

	protected $message =""; //The body of the SMS message.

	protected $schedule_time =""; //The scheduled date and time of the message in RFC3339 format (Y-m-d H:i)




	/**0
	 * __construct
	 *
	 * @author David Nsai
	 * @email davidnsai@davidnsai.me
	 * @website https://davidnsai.me
	 */
	public function __construct()
	{
		$this->config = config('Excite');
	}

	// begins all setters
	public function setRecipient(string $recipient)
	{
		$this->recipient = $recipient;
	}

	public function setSenderId(string $sender_id)
	{
		$this->sender_id = $sender_id;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

	public function setMessage($message)
	{
		$this->message = $message;
	}

	public function setScheduleTime(string $schedule_time)
	{
		$this->schedule_time= $schedule_time;
	}



 // Ends All setters

 //begins getters
 public function getRecipient()
 {
	 return $this->recipient;
 }

 public function getSenderId()
 {
	 return $this->sender_id;
 }

 public function getType()
 {
	 return $this->type;
 }

 public function getMessage()
 {
	 return $this->message;
 }

 public function getScheduleTime()
 {
	 return $this->schedule_time;
 }


 //ends all getters
 public function sendSms()
 {
 	$curl = curl_init();

 	curl_setopt_array($curl, array(
 	CURLOPT_URL => "https://gateway.excitesms.tech/api/v3/sms/send",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_SSL_VERIFYHOST=> 0,// Change value to 1 in a production environment
	CURLOPT_SSL_VERIFYPEER=> 0,//Change value to 1 in a production environment
 	CURLOPT_CUSTOMREQUEST => "POST",
 	CURLOPT_POSTFIELDS => json_encode([
	  	'recipient'=>$this->getRecipient(),
 			'sender_id'=>$this->getSenderId(),
 	 		'type'=>$this->getType(),
			'message' => $this->getMessage(),
		//	'schedule_time'=>$this->schedule_time,
		 ]

		),
 		CURLOPT_HTTPHEADER => [
 		"Accept: application/json",
 		"cache-control: no-cache",
 		"Authorization: Bearer ".$this->config->api_key
 		],
 		));

 		$response = curl_exec($curl);
 		$err = curl_error($curl);
		curl_close($curl);

 		if($err)
		{
 			// there was an error contacting the Excite API
 			die('Curl returned error: ' . $err);
			return $err;
 		}

 		$response = json_decode($response);

 	  return $response->status;
	}



}
