<?php
class Test_stripe extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
	
	}

	public function demo()
	{
			error_reporting(E_All);
       require_once APPPATH."third_party/stripe/init.php";
	  
	   $GLOBALS["stripeCredential"] = 'sk_test_vKjrWnutm2nDYqkvmVfAsuDl';
	   	\Stripe\Stripe::setApiKey($GLOBALS["stripeCredential"]);
				
				$result = \Stripe\Token::create(
					array(
						"card" => array(
							"name" => 'deblina',
							"number" => '4242424242424242',
							"exp_month" => '12',
							"exp_year" => '2018',
							"cvc" =>'123'
						)
					)
				);
				//send invoice
				 $token = $result['id']; 
				
				$charge = \Stripe\Charge::create([
					'amount' => 19*100,
					'currency' => 'usd',
					'description' => 'Example charge',
					'source' => $token,
				]);
				
	   
						
					
			    echo "result"; print_r($charge->id);
    }
	
	
	
}
