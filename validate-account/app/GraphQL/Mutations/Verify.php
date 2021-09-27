<?php

namespace App\GraphQL\Mutations;
use App\Models\User;

class Verify
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    //private $paystack=new array();
    public $account;
    public $paystack;

    public function __invoke($_, array $account){
        $this->account=$account;
        return $this->verifyAccountDetails();        
    }

    //function to verify account details with Levenshtein-Distance
    private function verifyAccountDetails(){
        //call paystack API
        $this->callPaystackApi();
		if($this->paystack->status=='true' && $this->paystack->message="Account number resolved") {
			if(levenshtein(strtolower($this->paystack->data->account_name), strtolower($this->account['user_account_name'])) <=2){
				//create new user in DB and return is_verified
				return $this->createUser();	
			}
			else{
				return "False";
			}
		}
		else{ 
			return $this->paystack->message;
		}      
    }

    private function callPaystackApi(){

    	/*
    	Receive bank_code and account_number from getAccountDetails()
    	call paystack api to verify account and return response to levenshteinDistance()
    	*/

    	$curl = curl_init();
        $url="https://api.paystack.co/bank/resolve?account_number=".$this->account['user_account_number']."&bank_code=".$this->account['user_bank_code']."";

  		//disables SSL Certificate Verification
  		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
  		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt_array($curl, array(
    		CURLOPT_URL => $url,
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_ENCODING => "",
    		CURLOPT_MAXREDIRS => 10,
    		CURLOPT_TIMEOUT => 30,
    		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    		CURLOPT_CUSTOMREQUEST => "GET",
    		CURLOPT_HTTPHEADER => array(
      		"Authorization: Bearer sk_test_47850d904d884af72f251c57b204146bf62efc8a",
      		"Cache-Control: no-cache",
    		),
  		));
  
	  $response = curl_exec($curl);
  	  $err = curl_error($curl);
  
	  curl_close($curl);
  
	  if ($err) {
	    return "cURL Error #:" . $err;
	  } 
	  else {
	    return $this->paystack=json_decode($response);
	  }
	}

	private function createUser(){
        $user = new User;
        $user->is_verified ="true";
		$user->user_account_number = $this->account['user_account_number'];
		$user->user_account_name = ucwords(strtolower($this->account['user_account_name']));
		$user->paystack_account_name = ucwords(strtolower($this->paystack->data->account_name));
		$user->user_bank_code = $this->account['user_bank_code'];
        $user->save();
		return $user->is_verified;
    }
}
