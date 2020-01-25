<?php
//error_reporting(E_ALL);
ini_set('max_execution_time', 0);
class Cron extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('ModelCron');
		$this->config->load('paypal_config');
		$this->controller = 'cron';
	}
	function sendPropetyNotification(){
		$previousDate = date('Y-m-d',strtotime('-1 days'));
		$newPropertyPoasted		= $this->ModelCron->getNewPropertyPoasted($previousDate);

		if(count($newPropertyPoasted)>0){
			foreach($newPropertyPoasted as $newProperty){
				$getMemberData = $this->ModelCron->getSavedPropetyMatchMember($newProperty);
				if(count($getMemberData)>0){
					foreach($getMemberData as $getMember){
						$to 			= $getMember['email'];
						$subject		= "KSC New Property Posted";
						$body			= "<tr><td>Hi,".$result['first_name']."</td></tr>
											<tr><td>New property has been added according to your matching in KSC Rent.</td></tr>";
						$this->functions->mail_template($to,$subject,$body);
					}
				}
			}
		}
	}
	function sendMail(){
		$to 			= 'bhanut974@gmail.com';
		$subject		= "KSC Test Cron";
		$body			= "<tr><td>Hi bhanu is this test cron</td></tr>
							<tr><td>New property has been added in KSC Rent.</td></tr>";
		$this->functions->mail_template($to,$subject,$body);
	}
}
?>
